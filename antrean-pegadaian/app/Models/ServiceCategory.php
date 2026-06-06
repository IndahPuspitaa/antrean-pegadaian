<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'estimated_time',
        'color',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }

    public function waitingToday(): int
    {
        return $this->queues()
            ->where('queue_date', today())
            ->where('status', 'Menunggu')
            ->count();
    }

    public function estimatedWaitMinutes(): int
    {
        return $this->waitingToday() * $this->estimated_time;
    }
}