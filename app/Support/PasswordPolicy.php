<?php

namespace App\Support;

use Illuminate\Validation\Rules\Password;

final class PasswordPolicy
{
    public const MIN_LENGTH = 12;

    public static function rule(): Password
    {
        return Password::min(self::MIN_LENGTH)
            ->mixedCase()
            ->numbers()
            ->symbols();
    }

    /**
     * @return list<string>
     */
    public static function requirements(): array
    {
        return [
            'Au moins '.self::MIN_LENGTH.' caractères',
            'Au moins une lettre majuscule et une lettre minuscule',
            'Au moins un chiffre',
            'Au moins un symbole',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function messages(string $attribute = 'password'): array
    {
        return [
            $attribute.'.min' => 'Le mot de passe doit contenir au moins '.self::MIN_LENGTH.' caractères.',
            'password.mixed' => 'Le mot de passe doit contenir au moins une lettre majuscule et une lettre minuscule.',
            'password.numbers' => 'Le mot de passe doit contenir au moins un chiffre.',
            'password.symbols' => 'Le mot de passe doit contenir au moins un symbole.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function attributes(string $attribute = 'password'): array
    {
        return [$attribute => 'mot de passe'];
    }
}