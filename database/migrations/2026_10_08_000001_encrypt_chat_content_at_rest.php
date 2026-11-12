<?php

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Encrypt message/report/translation bodies already sitting in the
     * database as plaintext, matching the `encrypted` and `encrypted:array`
     * casts added to the models in this release.
     *
     * Rows are read at the raw DB layer so the new casts never try to decrypt
     * a still-plaintext value. Each cell is probed with decryptString() first:
     * if it decrypts cleanly it was already encrypted and is left alone, which
     * keeps the migration safe to re-run.
     *
     * The methods below are non-static so they can be unit-tested outside the
     * schema lifecycle; resolve() lifecycles here costs nothing.
     */
    public function up(): void
    {
        $this->encryptTextColumn('community_group_messages', 'message');
        $this->encryptTextColumn('direct_messages', 'message');
        $this->encryptTextColumn('community_message_reports', 'message_snapshot');
        $this->encryptTextColumn('community_message_reports', 'details');
        $this->encryptTextColumn('message_translations', 'source_text');
        $this->encryptTextColumn('message_translations', 'translated_text');
        $this->encryptJsons('notifications', 'data');
    }

    public function down(): void
    {
        // Eloquent only handles the crypto; there is no reversible schema
        // change here. Remaining encrypted values decrypt transparently via
        // the casts, so nothing needs to run in reverse.
    }

    /**
     * Encrypt a plaintext `text` column in-place, skipping NULL and values
     * that already decrypt successfully.
     */
    private function encryptTextColumn(string $table, string $column): void
    {
        DB::table($table)
            ->orderBy('id')
            ->select('id', $column)
            ->chunkById(500, function ($rows) use ($table, $column) {
                foreach ($rows as $row) {
                    $value = $row->{$column};
                    if ($value === null) {
                        continue;
                    }
                    if ($this->isEncrypted($value)) {
                        continue;
                    }
                    DB::table($table)
                        ->where('id', $row->id)
                        ->update([$column => Crypt::encryptString($value)]);
                }
            });
    }

    /**
     * Encrypt the JSON payload of a row written through the notifications
     * pipeline. The `encrypted:array` cast stores encryptString(json), so the
     * stored JSON string is wrapped in the same way rather than re-encoded.
     */
    private function encryptJsons(string $table, string $column): void
    {
        DB::table($table)
            ->select('id', $column)
            ->orderBy('id')
            ->chunkById(500, function ($rows) use ($table, $column) {
                foreach ($rows as $row) {
                    $value = $row->{$column};
                    if ($value === null) {
                        continue;
                    }
                    if ($this->isEncrypted($value)) {
                        continue;
                    }
                    DB::table($table)
                        ->where('id', $row->id)
                        ->update([$column => Crypt::encryptString($value)]);
                }
            });
    }

    private function isEncrypted(string $value): bool
    {
        try {
            Crypt::decryptString($value);

            return true;
        } catch (DecryptException) {
            return false;
        }
    }
};
