<?php

namespace App\Filament\Resources\PaycheckResource\Pages;

use App\Filament\Resources\PaycheckResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaycheck extends CreateRecord
{
    protected static string $resource = PaycheckResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['amount'] = $data['amount'] * 100 / 3;

        return $data;
    }
}
