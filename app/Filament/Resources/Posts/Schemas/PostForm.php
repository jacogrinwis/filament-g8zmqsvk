<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\UserRole;
use App\Enums\PostStatus;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
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
                    ->disabled(fn() => auth()->user()->role !== UserRole::Admin)
                    ->preload()
                    ->required()
                    ->searchable(),

                Select::make('status')
                    ->options(PostStatus::class)
                    ->enum(PostStatus::class)
                    ->default(PostStatus::Draft)
                    ->required(),

                Toggle::make('is_featured')
                    ->label('Featured')
                    ->default(false),

                TextInput::make('title')
                    ->live()
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->required(),

                TextInput::make('slug')
                    ->required(),

                Textarea::make('excerpt')
                    ->columnSpanFull(),

                MarkdownEditor::make('content')
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('thumbnail')
                    ->image()
                    ->directory('posts')
                    ->required(false)
                    ->imageEditor()
                    ->maxSize(2048)
                    ->columnSpanFull(),
            ]);
    }
}
