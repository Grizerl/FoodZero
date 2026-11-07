<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Subscriber extends Model
{
    public const PENDING = 'pending';

    public const CONFIRMED = 'confirmed';

    public const UNSUBSCRIBED = 'unsubscribed';

    /** Minutes before another confirmation email may be sent to the same pending address. */
    public const RESEND_INTERVAL_MINUTES = 5;

    /** Days a confirmation link stays valid. */
    public const CONFIRM_LINK_DAYS = 7;

    protected $fillable = ['email', 'status', 'confirmation_sent_at', 'confirmed_at', 'unsubscribed_at'];

    protected function casts(): array
    {
        return [
            'confirmation_sent_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
        ];
    }

    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->where('status', self::CONFIRMED);
    }

    public function isConfirmed(): bool
    {
        return $this->status === self::CONFIRMED;
    }

    public function isPending(): bool
    {
        return $this->status === self::PENDING;
    }

    public function confirmationUrl(): string
    {
        return URL::temporarySignedRoute('newsletter.confirm', now()->addDays(self::CONFIRM_LINK_DAYS), ['subscriber' => $this->id]);
    }

    public function unsubscribeUrl(): string
    {
        return URL::signedRoute('newsletter.unsubscribe', ['subscriber' => $this->id]);
    }
}
