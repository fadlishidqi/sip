<?php

namespace App\Filament\Resources\HikingStatusResource\Pages;

use App\Filament\Resources\HikingStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHikingStatuses extends ListRecords
{
    protected static string $resource = HikingStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
