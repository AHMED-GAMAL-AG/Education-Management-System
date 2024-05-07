<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Get the tabs for the ListUsers page.
     *
     * @return array The array of tabs.
     */
    public function getTabs(): array
    {
        $role_names = Role::pluck('name', 'name');

        // make a tab for each role
        foreach ($role_names as $name) {
            $tabs[$name] = Tab::make(label: $name)
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('roles', function ($query) use ($name) {
                    $query->where('name', $name);
                }));
        }

        return [
            'all' => Tab::make(label: 'All'),
            ...$tabs,
        ];
    }
}
