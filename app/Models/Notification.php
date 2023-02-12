<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'sender_id',
        'recipient_id'
    ];

    public function scopeRecipient(int $id) {
        return $this->where('recipient_id', $id);
    }

    public function relationUser() {
        return $this->hasMany(User::class, "id", "sender_id");
    }
}
