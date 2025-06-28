<?php

namespace App\Filament\Resources\IsiAlternatifResource\Pages;

use App\Filament\Resources\IsiAlternatifResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIsiAlternatifs extends ListRecords
{
    protected static string $resource = IsiAlternatifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
