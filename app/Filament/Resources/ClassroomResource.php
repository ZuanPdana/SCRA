<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassroomResource\Pages;
use App\Models\Classroom;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ClassroomResource extends Resource
{
    protected static ?string $model = Classroom::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'Ruang Kelas';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Schemas\Components\Section::make('Data Ruang Kelas')
                    ->schema([
                        Forms\Components\TextInput::make('room_name')->label('Nama Ruang')->required()->maxLength(255),
                        Forms\Components\TextInput::make('room_code')->label('Kode Ruang')->required()->maxLength(255)->unique(Classroom::class, 'room_code', ignoreRecord: true),
                        Forms\Components\TextInput::make('location')->label('Lokasi')->required()->maxLength(255),
                        Forms\Components\TextInput::make('capacity')->label('Kapasitas')->numeric()->required(),
                        Forms\Components\Textarea::make('facilities')->label('Fasilitas')->rows(3),
                        Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(3),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'Available' => 'Tersedia',
                                'Unavailable' => 'Tidak Tersedia',
                                'Maintenance' => 'Perawatan',
                            ])
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('room_name')->label('Nama Ruang')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('room_code')->label('Kode')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('location')->label('Lokasi')->searchable(),
                Tables\Columns\TextColumn::make('capacity')->label('Kapasitas')->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'Available' => 'Tersedia',
                        'Unavailable' => 'Tidak Tersedia',
                        'Maintenance' => 'Perawatan',
                        default => $state,
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'Available' => 'Tersedia',
                        'Unavailable' => 'Tidak Tersedia',
                        'Maintenance' => 'Perawatan',
                    ]),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassrooms::route('/'),
            'create' => Pages\CreateClassroom::route('/create'),
            'edit' => Pages\EditClassroom::route('/{record}/edit'),
        ];
    }
}
