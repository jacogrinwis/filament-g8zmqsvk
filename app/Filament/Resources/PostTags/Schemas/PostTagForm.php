<?php

namespace App\Filament\Resources\PostTags\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class PostTagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->live()
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    // ->afterStateUpdated(function (Get $get, Set $set, ?string $operation, ?string $old, ?string $state, ?Model $record) {

                    //     if ($operation == 'edit' && $record->isPublished()) {
                    //         return;
                    //     }

                    //     if (($get('slug') ?? '') !== Str::slug($old)) {
                    //         return;
                    //     }

                    //     $set('slug', Str::slug($state));
                    // })
                    ->required(),
                TextInput::make('slug')
                    ->required(),
            ]);
    }
}
