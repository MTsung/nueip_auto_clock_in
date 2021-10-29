<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClockLog extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'clock_log';

    protected $fillable = [];

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
