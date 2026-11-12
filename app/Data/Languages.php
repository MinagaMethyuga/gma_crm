<?php

namespace App\Data;

class Languages
{
    /**
     * The language used when a user has not chosen one yet.
     */
    public const DEFAULT = 'en';

    /**
     * BCP 47 language tag => native language name.
     *
     * The native name is shown in the select so a user can find their own
     * language without having to read it in English.
     *
     * @var array<string, string>
     */
    public const NAMES = [
        'ar' => 'العربية',
        'az' => 'Azərbaycan dili',
        'be' => 'Беларуская',
        'bn' => 'বাংলা',
        'bg' => 'Български',
        'ca' => 'Català',
        'cs' => 'Čeština',
        'da' => 'Dansk',
        'de' => 'Deutsch',
        'el' => 'Ελληνικά',
        'en' => 'English',
        'es' => 'Español',
        'et' => 'Eesti',
        'eu' => 'Euskara',
        'fa' => 'فارسی',
        'fi' => 'Suomi',
        'fil' => 'Filipino',
        'fr' => 'Français',
        'ga' => 'Gaeilge',
        'gl' => 'Galego',
        'he' => 'עברית',
        'hi' => 'हिन्दी',
        'hr' => 'Hrvatski',
        'hu' => 'Magyar',
        'hy' => 'Հայերեն',
        'id' => 'Bahasa Indonesia',
        'is' => 'Íslenska',
        'it' => 'Italiano',
        'ja' => '日本語',
        'ka' => 'ქართული',
        'km' => 'ភាសាខ្មែរ',
        'kn' => 'ಕನ್ನಡ',
        'ko' => '한국어',
        'lt' => 'Lietuvių',
        'lv' => 'Latviešu',
        'mk' => 'Македонски',
        'ms' => 'Bahasa Melayu',
        'nl' => 'Nederlands',
        'no' => 'Norsk',
        'pl' => 'Polski',
        'pt' => 'Português',
        'pt_BR' => 'Português (Brasil)',
        'ro' => 'Română',
        'ru' => 'Русский',
        'sk' => 'Slovenčina',
        'sl' => 'Slovenščina',
        'sq' => 'Shqip',
        'sr' => 'Српски',
        'sv' => 'Svenska',
        'sw' => 'Kiswahili',
        'ta' => 'தமிழ்',
        'te' => 'తెలుగు',
        'th' => 'ไทย',
        'tr' => 'Türkçe',
        'uk' => 'Українська',
        'ur' => 'اردو',
        'uz' => 'Oʻzbekcha',
        'vi' => 'Tiếng Việt',
        'zh_CN' => '简体中文',
        'zh_TW' => '繁體中文',
        'zu' => 'isiZulu',
    ];

    /**
     * Locales Carbon knows by a different name than the BCP 47 tag.
     *
     * @var array<string, string>
     */
    private const CARBON_LOCALES = [
        'no' => 'nb',
    ];

    /**
     * @return array<string, string>
     */
    public static function all(): array
    {
        return self::NAMES;
    }

    /**
     * @return array<int, string>
     */
    public static function codes(): array
    {
        return array_keys(self::NAMES);
    }

    public static function default(): string
    {
        return self::DEFAULT;
    }

    public static function isValid(?string $value): bool
    {
        return $value !== null && isset(self::NAMES[$value]);
    }

    /**
     * Resolve a stored value to a supported language tag.
     *
     * Accounts created before the preference existed hold no value, so an
     * empty or unrecognised tag falls back to the default language.
     */
    public static function resolve(?string $value): string
    {
        return self::isValid($value) ? (string) $value : self::DEFAULT;
    }

    /**
     * Resolve a stored value to a readable language name.
     */
    public static function name(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        return self::NAMES[$value] ?? trim($value);
    }

    /**
     * Resolve a stored value to a locale Carbon can format dates with.
     */
    public static function carbonLocale(?string $value): string
    {
        $code = self::resolve($value);

        return self::CARBON_LOCALES[$code] ?? $code;
    }
}
