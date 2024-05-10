<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\DiplomaResource;
use App\Models\Diploma;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestDiplomas extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(DiplomaResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->sortable(),

                TextColumn::make('subjects_count')
                    ->counts('subjects')
                    ->formatStateUsing(fn ($state) => $state <= 1 ? $state . ' ' . __('subject') : $state . ' ' . __('subjects')),

                TextColumn::make('created_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable()
                    ->date(),

                TextColumn::make('updated_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable()
                    ->date(),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->url(fn (Diploma $record): string => DiplomaResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
