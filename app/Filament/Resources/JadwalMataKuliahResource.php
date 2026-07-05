<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalMataKuliahResource\Pages;
use App\Models\JadwalMataKuliah;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JadwalMataKuliahResource extends Resource
{
    protected static ?string $model = JadwalMataKuliah::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Jadwal Mata Kuliah';

    public static function getNavigationGroup(): ?string
    {
        return 'Manajemen';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Jadwal Mata Kuliah')
                ->schema([
                    Forms\Components\Select::make('classroom_id')
                        ->label('Ruang Kelas')
                        ->relationship('classroom', 'room_name')
                        ->searchable()
                        ->required(),
                    Forms\Components\Select::make('dosen_id')
                        ->label('Dosen')
                        ->options(User::where('role_id', function ($query) {
                            $query->select('id')->from('roles')->where('role_name', 'dosen');
                        })->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    Forms\Components\TextInput::make('mata_kuliah')
                        ->label('Mata Kuliah')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('day_of_week')
                        ->label('Hari')
                        ->options([
                            'Senin' => 'Senin',
                            'Selasa' => 'Selasa',
                            'Rabu' => 'Rabu',
                            'Kamis' => 'Kamis',
                            'Jumat' => 'Jumat',
                            'Sabtu' => 'Sabtu',
                            'Minggu' => 'Minggu',
                        ])
                        ->required(),
                    Forms\Components\TimePicker::make('start_time')
                        ->label('Jam Mulai')
                        ->required(),
                    Forms\Components\TimePicker::make('end_time')
                        ->label('Jam Selesai')
                        ->required(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('classroom.room_name')
                    ->label('Ruang Kelas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dosen.name')
                    ->label('Dosen')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mata_kuliah')
                    ->label('Mata Kuliah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('day_of_week')
                    ->label('Hari')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Jam Mulai')
                    ->time('H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('Jam Selesai')
                    ->time('H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('day_of_week')
                    ->label('Hari')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                        'Minggu' => 'Minggu',
                    ]),
                Tables\Filters\SelectFilter::make('dosen')
                    ->label('Dosen')
                    ->relationship('dosen', 'name'),
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
            ->defaultSort('day_of_week', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJadwalMataKuliah::route('/'),
            'create' => Pages\CreateJadwalMataKuliah::route('/create'),
            'edit' => Pages\EditJadwalMataKuliah::route('/{record}/edit'),
        ];
    }
}
