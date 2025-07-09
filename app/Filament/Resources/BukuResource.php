<?php

namespace App\Filament\Resources;

use App\Models\Buku;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use App\Filament\Resources\BukuResource\Pages\ListBuku;
use App\Filament\Resources\BukuResource\Pages\CreateBuku;
use App\Filament\Resources\BukuResource\Pages\EditBuku;

class BukuResource extends Resource
{
    protected static ?string $model = Buku::class;

    protected static ?string $slug = 'buku';
    protected static ?string $label = 'Buku';
    protected static ?string $pluralLabel = 'Buku';
    protected static ?string $navigationLabel = 'Buku';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('judul')->required(),
            TextInput::make('pengarang')->required(),
            Select::make('kategori')->required()->options([
                'Fiksi' => 'Fiksi',
                'Non Fiksi' => 'Non Fiksi',
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')->searchable(),
                TextColumn::make('pengarang'),
                TextColumn::make('kategori'),
                IconColumn::make('tersedia')
                    ->label('Tersedia')
                    ->icon(fn ($record) =>
                        $record->tersedia
                            ? 'heroicon-o-check-circle'
                            : 'heroicon-o-x-circle'
                    )
                    ->color(fn ($record) =>
                        $record->tersedia
                            ? 'success'
                            : 'danger'
                    ),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBuku::route('/'),
            'create' => CreateBuku::route('/create'),
            'edit' => EditBuku::route('/{record}/edit'),
        ];
    }
}
