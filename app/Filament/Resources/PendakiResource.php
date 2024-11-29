<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendakiResource\Pages;
use App\Models\Pendaki;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class PendakiResource extends Resource
{
    protected static ?string $model = Pendaki::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('username')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                Forms\Components\FileUpload::make('avatar')
                    ->image()
                    ->directory('pendaki-avatars'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('username'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendakis::route('/'),
            'create' => Pages\CreatePendaki::route('/create'),
            'edit' => Pages\EditPendaki::route('/{record}/edit'),
        ];
    }
}