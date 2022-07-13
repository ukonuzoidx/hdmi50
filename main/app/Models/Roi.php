<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roi extends Model
{
    use HasFactory;

    protected $table = 'rois';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function investment()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
