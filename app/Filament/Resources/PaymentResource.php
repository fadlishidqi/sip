<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Notifications\PaymentStatusUpdated;
use Illuminate\Support\Facades\Storage;

class PaymentResource extends Resource
{
   protected static ?string $model = Payment::class;

   protected static ?string $navigationIcon = 'heroicon-o-credit-card';
   
   protected static ?string $navigationGroup = 'Pendakian';
   
   protected static ?string $navigationLabel = 'Verifikasi Pembayaran';

   public static function form(Form $form): Form
   {
       return $form
           ->schema([
               Forms\Components\Select::make('status')
                   ->options([
                       'pending' => 'Menunggu Verifikasi',
                       'confirmed' => 'Dikonfirmasi',
                       'rejected' => 'Ditolak'
                   ])
                   ->required(),
               Forms\Components\Textarea::make('catatan')
                   ->required(fn ($get) => $get('status') === 'rejected')
                   ->columnSpanFull(),
           ]);
   }

   public static function table(Table $table): Table
   {
       return $table
           ->columns([
               Tables\Columns\TextColumn::make('booking.id')
                   ->label('ID Booking')
                   ->searchable()
                   ->sortable(),
               Tables\Columns\TextColumn::make('bank_pengirim')
                   ->label('Bank Pengirim')
                   ->searchable(),
               Tables\Columns\TextColumn::make('nama_pengirim')
                   ->label('Nama Pengirim')
                   ->searchable(),
               Tables\Columns\ImageColumn::make('bukti_pembayaran')
                   ->label('Bukti Transfer')
                   ->disk('public')
                   ->width(100)
                   ->height(100),
               Tables\Columns\BadgeColumn::make('status')
                   ->label('Status')
                   ->colors([
                       'warning' => 'pending',
                       'success' => 'confirmed',
                       'danger' => 'rejected',
                   ]),
               Tables\Columns\TextColumn::make('created_at')
                   ->label('Tanggal Upload')
                   ->dateTime()
                   ->sortable(),
           ])
           ->filters([
               Tables\Filters\SelectFilter::make('status')
                   ->options([
                       'pending' => 'Menunggu Verifikasi',
                       'confirmed' => 'Dikonfirmasi',
                       'rejected' => 'Ditolak'
                   ]),
           ])
           ->actions([
               Tables\Actions\Action::make('verify')
                   ->label('Verifikasi')
                   ->form([
                       Forms\Components\Select::make('status')
                           ->options([
                               'confirmed' => 'Konfirmasi Pembayaran',
                               'rejected' => 'Tolak Pembayaran'
                           ])
                           ->required(),
                       Forms\Components\Textarea::make('catatan')
                           ->required(fn ($get) => $get('status') === 'rejected')
                           ->placeholder('Masukkan alasan penolakan jika status ditolak'),
                   ])
                   ->action(function (Payment $record, array $data): void {
                       $record->status = $data['status'];
                       $record->catatan = $data['catatan'];
                       $record->save();

                       if ($data['status'] === 'confirmed') {
                           $record->booking->update(['status' => 'confirmed']);
                       }

                       $record->booking->pendaki->notify(new PaymentStatusUpdated($record));
                   })
                   ->visible(fn (Payment $record): bool => $record->status === 'pending')
                   ->modalHeading('Verifikasi Pembayaran')
                   ->modalDescription('Verifikasi pembayaran ini akan mengirimkan notifikasi ke pendaki.')
                   ->modalSubmitActionLabel('Simpan')
                   ->modalCancelActionLabel('Batal')
                   ->icon('heroicon-o-check'),
               Tables\Actions\ViewAction::make(),
           ])
           ->defaultSort('created_at', 'desc');
   }

   public static function getRelations(): array
   {
       return [];
   }

   public static function getPages(): array
   {
       return [
           'index' => Pages\ListPayments::route('/'),
           'view' => Pages\ViewPayment::route('/{record}'),
       ];
   }

   public static function getNavigationBadge(): ?string
   {
       return static::getModel()::where('status', 'pending')->count() ?: null;
   }
}