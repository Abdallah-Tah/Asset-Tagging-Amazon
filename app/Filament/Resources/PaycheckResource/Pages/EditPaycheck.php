<?php

namespace App\Filament\Resources\PaycheckResource\Pages;

use App\Filament\Resources\PaycheckResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaycheck extends EditRecord
{
    protected static string $resource = PaycheckResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {

        $data['amount'] = number_format(($data['amount'] * 3) / 100, 2);
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['amount'] = $data['amount'] * 100 / 3;
        return $data;
    }
}
