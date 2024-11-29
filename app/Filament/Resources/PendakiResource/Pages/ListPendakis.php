<?php

namespace App\Filament\Resources\PendakiResource\Pages;

use App\Filament\Resources\PendakiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendakis extends ListRecords
{
    protected static string $resource = PendakiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
