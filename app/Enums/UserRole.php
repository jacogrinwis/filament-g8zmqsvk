<?php

namespace App\Enums;

enum UserRole: string
{
    case User = 'user';
    case Editor = 'editor';
    case Admin = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::User => 'User',
            self::Editor => 'Editor',
            self::Admin => 'Admin',
        };
    }

    public static function labels(): array
    {
        $out = [];
        foreach (self::cases() as $case) {
            $out[$case->value] = $case->label();
        }
        return $out;
    }

    public function color(): string
    {
        return match ($this) {
            self::User => 'gray',
            self::Editor => 'primary',
            self::Admin => 'danger',
        };
    }
}
