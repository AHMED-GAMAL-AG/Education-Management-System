<?php

namespace App\Filament\Resources;

use App\Enums\DiplomaStatus;
use App\Filament\Resources\DiplomaResource\Pages;
use App\Filament\Resources\DiplomaResource\RelationManagers;
use App\Models\Diploma;
use App\Models\Subject;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiplomaResource extends Resource
{
    protected static ?string $model = Diploma::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $slug = 'diplomas';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Blog';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema(static::getDetailsFormSchema())
                            ->columns(2),

                        Forms\Components\Section::make('Diploma items')
                            ->headerActions([
                                Action::make('reset')
                                    ->modalHeading('Are you sure?')
                                    ->modalDescription('All existing items will be removed from the diploma.')
                                    ->requiresConfirmation()
                                    ->color('danger')
                                    ->action(fn (Forms\Set $set) => $set('items', [])),
                            ])
                            ->schema([
                                static::getItemsRepeater(),
                            ]),
                    ])
                    ->columnSpan(['lg' => fn (?Diploma $record) => $record === null ? 3 : 2]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Diploma $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Diploma $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Diploma $record) => $record === null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiplomas::route('/'),
            'create' => Pages\CreateDiploma::route('/create'),
            'edit' => Pages\EditDiploma::route('/{record}/edit'),
        ];
    }

    /** @return Forms\Components\Component[] */
    public static function getDetailsFormSchema(): array
    {
        return [
            TextInput::make('code')
                ->default('DP-' . random_int(100000, 999999))
                ->disabled()
                ->dehydrated()
                ->required()
                ->maxLength(32)
                ->unique(Diploma::class, 'code', ignoreRecord: true),

            TextInput::make('name')
                ->maxLength(255)
                ->required(),

            ToggleButtons::make('status')
                ->inline()
                ->options(DiplomaStatus::class)
                ->required(),

            MarkdownEditor::make('description')
                ->columnSpan('full')
                ->required(),
        ];
    }

    public static function getItemsRepeater(): Repeater
    {
        return Repeater::make('subjects')
            ->relationship()
            ->schema([
                Forms\Components\Select::make('subject_id')
                    ->live()
                    ->label('Subject')
                    ->options(Subject::query()->pluck('name', 'id'))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('code', Subject::find($state)?->code ?? 0))
                    ->distinct()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->columnSpan([
                        'md' => 5,
                    ])
                    ->searchable(),

                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->suffix('EGP')
                    ->columnSpan([
                        'md' => 2,
                    ])
                    ->required(),

                Forms\Components\TextInput::make('code')
                    ->label('Code')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->columnSpan([
                        'md' => 3,
                    ]),
            ])
            ->extraItemActions([
                Action::make('openSubject')
                    ->tooltip('Open subject')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->url(function (array $arguments, Repeater $component): ?string {
                        $itemData = $component->getRawItemState($arguments['item']);

                        $subject = Subject::find($itemData['subject_id']);

                        if (!$subject) {
                            return null;
                        }

                        return SubjectResource::getUrl('edit', ['record' => $subject]);
                    }, shouldOpenInNewTab: true)
                    ->hidden(fn (array $arguments, Repeater $component): bool => blank($component->getRawItemState($arguments['item'])['subject_id'])),
            ])
            ->defaultItems(1)
            ->hiddenLabel()
            ->columns([
                'md' => 10,
            ])
            ->required();
    }
}
