<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ChatAttachment extends Model
{
    protected $table = 'chat_attachments';
    protected $fillable = [
        'chat_id',
        'attachment',
    ];
}
