<?php

namespace App\Enums;

enum PostStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Archived = 'archived';
    case PendingReview = 'pending_review';

    // Mooi label voor Filament
    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Published => 'Published',
            self::Archived => 'Archived',
            self::PendingReview => 'Pending Review',
        };
    }

    // Kleur voor Filament badges
    public function color(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Published => 'success',
            self::Archived => 'danger',
            self::PendingReview => 'warning',
        };
    }
}
