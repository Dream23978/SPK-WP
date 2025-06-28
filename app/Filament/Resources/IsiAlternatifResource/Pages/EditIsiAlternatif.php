<?php

namespace App\Filament\Resources\IsiAlternatifResource\Pages;

use App\Filament\Resources\IsiAlternatifResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIsiAlternatif extends EditRecord
{
    protected static string $resource = IsiAlternatifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
