<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Enums\PostStatus;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('views')
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('author.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('activeCategories.name')
                    ->label('Categories')
                    ->badge()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('activeTags.name')
                    ->label('Tags')
                    ->badge()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => $state->label())
                    ->color(fn($state) => $state->color())
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                IconColumn::make('is_featured')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // SelectFilter::make('user')
                //     ->label('Auteur')
                //     ->relationship('user', 'name', fn($query) => $query->where('is_active', true)),
                SelectFilter::make('user')
                    ->label('Auteur')
                    ->multiple() // kies meerdere auteurs tegelijk
                    ->relationship('user', 'name'),
                SelectFilter::make('category')
                    ->label('Categorie')
                    ->multiple()
                    ->relationship('categories', 'name'),
                SelectFilter::make('tags')
                    ->label('Tags')
                    ->multiple()
                    ->relationship('tags', 'name'),
                SelectFilter::make('status')
                    ->multiple()
                    ->options(
                        collect(PostStatus::cases())
                            ->mapWithKeys(fn($s) => [$s->value => $s->label()])
                            ->toArray()
                    ),
                Filter::make('is_featured')
                    ->query(fn($query, $state) => $query->where('is_featured', $state))
                    ->toggle(),
                Filter::make('created_at')
                    ->label('Aangemaakt tussen')
                    ->schema([
                        DatePicker::make('created_from')
                            ->label('Start datum'),

                        DatePicker::make('created_until')
                            ->label('Eind datum'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
