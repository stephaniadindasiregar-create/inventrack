<?php

namespace App\Filament\Resources\Items;

use App\Filament\Resources\Items\Pages\CreateItem;
use App\Filament\Resources\Items\Pages\EditItem;
use App\Filament\Resources\Items\Pages\ListItems;
use App\Models\Item;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // ✅ Hasil gabungan form() versi modern dan aman tanpa error
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('nama_barang')
                    ->label('Nama Barang')
                    ->placeholder('Contoh: Laptop Lenovo ThinkPad')
                    ->required()
                    ->maxLength(255),

                \Filament\Forms\Components\TextInput::make('kode_barang')
                    ->label('Kode Barang')
                    ->placeholder('Contoh: BRG-001')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                \Filament\Forms\Components\TextInput::make('stok')
                    ->label('Jumlah Stok')
                    ->numeric()
                    ->required()
                    ->minValue(0),

                \Filament\Forms\Components\TextInput::make('harga')
                    ->label('Harga Satuan (Rp)')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->prefix('Rp'),

                \Filament\Forms\Components\Select::make('kondisi')
                    ->label('Kondisi Barang')
                    ->options([
                        'Baik' => 'Baik',
                        'Rusak Ringan' => 'Rusak Ringan',
                        'Rusak Berat' => 'Rusak Berat',
                    ])
                    ->required(),

                \Filament\Forms\Components\Select::make('lokasi')
                    ->label('Lokasi Penyimpanan')
                    ->options([
                        'Gudang A' => 'Gudang A',
                        'Gudang B' => 'Gudang B',
                        'Gudang C' => 'Gudang C',
                    ])
                    ->required(),

                \Filament\Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi Barang')
                    ->placeholder('Jelaskan detail barang ini')
                    ->required()
                    ->rows(3),

                \Filament\Forms\Components\FileUpload::make('image')
                    ->label('Foto Barang')
                    ->image()
                    ->directory('items')
                    ->visibility('public')
                    ->required(),

                \Filament\Forms\Components\Hidden::make('users_id'),
            ]);
    }

    // ✅ Hasil gabungan table() versi modern dan aman tanpa error
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public'),

                \Filament\Tables\Columns\TextColumn::make('kode_barang')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('stok')
                    ->label('Stok')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('harga')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('kondisi')
                    ->label('Kondisi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Baik' => 'success',
                        'Rusak Ringan' => 'warning',
                        'Rusak Berat' => 'danger',
                        default => 'gray',
                    }),

                \Filament\Tables\Columns\TextColumn::make('lokasi')
                    ->label('Lokasi')
                    ->badge(),

                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->label('Ditambahkan Oleh'),

                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
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
            'index' => ListItems::route('/'),
            'create' => CreateItem::route('/create'),
            'edit' => EditItem::route('/{record}/edit'),
        ];
    }
}