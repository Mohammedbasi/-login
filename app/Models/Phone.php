<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $table = "phones";
    protected $fillable = [
        'code',
        'phone',
    ];
    protected $hidden = ['user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
