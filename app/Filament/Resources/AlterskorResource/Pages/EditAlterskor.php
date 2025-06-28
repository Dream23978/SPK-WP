<?php

namespace App\Filament\Resources\AlterskorResource\Pages;

use App\Filament\Resources\AlterskorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlterskor extends EditRecord
{
    protected static string $resource = AlterskorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
