<?php

namespace App\Helpers;

// class TableStyles
// {
//     public static function inactiveAuthorRow($record): string
//     {
//         return $record->user?->is_active ? '' : 'bg-gray-50 dark:bg-gray-800';
//     }

//     public static function inactiveAuthorTitle($record): string
//     {
//         return $record->user?->is_active ? '' : 'opacity-50 line-through text-gray-500';
//     }
// }

class TableStyles
{
    public static function inactiveAuthorRow($record, $isUserTable = false): string
    {
        $active = $isUserTable ? $record->is_active : $record->user?->is_active;
        return $active ? '' : 'bg-gray-50 dark:bg-gray-800';
    }

    public static function inactiveAuthorTitle($record, $isUserTable = false): string
    {
        $active = $isUserTable ? $record->is_active : $record->user?->is_active;
        return $active ? '' : 'opacity-50 line-through text-gray-500';
    }
}
