<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportAttachment extends Model
{
    // use HasFactory;
    protected $guarded = ['id'];
    protected $table = "support_attachments";

    public function supportMessage()
    {
        return $this->belongsTo(SupportMessage::class, 'support_message_id');
    }
}
