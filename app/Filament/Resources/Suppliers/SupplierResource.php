<?php

namespace App\Filament\Resources\Suppliers;

use App\Filament\Resources\Suppliers\Pages\CreateSupplier;
use App\Filament\Resources\Suppliers\Pages\EditSupplier;
use App\Filament\Resources\Suppliers\Pages\ListSuppliers;
use App\Models\Supplier;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // ✅ Hasil gabungan form() versi modern dan aman
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('nama_perusahaan')
                    ->label('Nama Perusahaan')
                    ->placeholder('Contoh: PT. Sumber Makmur')
                    ->required()
                    ->maxLength(255),

                \Filament\Forms\Components\TextInput::make('nama_kontak')
                    ->label('Nama Contact Person')
                    ->placeholder('Contoh: Budi Santoso')
                    ->required()
                    ->maxLength(255),

                \Filament\Forms\Components\TextInput::make('telepon')
                    ->label('Nomor Telepon')
                    ->placeholder('Contoh: 08123456789')
                    ->required()
                    ->maxLength(15),

                \Filament\Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->placeholder('Contoh: supplier@email.com')
                    ->required()
                    ->maxLength(255),

                \Filament\Forms\Components\Textarea::make('alamat')
                    ->label('Alamat Lengkap')
                    ->placeholder('Jl. Contoh No. 123, Kota, Provinsi')
                    ->required()
                    ->rows(3),

                \Filament\Forms\Components\FileUpload::make('image')
                    ->label('Logo Perusahaan')
                    ->image()
                    ->directory('suppliers')
                    ->visibility('public')
                    ->required(),
            ]);
    }

    // ✅ Hasil gabungan table() versi modern dan aman
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('image')
                    ->label('Logo')
                    ->disk('public'),

                \Filament\Tables\Columns\TextColumn::make('nama_perusahaan')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('nama_kontak')
                    ->label('Contact Person')
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('telepon')
                    ->label('Telepon'),

                \Filament\Tables\Columns\TextColumn::make('email')
                    ->label('Email'),

                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Ditambahkan')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => ListSuppliers::route('/'),
            'create' => CreateSupplier::route('/create'),
            'edit' => EditSupplier::route('/{record}/edit'),
        ];
    }
}