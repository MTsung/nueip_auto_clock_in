<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffDay extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'off_day';

    protected $fillable = [];

    protected $guarded = ['id'];

}
