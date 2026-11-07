<?php

namespace App\Jobs;

use App\Mail\NewsletterCampaign;
use App\Models\Newsletter;
use App\Models\Subscriber;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Sends a newsletter to confirmed subscribers in the background. Each mail goes out from the job
 * itself, so the subscriber's status is re-checked right before the send.
 */
class SendNewsletterJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Newsletter $newsletter) {}

    public function handle(): void
    {
        Subscriber::confirmed()->chunkById(100, function ($subscribers) {
            foreach ($subscribers as $subscriber) {
                // Unsubscribed since the job started? Skip.
                if (! $subscriber->fresh()?->isConfirmed()) {
                    continue;
                }

                try {
                    Mail::to($subscriber->email)->send(new NewsletterCampaign($this->newsletter, $subscriber));
                } catch (\Throwable $e) {
                    // One bad address must not stop the rest of the list.
                    Log::warning('Newsletter mail failed', ['subscriber' => $subscriber->id, 'error' => $e->getMessage()]);
                }
            }
        });
    }
}
