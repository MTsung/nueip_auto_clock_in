<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarDate extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'calendar_date';

    protected $fillable = [];

    protected $guarded = ['id'];

}
