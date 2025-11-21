<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class UsersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email Address')
                    ->required()
                    ->unique()
                    ->email()
                    ->maxLength(255),
                TextInput::make('password')
                    ->label('Wachtwoord')
                    ->password()
                    ->required(fn(string $context): bool => $context === 'create')
                    ->confirmed()
                    ->minLength(8)
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state))
                    ->maxLength(255),
                TextInput::make('password_confirmation')
                    ->label('Bevestig wachtwoord')
                    ->password()
                    ->required(fn(string $context): bool => $context === 'create')
                    ->maxLength(255),
                Radio::make('role')
                    ->options(UserRole::labels())
                    ->default('user')
                    // ->inline()
                    ->required(),
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->disabled(fn($record) => $record?->id === auth()->id()),
            ]);
    }
}
