<?php

namespace App\Filament\Resources\Queues;

use App\Filament\Resources\Queues\Pages\CreateQueue;
use App\Filament\Resources\Queues\Pages\EditQueue;
use App\Filament\Resources\Queues\Pages\ListQueues;
use App\Filament\Resources\Queues\Schemas\QueueForm;
use App\Models\Queue;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QueueResource extends Resource
{
    protected static ?string $model = Queue::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;
    protected static string|\UnitEnum|null $navigationGroup = 'Operasional Kasir';

    protected static ?string $navigationLabel = 'Data Antrean';

    protected static ?string $modelLabel = 'Antrean';

    protected static ?string $pluralModelLabel = 'Data Antrean';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return QueueForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('No. Antrean')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('customer_name')
                    ->label('Nama')
                    ->searchable()
                    ->default('—'),

                TextColumn::make('serviceCategory.name')
                    ->label('Layanan')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Waktu Daftar')
                    ->dateTime('d M Y, H:i')
                    ->timezone('Asia/Jakarta')
                    ->sortable(),

                TextColumn::make('counter.name')
                    ->label('Loket')
                    ->default('—')
                    ->formatStateUsing(fn ($state) => $state === '—' ? '—' : str_replace('Loket ', '', $state)),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Menunggu'  => 'warning',
                        'Dipanggil' => 'danger',
                        'Selesai'   => 'success',
                        'Dilewati'  => 'gray',
                        default     => 'gray',
                    }),
            ])
            ->searchPlaceholder('Cari nomor antrean, nama, atau layanan...')
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('hari_ini')
                    ->label('Antrean Hari Ini')
                    ->query(fn (Builder $query): Builder =>
                        $query->whereDate('queue_date', now()->toDateString())
                    )
                    ->default(),

                SelectFilter::make('status')
                    ->options([
                        'Menunggu'  => 'Menunggu',
                        'Dipanggil' => 'Dipanggil',
                        'Selesai'   => 'Selesai',
                        'Dilewati'  => 'Dilewati',
                    ]),

                SelectFilter::make('service_category_id')
                    ->label('Layanan')
                    ->relationship('serviceCategory', 'name'),
            ])
            ->actions([
                EditAction::make()
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->color('success'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListQueues::route('/'),
            'create' => CreateQueue::route('/create'),
            'edit'   => EditQueue::route('/{record}/edit'),
        ];
    }
}