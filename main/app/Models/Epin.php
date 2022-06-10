<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epin extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'used_by');
    }

    public function scopeUsed()
    {
        return $this->where('status', 1);
    }

    public function scopeUnused()
    {
        return $this->where('status', 0);
    }

}
