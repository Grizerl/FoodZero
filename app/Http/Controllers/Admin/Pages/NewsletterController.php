<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsletterRequest;
use App\Jobs\SendNewsletterJob;
use App\Models\Newsletter;
use App\Models\Subscriber;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class NewsletterController extends Controller
{
    public function index(): View
    {
        return view('admin.newsletter.index', [
            'subscribers' => Subscriber::latest()->paginate(15, ['*'], 'subscribers_page'),
            'newsletters' => Newsletter::latest()->paginate(10, ['*'], 'newsletters_page'),
            'counts' => Subscriber::query()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
        ]);
    }

    public function create(): View
    {
        return view('admin.newsletter.create');
    }

    public function store(NewsletterRequest $request): RedirectResponse
    {
        Newsletter::create($request->validated());

        return redirect()->route('newsletters.index')->with('success', 'Newsletter saved. Press "Send" to deliver it to confirmed subscribers.');
    }

    public function send(int $id): RedirectResponse
    {
        $newsletter = Newsletter::findOrFail($id);
        $recipients = Subscriber::confirmed()->count();

        if ($recipients === 0) {
            return redirect()->route('newsletters.index')->with('error', 'There are no confirmed subscribers to send to.');
        }

        // Atomic claim: only one request can flip sent_at from NULL, so a double click never sends twice.
        $claimed = Newsletter::whereKey($newsletter->id)->whereNull('sent_at')
            ->update(['sent_at' => now(), 'recipients_count' => $recipients]);

        if (! $claimed) {
            return redirect()->route('newsletters.index')->with('error', 'This newsletter has already been sent.');
        }

        SendNewsletterJob::dispatch($newsletter->refresh());

        return redirect()->route('newsletters.index')->with('success', "Newsletter is being sent to {$recipients} subscriber(s).");
    }

    public function destroySubscriber(int $id): RedirectResponse
    {
        Subscriber::findOrFail($id)->delete();

        return redirect()->route('newsletters.index')->with('success', 'Subscriber deleted.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $newsletter = Newsletter::findOrFail($id);

        if ($newsletter->isSent()) {
            return redirect()->route('newsletters.index')->with('error', 'A sent newsletter stays in the history.');
        }

        $newsletter->delete();

        return redirect()->route('newsletters.index')->with('success', 'Draft deleted.');
    }
}
