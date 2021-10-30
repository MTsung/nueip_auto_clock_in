<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;
    
    public $timestamps = true;
    
    public $incrementing = false;

    protected $primaryKey = 'user_id';

    protected $table = 'user_setting';

    protected $fillable = [];

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
