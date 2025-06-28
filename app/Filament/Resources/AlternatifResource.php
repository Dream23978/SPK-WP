<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlternatifResource\Pages;
use App\Models\Alternatif;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Actions\Action;

class AlternatifResource extends Resource
{
    protected static ?string $model = Alternatif::class;
    protected static ?string $label = '1. Bobot Kriteria';
    protected static ?string $navigationLabel = '1.Isi Skor';
    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('Kriteria')
                    ->options([
                        'C1' => 'C1',
                        'C2' => 'C2',
                        'C3' => 'C3',
                        'C4' => 'C4',
                        'C5' => 'C5',
                        'C6' => 'C6',
                    ])
                    ->native(false)
                    ->searchable(),

                TextInput::make('Nama Kriteria')
                    ->required(),

                TextInput::make('bobot')
                    ->required()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $total = Alternatif::sum('bobot') + $state;

                        if ($total > 0) {

                            $normalized =$state / $total * 1000000 ;
                            $set('normalized_bobot', $normalized);
                        }
                    }),

                Hidden::make('normalized_bobot'),

                Select::make('type')
                    ->options([
                        'benefit' => 'Benefit',
                        'cost' => 'Cost',
                    ])
                    ->native(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Kriteria')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('Nama Kriteria')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('bobot')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('normalized_bobot')
                    ->label('Bobot Ternormalisasi')
                    ->formatStateUsing(fn ($state) => number_format(floor($state * 1000) / 1000, 2)),

                TextColumn::make('type')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Action::make('normalize')
                    ->label('Hitung Normalisasi')
                    ->icon('heroicon-o-calculator')
                    ->color('success')
                    ->requiresConfirmation()
                    ->successNotificationTitle('Bobot berhasil dinormalisasi ulang!')
                    ->action(function () {
                        self::normalizeAllBobot();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function normalizeAllBobot(): void
    {
        $total = Alternatif::sum('bobot');

        if ($total > 0) {
            foreach (Alternatif::all() as $alternatif) {
                $alternatif->normalized_bobot = floor(($alternatif->bobot / $total) * 1000000) / 1000000;
                $alternatif->save();
            }
        }
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlternatifs::route('/'),
            'create' => Pages\CreateAlternatif::route('/create'),
            'edit' => Pages\EditAlternatif::route('/{record}/edit'),
        ];
    }
}
