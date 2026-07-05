<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Mahasiswa';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Schemas\Components\Section::make('Data Mahasiswa')
                    ->schema([
                        Forms\Components\TextInput::make('name')->label('Nama')->required()->maxLength(255),
                        Forms\Components\TextInput::make('email')->email()->required()->maxLength(255)->unique(User::class, 'email', ignoreRecord: true),
                        Forms\Components\TextInput::make('phone')->label('No HP')->maxLength(50),
                        Forms\Components\TextInput::make('department')->label('Departemen')->maxLength(255),
                        Forms\Components\Select::make('role_id')
                            ->label('Peran')
                            ->options(Role::query()->where('role_name', '!=', 'admin')->pluck('role_name', 'id'))
                            ->required()
                            ->disabled(fn (?User $record) => $record && $record->id === Auth::id())
                            ->helperText(fn (?User $record) => $record && $record->id === Auth::id() 
                                ? 'Admin tidak dapat mengubah peran mereka sendiri'
                                : ''),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->confirmed()
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create'),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->revealable()
                            ->dehydrated(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('role.role_name')->label('Peran')->badge()->sortable(),
                Tables\Columns\TextColumn::make('department')->label('Departemen')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role_id')
                    ->label('Peran')
                    ->relationship('role', 'role_name'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('role', fn (Builder $query) => $query->where('role_name', '!=', 'admin'));
    }
}
