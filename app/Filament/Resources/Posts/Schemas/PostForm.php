<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\PostStatus;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('categories')
                    ->multiple()
                    ->preload()
                    ->relationship('categories', 'name'),

                Select::make('tags')
                    ->multiple()
                    ->preload()
                    ->relationship('tags', 'name'),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(auth()->id())
                    ->disabled(fn($operation) => $operation === 'edit')
                    ->required()
                    ->searchable(),
                Select::make('status')
                    ->options(PostStatus::class)
                    ->enum(PostStatus::class)
                    ->default(PostStatus::Draft)
                    ->required(),
                TextInput::make('title')
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
                Textarea::make('excerpt')
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
