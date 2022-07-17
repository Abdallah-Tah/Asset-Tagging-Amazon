<?php

namespace App\Filament\Resources\SubsistenceResource\Pages;

use Carbon\Carbon;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SubsistenceResource;

class CreateSubsistence extends CreateRecord
{
    protected static string $resource = SubsistenceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $formatted_dt1 = Carbon::parse($data['from'])->format('Y-m-d');
        $formatted_dt2 = Carbon::parse($data['to'])->format('Y-m-d');

        $number_days = Carbon::parse($formatted_dt2)->diffInDays(Carbon::parse($formatted_dt1)) + 1;

        $data['amount'] = (($data['amount'] * $number_days) * 100);

        return $data;
    }
}
