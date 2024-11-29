<?php

namespace App\Filament\Resources\HikingStatusResource\Pages;

use App\Filament\Resources\HikingStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHikingStatus extends EditRecord
{
    protected static string $resource = HikingStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
