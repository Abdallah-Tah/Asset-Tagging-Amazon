<?php

namespace App\Filament\Resources\PaycheckResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Contracts\View\View;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PaycheckResource;

class ListPaychecks extends ListRecords
{
    protected static string $resource = PaycheckResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableContentFooter(): View
    {
        return view('filament/paychecks/footer');
    }
}
