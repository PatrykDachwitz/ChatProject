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

   /* public function scopeRecipientsMessage(int $recipient, int $sender) {
        //$customQuery = "recipient_id IN {$recipient}, {$sender} AND sender_id IN {$recipient}, {$sender}";
        return $this->where('created_at', $recipient, $sender);
    }
*/
    public function scopeRecipientsMessage($sender,  $recipient) {
        return $this->whereIn('sender_id', [1, 2])
            ->whereIn('recipient_id', [1, 2]);
    }
}
