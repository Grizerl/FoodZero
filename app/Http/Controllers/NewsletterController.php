<?php

namespace App\Http\Controllers;

use App\Http\Requests\Main\SubscribeRequest;
use App\Mail\ConfirmSubscription;
use App\Mail\WelcomeSubscriber;
use App\Models\Subscriber;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public const SUBSCRIBE_MESSAGE = 'Almost done! Check your inbox and confirm your email to finish subscribing.';

    /**
     * Footer form. The answer is the same for new and known addresses, so it never reveals who is subscribed.
     */
    public function subscribe(SubscribeRequest $request): RedirectResponse|JsonResponse
    {
        if (! $request->isBot()) {
            $this->register($request->validated('email'));
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => self::SUBSCRIBE_MESSAGE], 202);
        }

        return redirect()->to(url()->previous().'#newsletter')->with('newsletter_status', self::SUBSCRIBE_MESSAGE);
    }

    public function confirm(Request $request, Subscriber $subscriber): Response
    {
        if (! $request->hasValidSignature()) {
            return $this->statusPage(
                'This link is no longer valid',
                'The confirmation link has expired or is incorrect. Please subscribe again from the footer of any page.',
                403
            );
        }

        if ($subscriber->status === Subscriber::UNSUBSCRIBED) {
            return $this->statusPage(
                'This link is no longer valid',
                'You have unsubscribed since. Subscribe again from the footer of any page if you changed your mind.',
                403
            );
        }

        $first = $subscriber->isPending();

        if ($first) {
            $subscriber->update(['status' => Subscriber::CONFIRMED, 'confirmed_at' => now()]);
            Mail::to($subscriber->email)->queue(new WelcomeSubscriber($subscriber));
        }

        return $this->statusPage(
            $first ? 'You are subscribed!' : 'You are already subscribed',
            'Thank you! Our best recipes and news will be on their way to your inbox.'
        );
    }

    /**
     * GET from the email link, POST from mail clients' one-click unsubscribe. The route is signed.
     */
    public function unsubscribe(Subscriber $subscriber): Response
    {
        if ($subscriber->status !== Subscriber::UNSUBSCRIBED) {
            $subscriber->update(['status' => Subscriber::UNSUBSCRIBED, 'unsubscribed_at' => now()]);
        }

        return $this->statusPage(
            'You have been unsubscribed',
            'You will not receive our newsletter anymore. You can subscribe again at any time from the footer.'
        );
    }

    private function statusPage(string $title, string $text, int $status = 200): Response
    {
        return response()->view('pages.newsletter.status', compact('title', 'text'), $status);
    }

    private function register(string $email): void
    {
        try {
            $subscriber = Subscriber::firstOrCreate(['email' => $email], ['status' => Subscriber::PENDING]);
        } catch (UniqueConstraintViolationException) {
            // A parallel request created it first; nothing more to do for this one.
            return;
        }

        if ($subscriber->isConfirmed()) {
            return;
        }

        if ($subscriber->status === Subscriber::UNSUBSCRIBED) {
            $subscriber->update(['status' => Subscriber::PENDING, 'unsubscribed_at' => null, 'confirmation_sent_at' => null]);
        }

        $recentlySent = $subscriber->confirmation_sent_at?->gt(now()->subMinutes(Subscriber::RESEND_INTERVAL_MINUTES));

        if (! $recentlySent) {
            $subscriber->update(['confirmation_sent_at' => now()]);
            Mail::to($subscriber->email)->queue(new ConfirmSubscription($subscriber));
        }
    }
}
