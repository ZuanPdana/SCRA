<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use App\Models\ActivityLog;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Log Aktivitas';

    protected static ?string $pluralLabel = 'Log Aktivitas';

    protected static ?string $singular = 'Log Aktivitas';

    public static function getNavigationGroup(): ?string
    {
        return 'Administrasi';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal & Waktu')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.role.role_name')
                    ->label('Peran')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'admin' => 'Admin',
                        'dosen' => 'Dosen',
                        'mahasiswa' => 'Mahasiswa',
                        default => $state ?? 'N/A',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'dosen' => 'warning',
                        'mahasiswa' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('activity_type')
                    ->label('Jenis Aktivitas')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('module')
                    ->label('Modul')
                    ->badge()
                    ->color('secondary')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(60)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('Alamat IP')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->label('Tanggal')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        \Filament\Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                SelectFilter::make('user.role.role_name')
                    ->label('Peran')
                    ->relationship('user.role', 'role_name'),
                SelectFilter::make('module')
                    ->label('Modul')
                    ->options([
                        'Authentication' => 'Authentication',
                        'Users' => 'Users',
                        'Classrooms' => 'Classrooms',
                        'Reservations' => 'Reservations',
                        'Reports' => 'Reports',
                        'Profile' => 'Profile',
                        'Admin' => 'Admin',
                        'System' => 'System',
                    ]),
                SelectFilter::make('activity_type')
                    ->label('Jenis Aktivitas')
                    ->options([
                        'Authentication' => 'Authentication',
                        'User Management' => 'User Management',
                        'Classroom Management' => 'Classroom Management',
                        'Reservation' => 'Reservation',
                        'Profile' => 'Profile',
                        'System' => 'System',
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                \Filament\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
            'view' => Pages\ViewActivityLog::route('/{record}'),
        ];
    }
}

