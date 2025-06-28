<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlterskorResource\Pages;
use App\Filament\Resources\AlterskorResource\RelationManagers;
use App\Models\Alterskor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AlterskorResource extends Resource
{
    protected static ?string $model = Alterskor::class;
    protected static ?string $label = ' nilai alternatif';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('kode_alternatif')
                ->options([
                    'A1' => 'A1',
                    'A2' => 'A2',
                    'A3' => 'A3',
                    'A4' => 'A4',
                    'A5' => 'A5',  ])
                      ->searchable()
                      ->native(false),


                textInput::make('nama_alternatif')
                    ->required(),

                textInput::make('C1')
                ->required(),

                textInput::make('C2')
                ->required(),

                textInput::make('C3')
                ->required(),

                textInput::make('C4')
                ->required(),

                textInput::make('C5')
                ->required(),

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("nama_alternatif")
                ->label("Nama Alternatif")
                ->sortable()
                ->searchable(),

                TextColumn::make('kode_alternatif')
                ->sortable()
                ->searchable(),

                TextColumn::make('C1')
                ->sortable()
                ->searchable(),
                TextColumn::make('C2')
                ->sortable()
                ->searchable(),
                TextColumn::make('C3')
                ->sortable()
                ->searchable(),
                TextColumn::make('C4')
                ->sortable()
                ->searchable(),
                TextColumn::make('C5')
                ->sortable()
                ->searchable(),





            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlterskors::route('/'),
            'create' => Pages\CreateAlterskor::route('/create'),
            'edit' => Pages\EditAlterskor::route('/{record}/edit'),
        ];
    }
}
