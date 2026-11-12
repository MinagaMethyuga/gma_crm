<?php

namespace App\Concerns;

use App\Data\Countries;
use App\Data\Languages;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

trait ProfileValidationRules
{
    /**
     * Get the validation rules used to validate user profiles.
     *
     * @return array<string, array<int, ValidationRule|array<mixed>|string>>
     */
    protected function profileRules(?int $userId = null): array
    {
        return [
            'name' => $this->nameRules(),
            'email' => $this->emailRules($userId),
        ];
    }

    /**
     * Get the validation rules used to validate a user's organization details.
     *
     * These are optional when editing an existing profile, since accounts
     * created before these fields existed hold no values.
     *
     * @return array<string, array<int, ValidationRule|array<mixed>|string>>
     */
    protected function organizationRules(bool $required = false): array
    {
        $presence = $required ? 'required' : 'nullable';

        return [
            'phone' => [$presence, 'string', 'max:20'],
            'company_name' => [$presence, 'string', 'max:255'],
            'industry' => [$presence, 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'physical_address' => [$presence, 'string', 'max:1000'],
            'company_website' => [$presence, 'string', 'max:255'],
            'country' => [$presence, 'string', 'max:255', Rule::in(Countries::codes())],
        ];
    }

    /**
     * Get the validation rules used to validate a user's chosen language.
     *
     * @return array<string, array<int, ValidationRule|array<mixed>|string>>
     */
    protected function languageRules(): array
    {
        return [
            'preferred_language' => ['nullable', 'string', Rule::in(Languages::codes())],
        ];
    }

    /**
     * Get the validation rules used to validate user names.
     *
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    protected function nameRules(): array
    {
        return ['required', 'string', 'max:255'];
    }

    /**
     * Get the validation rules used to validate user emails.
     *
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    protected function emailRules(?int $userId = null): array
    {
        return [
            'required',
            'string',
            'email',
            'max:255',
            $userId === null
                ? Rule::unique(User::class)
                : Rule::unique(User::class)->ignore($userId),
        ];
    }
}
