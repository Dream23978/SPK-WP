<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HasilResource\Pages;
use App\Models\alterskor;
use App\Models\Alternatif; // <-- Tambahin ini!
use App\Models\HasilSpk;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;

class HasilResource extends Resource
{
    protected static ?string $model = HasilSpk::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_alternatif')
                    ->label('Kode Alternatif')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama_alternatif')
                    ->label('Nama Alternatif')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nilai_s')
                    ->label('Nilai S')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 3)),

                TextColumn::make('nilai_v')
                    ->label('Nilai V')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 3)),

                TextColumn::make('rank')
                    ->label('Peringkat')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state == 1 => 'success',
                        $state == 2 => 'warning',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('rank', 'asc')
            ->filters([])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                Action::make('hasil')
                    ->label('Hasilkan Keputusan')
                    ->icon('gmdi-alt-route-o')
                    ->color('success')
                    ->requiresConfirmation()
                    ->successNotificationTitle('Perhitungan WP berhasil dilakukan!')
                    ->action(function () {
                        $bobotMap = [];
                        $alternatifKriteria = Alternatif::all();

                        foreach ($alternatifKriteria as $kriteria) {
                            $kode = $kriteria->Kriteria;
                            $bobotMap[$kode] = [
                                'bobot' => (float) $kriteria->normalized_bobot,
                                'type' => $kriteria->type,
                            ];
                        }

                        $nilaiS = [];
                        $totalS = 0;
                        $alternatifs = alterskor::all();

                        foreach ($alternatifs as $alt) {
                            $s = 1;
                            foreach ($bobotMap as $kode => $info) {
                                $nilai = (float) $alt->{$kode};
                                if ($nilai <= 0) $nilai = 0.00001;

                                $bobot = $info['type'] === 'cost' ? -1 * $info['bobot'] : $info['bobot'];
                                $s *= pow($nilai, $bobot);
                            }

                            $nilaiS[] = [
                                'kode' => $alt->kode_alternatif,
                                'nama' => $alt->nama_alternatif,
                                's' => $s,
                            ];

                            $totalS += $s;
                        }

                        $hasilRanked = collect($nilaiS)
                            ->map(fn ($item) => [
                                ...$item,
                                'v' => $totalS > 0 ? $item['s'] / $totalS : 0,
                            ])
                            ->sortByDesc('v')
                            ->values();

                        HasilSpk::truncate();

                        foreach ($hasilRanked as $i => $hasil) {
                            HasilSpk::create([
                                'kode_alternatif' => $hasil['kode'],
                                'nama_alternatif' => $hasil['nama'],
                                'nilai_s' => round($hasil['s'], 3),
                                'nilai_v' => round($hasil['v'], 3),
                                'rank' => $i + 1,
                            ]);
                        }
                    })
                    ->after(fn () => redirect(request()->header('Referer'))),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHasils::route('/'),
            'create' => Pages\CreateHasil::route('/create'),
            'edit' => Pages\EditHasil::route('/{record}/edit'),
        ];
    }
}
