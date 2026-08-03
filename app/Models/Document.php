<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_path',
        'original_filename',
        'mime_type',
        'is_public',
        'uploaded_by',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    public function isPublic(): bool
    {
        return $this->is_public;
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'document_plan');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf';
    }

    public function isWord(): bool
    {
        return in_array($this->mime_type, [
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
    }

    public function getIconClass(): string
    {
        return $this->isPdf() ? 'picture_as_pdf' : 'article';
    }

    public function getIconColor(): string
    {
        return $this->isPdf() ? 'text-red-500' : 'text-blue-500';
    }

    protected static function booted(): void
    {
        static::deleting(function (Document $document) {
            if ($document->file_path && Storage::disk('local')->exists($document->file_path)) {
                Storage::disk('local')->delete($document->file_path);
            }
        });
    }
}
