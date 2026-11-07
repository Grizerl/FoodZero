<?php

namespace Tests\Feature;

use App\Jobs\SendNewsletterJob;
use App\Mail\ConfirmSubscription;
use App\Mail\NewsletterCampaign;
use App\Mail\WelcomeSubscriber;
use App\Models\Newsletter;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

/**
 * Tests hit the dev database, so everything runs inside a rolled-back transaction.
 * Existing subscribers are removed inside that transaction so counts are predictable.
 */
class NewsletterTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Subscriber::query()->delete();
        Newsletter::query()->delete();
        Mail::fake();
        $this->withoutMiddleware([ThrottleRequests::class, ValidateCsrfToken::class]);
    }

    private function subscribe(string $email, array $extra = [])
    {
        return $this->postJson(route('newsletter.subscribe'), ['email' => $email] + $extra);
    }

    private function subscriber(string $status = Subscriber::CONFIRMED, string $email = 'guest@example.com'): Subscriber
    {
        return Subscriber::create(['email' => $email, 'status' => $status]);
    }

    private function admin(): User
    {
        return User::factory()->create();
    }

    // ---- public subscription ----

    public function test_valid_email_creates_pending_subscriber_and_sends_confirmation(): void
    {
        $this->subscribe('guest@example.com')->assertStatus(202)->assertJsonStructure(['message']);

        $this->assertSame(Subscriber::PENDING, Subscriber::firstWhere('email', 'guest@example.com')->status);
        Mail::assertQueued(ConfirmSubscription::class, 1);
    }

    public function test_invalid_email_is_rejected(): void
    {
        $this->subscribe('not-an-email')->assertStatus(422)->assertJsonValidationErrors('email');
        $this->subscribe('')->assertStatus(422);

        $this->assertSame(0, Subscriber::count());
        Mail::assertNothingQueued();
    }

    public function test_plain_post_redirects_back_with_a_message(): void
    {
        $this->from('/blog')->post(route('newsletter.subscribe'), ['email' => 'guest@example.com'])
            ->assertRedirect('/blog#newsletter')
            ->assertSessionHas('newsletter_status');
    }

    public function test_email_is_normalised_and_stored_once(): void
    {
        $this->subscribe('guest@example.com');
        $this->subscribe('  Guest@Example.COM ');

        $this->assertSame(1, Subscriber::count());
    }

    public function test_known_pending_email_gets_one_confirmation_per_interval(): void
    {
        $this->subscribe('guest@example.com');
        $this->subscribe('guest@example.com')->assertStatus(202);
        Mail::assertQueued(ConfirmSubscription::class, 1);

        $this->travel(Subscriber::RESEND_INTERVAL_MINUTES + 1)->minutes();
        $this->subscribe('guest@example.com');
        Mail::assertQueued(ConfirmSubscription::class, 2);
    }

    public function test_confirmed_email_gets_same_answer_and_no_mail(): void
    {
        $this->subscriber();

        $new = $this->subscribe('other@example.com')->json();
        $known = $this->subscribe('guest@example.com');

        $known->assertStatus(202);
        $this->assertSame($new, $known->json());
        Mail::assertQueued(ConfirmSubscription::class, 1); // only for the new address
    }

    public function test_unsubscribed_email_returns_to_pending_with_new_confirmation(): void
    {
        $subscriber = $this->subscriber(Subscriber::UNSUBSCRIBED);

        $this->subscribe('guest@example.com')->assertStatus(202);

        $this->assertSame(Subscriber::PENDING, $subscriber->fresh()->status);
        Mail::assertQueued(ConfirmSubscription::class, 1);
    }

    public function test_filled_honeypot_looks_like_success_but_does_nothing(): void
    {
        $this->subscribe('bot@example.com', ['website' => 'http://spam'])->assertStatus(202);

        $this->assertSame(0, Subscriber::count());
        Mail::assertNothingQueued();
    }

    public function test_subscribe_form_is_throttled(): void
    {
        $this->withMiddleware([ThrottleRequests::class]);
        RateLimiter::clear('newsletter-subscribe|127.0.0.1');

        foreach (range(1, 5) as $i) {
            $this->subscribe("g{$i}@example.com")->assertStatus(202);
        }
        $this->subscribe('g6@example.com')->assertStatus(429);

        RateLimiter::clear('newsletter-subscribe|127.0.0.1');
    }

    public function test_footer_renders_a_real_form(): void
    {
        $this->get('/')->assertOk()
            ->assertSee('action="'.route('newsletter.subscribe').'"', false)
            ->assertSee('name="email"', false);
    }

    // ---- confirm ----

    public function test_confirm_link_confirms_and_sends_one_welcome(): void
    {
        $subscriber = $this->subscriber(Subscriber::PENDING);
        $url = $subscriber->confirmationUrl();

        $this->get($url)->assertOk()->assertSee('You are subscribed');
        $this->get($url)->assertOk()->assertSee('already subscribed');

        $fresh = $subscriber->fresh();
        $this->assertSame(Subscriber::CONFIRMED, $fresh->status);
        $this->assertNotNull($fresh->confirmed_at);
        Mail::assertQueued(WelcomeSubscriber::class, 1);
    }

    public function test_forged_or_expired_confirm_link_does_not_confirm(): void
    {
        $subscriber = $this->subscriber(Subscriber::PENDING);

        $this->get(route('newsletter.confirm', $subscriber->id))->assertForbidden();
        $this->get($subscriber->confirmationUrl().'x')->assertForbidden();

        $expired = URL::temporarySignedRoute('newsletter.confirm', now()->subMinute(), ['subscriber' => $subscriber->id]);
        $this->get($expired)->assertForbidden()->assertSee('no longer valid');

        $this->assertSame(Subscriber::PENDING, $subscriber->fresh()->status);
        Mail::assertNothingQueued();
    }

    // ---- unsubscribe ----

    public function test_unsubscribe_link_unsubscribes_idempotently(): void
    {
        $subscriber = $this->subscriber();
        $url = $subscriber->unsubscribeUrl();

        $this->get($url)->assertOk()->assertSee('unsubscribed');
        $this->get($url)->assertOk();

        $fresh = $subscriber->fresh();
        $this->assertSame(Subscriber::UNSUBSCRIBED, $fresh->status);
        $this->assertNotNull($fresh->unsubscribed_at);
    }

    public function test_one_click_post_unsubscribes(): void
    {
        $subscriber = $this->subscriber();

        $this->post($subscriber->unsubscribeUrl())->assertOk();

        $this->assertSame(Subscriber::UNSUBSCRIBED, $subscriber->fresh()->status);
    }

    public function test_forged_unsubscribe_link_is_forbidden(): void
    {
        $subscriber = $this->subscriber();

        $this->get(route('newsletter.unsubscribe', $subscriber->id))->assertForbidden();

        $this->assertSame(Subscriber::CONFIRMED, $subscriber->fresh()->status);
    }

    // ---- admin ----

    public function test_guest_cannot_open_admin_newsletter(): void
    {
        $this->get(route('newsletters.index'))->assertRedirect(route('admin.login.form'));
        $this->post(route('newsletters.send', 1))->assertRedirect(route('admin.login.form'));
    }

    public function test_admin_sees_subscribers_and_counts(): void
    {
        $this->subscriber(Subscriber::CONFIRMED, 'a@example.com');
        $this->subscriber(Subscriber::PENDING, 'b@example.com');

        $this->actingAs($this->admin())->get(route('newsletters.index'))
            ->assertOk()->assertSee('a@example.com')->assertSee('b@example.com')
            ->assertSee('confirmed: 1', false)->assertSee('pending: 1', false);
    }

    public function test_admin_deletes_subscriber(): void
    {
        $subscriber = $this->subscriber();

        $this->actingAs($this->admin())->delete(route('newsletters.subscribers.destroy', $subscriber->id))->assertRedirect();

        $this->assertNull(Subscriber::find($subscriber->id));
    }

    public function test_newsletter_requires_subject_and_body(): void
    {
        $this->actingAs($this->admin())->post(route('newsletters.store'), ['subject' => '', 'body' => ''])
            ->assertSessionHasErrors(['subject', 'body']);

        $this->assertSame(0, Newsletter::count());
    }

    public function test_sending_dispatches_job_once_and_records_recipients(): void
    {
        Bus::fake();
        $this->subscriber(Subscriber::CONFIRMED, 'a@example.com');
        $this->subscriber(Subscriber::CONFIRMED, 'b@example.com');
        $this->subscriber(Subscriber::PENDING, 'c@example.com');
        $newsletter = Newsletter::create(['subject' => 'Hi', 'body' => 'Body']);
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('newsletters.send', $newsletter->id))->assertSessionHas('success');
        $this->actingAs($admin)->post(route('newsletters.send', $newsletter->id))->assertSessionHas('error');

        $fresh = $newsletter->fresh();
        $this->assertTrue($fresh->isSent());
        $this->assertSame(2, $fresh->recipients_count);
        Bus::assertDispatchedTimes(SendNewsletterJob::class, 1);
    }

    public function test_sending_without_confirmed_subscribers_is_not_marked_sent(): void
    {
        Bus::fake();
        $this->subscriber(Subscriber::PENDING);
        $newsletter = Newsletter::create(['subject' => 'Hi', 'body' => 'Body']);

        $this->actingAs($this->admin())->post(route('newsletters.send', $newsletter->id))->assertSessionHas('error');

        $this->assertFalse($newsletter->fresh()->isSent());
        Bus::assertNothingDispatched();
    }

    // ---- delivery ----

    public function test_job_mails_only_confirmed_subscribers_with_unsubscribe_headers(): void
    {
        $this->subscriber(Subscriber::CONFIRMED, 'a@example.com');
        $this->subscriber(Subscriber::PENDING, 'b@example.com');
        $this->subscriber(Subscriber::UNSUBSCRIBED, 'c@example.com');
        $newsletter = Newsletter::create(['subject' => 'Hi', 'body' => "Line 1\nLine 2"]);

        (new SendNewsletterJob($newsletter))->handle();

        Mail::assertSent(NewsletterCampaign::class, 1);
        Mail::assertSent(NewsletterCampaign::class, function (NewsletterCampaign $mail) {
            $headers = $mail->headers()->text;

            return $mail->hasTo('a@example.com')
                && str_contains($headers['List-Unsubscribe'], 'newsletter/unsubscribe/')
                && $headers['List-Unsubscribe-Post'] === 'List-Unsubscribe=One-Click'
                && str_contains($mail->render(), 'Unsubscribe');
        });
    }
}
