<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HariLiburResource\Pages;
use App\Models\HariLibur;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class HariLiburResource extends Resource
{
    protected static ?string $model = HariLibur::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Hari Libur';

    protected static ?string $pluralLabel = 'Hari Libur';

    protected static bool $shouldRegisterNavigation = false;

    public static function getNavigationGroup(): ?string
    {
        return 'Manajemen';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Pengaturan Hari Libur')
                ->schema([
                    Forms\Components\Select::make('classroom_id')
                        ->label('Ruang Kelas')
                        ->relationship('classroom', 'room_name')
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->helperText('Kosongkan untuk berlaku ke semua ruang.'),
                    Forms\Components\DatePicker::make('holiday_date')
                        ->label('Tanggal Libur')
                        ->required(),
                    Forms\Components\TextInput::make('title')
                        ->label('Judul Libur')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('description')
                        ->label('Deskripsi')
                        ->rows(3)
                        ->maxLength(1000),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true)
                        ->required(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('holiday_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('classroom.room_name')
                    ->label('Ruang Kelas')
                    ->formatStateUsing(fn ($state) => $state ?: 'Semua Ruang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Libur')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->label('Hanya Aktif')
                    ->query(fn ($query) => $query->where('is_active', true)),
                Tables\Filters\SelectFilter::make('classroom_id')
                    ->label('Ruang Kelas')
                    ->relationship('classroom', 'room_name'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('holiday_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHariLiburs::route('/'),
            'create' => Pages\CreateHariLibur::route('/create'),
            'edit' => Pages\EditHariLibur::route('/{record}/edit'),
        ];
    }
}
