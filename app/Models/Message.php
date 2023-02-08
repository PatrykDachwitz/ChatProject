<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'readed',
        'message',
        'sender_id',
        'recipient_id'
    ];

    public function scopeRecipientsMessage(int $id) {
        return $this->where('recipient_id', $id)
            ->orWhere('sender_id', $id);
    }
}
