<?php

namespace App\Filament\Resources\AlterskorResource\Pages;

use App\Filament\Resources\AlterskorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlterskors extends ListRecords
{
    protected static string $resource = AlterskorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
