<?php

namespace Cht\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cron extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'description',
        'minutes',
        'hours',
        'days',
        'months',
        'weekday',
        'command'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
