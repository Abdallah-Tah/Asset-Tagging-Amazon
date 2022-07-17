<?php

namespace App\Filament\Resources\SubsistenceResource\Pages;

use App\Filament\Resources\SubsistenceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubsistences extends ListRecords
{
    protected static string $resource = SubsistenceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
