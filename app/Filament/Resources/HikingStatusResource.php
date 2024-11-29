<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HikingStatusResource\Pages;
use App\Models\HikingStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;

class HikingStatusResource extends Resource
{
    protected static ?string $model = HikingStatus::class;
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Pendakian';
    protected static ?string $navigationLabel = 'Status Pendakian';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('booking_id')
                    ->relationship('booking', 'id')
                    ->required(),
                Forms\Components\DateTimePicker::make('departure_time')
                    ->label('Waktu Keberangkatan'),
                Forms\Components\DateTimePicker::make('return_time')
                    ->label('Waktu Kepulangan'),
                Forms\Components\Select::make('status')
                    ->options([
                        'waiting' => 'Menunggu Keberangkatan',
                        'hiking' => 'Sedang Mendaki',
                        'completed' => 'Selesai',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking.pendaki.nama_lengkap')
                    ->label('Nama Pendaki')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('booking.tanggal_naik')
                    ->label('Tanggal Naik')
                    ->date('d F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('departure_time')
                    ->label('Waktu Berangkat')
                    ->dateTime('d F Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('return_time')
                    ->label('Waktu Pulang')
                    ->dateTime('d F Y, H:i')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'waiting',
                        'primary' => 'hiking',
                        'success' => 'completed',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d F Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'waiting' => 'Menunggu Keberangkatan',
                        'hiking' => 'Sedang Mendaki',
                        'completed' => 'Selesai',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListHikingStatuses::route('/'),
            'create' => Pages\CreateHikingStatus::route('/create'),
            'view' => Pages\ViewHikingStatus::route('/{record}'),
            'edit' => Pages\EditHikingStatus::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'hiking')->count() ?: null;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['booking.pendaki']); 
    }
}