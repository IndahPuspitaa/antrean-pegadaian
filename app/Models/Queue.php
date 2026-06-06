<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = [
        'service_category_id',
        'counter_id',
        'sequence_number',
        'ticket_number',
        'customer_name',
        'status',
        'queue_date',
        'called_at',
        'completed_at',
        'skipped_at',
    ];

    protected $casts = [
        'queue_date'   => 'date',
        'called_at'    => 'datetime',
        'completed_at' => 'datetime',
        'skipped_at'   => 'datetime',
    ];

    const STATUS_WAITING = 'Menunggu';
    const STATUS_CALLED  = 'Dipanggil';
    const STATUS_SERVED  = 'Selesai';
    const STATUS_SKIPPED = 'Dilewati';

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }

    public function scopeToday($query)
    {
        return $query->where('queue_date', today());
    }

    public function scopeWaiting($query)
    {
        return $query->where('status', self::STATUS_WAITING);
    }

    public function scopeCalled($query)
    {
        return $query->where('status', self::STATUS_CALLED);
    }

    /**
     * Generate nomor antrean global hari ini
     * Semua layanan pakai prefix A: A01, A02, A03 ...
     */
    public static function generateTicketNumber(): string
    {
        $count = static::where('queue_date', today())->count();

        return 'A' . str_pad($count + 1, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Sequence number global hari ini
     */
    public static function generateSequenceNumber(): int
    {
        return static::where('queue_date', today())->count() + 1;
    }
}