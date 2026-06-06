<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }

    // Antrean yang sedang dilayani loket ini
    public function currentQueue()
    {
        return $this->queues()
            ->where('queue_date', today())
            ->where('status', Queue::STATUS_CALLED)
            ->latest('called_at')
            ->first();
    }
}