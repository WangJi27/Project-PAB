<?php

namespace App\Filament\Resources;

use App\Models\Peminjaman;
use App\Models\Buku;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use App\Filament\Resources\PeminjamanResource\Pages\ListPeminjamans;
use App\Filament\Resources\PeminjamanResource\Pages\CreatePeminjaman;
use App\Filament\Resources\PeminjamanResource\Pages\EditPeminjaman;
use App\Filament\Resources\PeminjamanResource\Pages\ListPeminjamen;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;
    protected static ?string $modelLabel = 'Peminjaman';
    protected static ?string $pluralModelLabel = 'Peminjaman';


    protected static ?string $navigationLabel = 'Peminjaman'; 
    protected static ?string $slug = 'peminjaman';
    protected static ?string $navigationIcon = 'heroicon-o-book-open'; 

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('buku_id')
    ->label('Buku')
    ->relationship(
        name: 'buku',
        titleAttribute: 'judul',
        modifyQueryUsing: fn ($query) => $query->whereDoesntHave('peminjamans', function ($q) {
            $q->whereNull('tanggal_kembali');
        })
    )

    ->required(),


            TextInput::make('peminjam')
                ->required(),

            DatePicker::make('tanggal_pinjam')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('buku.judul')->label('Buku'),
            TextColumn::make('peminjam'),
            TextColumn::make('tanggal_pinjam')->date(),
            TextColumn::make('tanggal_kembali')->date()->label('Tanggal Kembali'),
        ])
        ->actions([
            Action::make('Kembalikan')
                ->visible(fn ($record) => is_null($record->tanggal_kembali))
                ->action(fn ($record) => $record->update(['tanggal_kembali' => now()]))
                ->requiresConfirmation()
                ->color('success')
                ->icon('heroicon-o-check-circle'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPeminjamen::route('/'),
            'create' => CreatePeminjaman::route('/create'),
            'edit' => EditPeminjaman::route('/{record}/edit'),
        ];
    }
}
