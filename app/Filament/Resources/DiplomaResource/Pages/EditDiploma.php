<?php

namespace App\Filament\Resources\DiplomaResource\Pages;

use App\Filament\Resources\DiplomaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiploma extends EditRecord
{
    protected static string $resource = DiplomaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
