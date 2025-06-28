<?php

namespace App\Filament\Resources\AlternatifResource\Pages;

use App\Filament\Resources\AlternatifResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;


class CreateAlternatif extends CreateRecord
{
    protected static string $resource = AlternatifResource::class;
//     public function getHeaderActions(): array
// {
//     return [
//         Action::make('kembali')
//             ->label('Kembali ke daftar')
//             ->icon('heroicon-m-arrow-left')
//             ->url(route('filament.admin.resources.Alternatifs.index'))
//             ->color('blue'),
//     ];
// }
}
