<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawShiba extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'withdraw_information' => 'object'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
