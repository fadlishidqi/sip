<?php

namespace App\Filament\Resources\PendakiResource\Pages;

use App\Filament\Resources\PendakiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendaki extends EditRecord
{
    protected static string $resource = PendakiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
