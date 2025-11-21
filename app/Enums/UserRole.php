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

    public function color(): string
    {
        return match ($this) {
            self::User => 'gray',
            self::Editor => 'primary',
            self::Admin => 'danger',
        };
    }
}
