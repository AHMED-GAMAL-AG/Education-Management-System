<?php

namespace App\Filament\Resources\DiplomaResource\Pages;

use App\Filament\Resources\DiplomaResource;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;

class CreateDiploma extends CreateRecord
{
    use HasWizard;

    protected static string $resource = DiplomaResource::class;

    public function form(Form $form): Form
    {
        return parent::form($form)
            ->schema([
                Wizard::make($this->getSteps())
                    ->startOnStep($this->getStartStep())
                    ->cancelAction($this->getCancelFormAction())
                    ->submitAction($this->getSubmitFormAction())
                    ->skippable($this->hasSkippableSteps())
                    ->contained(false),
            ])
            ->columns(null);
    }

    /** @return Step[] */
    protected function getSteps(): array
    {
        return [
            Step::make('Diploma Details')
                ->schema([
                    Section::make()->schema(DiplomaResource::getDetailsFormSchema())->columns(),
                ]),

            Step::make('Diploma Items')
                ->schema([
                    Section::make()->schema([
                        DiplomaResource::getItemsRepeater(),
                    ]),
                ]),
        ];
    }
}
