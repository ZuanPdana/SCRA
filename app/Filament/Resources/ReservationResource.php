<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Models\Reservation;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-date-range';

    protected static ?string $navigationLabel = 'Reservasi';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Schemas\Components\Section::make('Data Reservasi')
                    ->schema([
                        Forms\Components\Select::make('user_id')->label('Mahasiswa')->relationship('user', 'name')->searchable()->required(),
                        Forms\Components\Select::make('classroom_id')->label('Ruang Kelas')->relationship('classroom', 'room_name')->searchable()->required(),
                        Forms\Components\DatePicker::make('reservation_date')->label('Tanggal')->required(),
                        Forms\Components\TimePicker::make('start_time')->label('Jam Mulai')->required(),
                        Forms\Components\TimePicker::make('end_time')->label('Jam Selesai')->required(),
                        Forms\Components\Select::make('purpose_type')
                            ->label('Jenis Penggunaan')
                            ->options([
                                'Perkuliahan' => 'Perkuliahan',
                                'Kegiatan Lain' => 'Kegiatan Lain',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('purpose')
                            ->label('Tujuan/Nama Kegiatan')
                            ->maxLength(255),
                        Forms\Components\Select::make('dosen_id')
                            ->label('Dosen (untuk Perkuliahan)')
                            ->relationship('dosen', 'name')
                            ->searchable()
                            ->visible(fn ($get) => $get('purpose_type') === 'Perkuliahan'),
                        Forms\Components\TextInput::make('mata_kuliah')
                            ->label('Mata Kuliah')
                            ->visible(fn ($get) => $get('purpose_type') === 'Perkuliahan'),
                        Forms\Components\Textarea::make('kegiatan')
                            ->label('Deskripsi Kegiatan')
                            ->rows(3)
                            ->visible(fn ($get) => $get('purpose_type') === 'Kegiatan Lain'),
                        Forms\Components\Select::make('reservation_status')
                            ->label('Status')
                            ->options([
                                'Pending' => 'Menunggu',
                                'Approved' => 'Disetujui',
                                'Rejected' => 'Ditolak',
                                'Cancelled' => 'Dibatalkan',
                                'Completed' => 'Selesai',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('rejection_reason')->label('Alasan Penolakan')->rows(3),
                        Forms\Components\Select::make('verified_by')
                            ->label('Diverifikasi Oleh')
                            ->relationship('verifiedBy', 'name')
                            ->searchable()
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Mahasiswa')->searchable(),
                Tables\Columns\TextColumn::make('classroom.room_name')->label('Ruang Kelas')->searchable(),
                Tables\Columns\TextColumn::make('reservation_date')->label('Tanggal')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('reservation_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'Pending' => 'Menunggu',
                        'Approved' => 'Disetujui',
                        'Rejected' => 'Ditolak',
                        'Cancelled' => 'Dibatalkan',
                        'Completed' => 'Selesai',
                        default => $state,
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('reservation_status')
                    ->label('Status')
                    ->options([
                        'Pending' => 'Menunggu',
                        'Approved' => 'Disetujui',
                        'Rejected' => 'Ditolak',
                        'Cancelled' => 'Dibatalkan',
                        'Completed' => 'Selesai',
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
