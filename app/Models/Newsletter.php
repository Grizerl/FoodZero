<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $fillable = ['subject', 'body', 'sent_at', 'recipients_count'];

    protected function casts(): array
    {
        return ['sent_at' => 'datetime'];
    }

    public function isSent(): bool
    {
        return $this->sent_at !== null;
    }
}
