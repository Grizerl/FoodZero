@extends('layouts.admin')

@php
   $badges = ['confirmed' => 'success', 'pending' => 'warning', 'unsubscribed' => 'secondary'];
@endphp

@section('content')
   <section>
      @if(session('success'))
         <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&#10006;</button>
            <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
         </div>
      @endif
      @if(session('error'))
         <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&#10006;</button>
            <h4><i class="icon fa fa-ban"></i>{{ session('error') }}</h4>
         </div>
      @endif

      <div class="card">
         <div class="card-header">
            <h3 class="card-title">Newsletters</h3>
            <div class="card-tools">
               <a href="{{ route('newsletters.create') }}" class="btn btn-primary btn-sm">New newsletter</a>
            </div>
         </div>
         <div class="card-body p-0">
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th style="width: 1%">ID</th>
                     <th>Subject</th>
                     <th>Sent</th>
                     <th>Recipients</th>
                     <th style="width: 20%"></th>
                  </tr>
               </thead>
               <tbody>
                  @forelse ($newsletters as $newsletter)
                     <tr>
                        <td>{{ $newsletter->id }}</td>
                        <td>{{ $newsletter->subject }}</td>
                        <td>{{ $newsletter->sent_at?->format('Y-m-d H:i') ?? 'Draft' }}</td>
                        <td>{{ $newsletter->isSent() ? $newsletter->recipients_count : '—' }}</td>
                        <td class="text-right">
                           @unless ($newsletter->isSent())
                              <form action="{{ route('newsletters.send', $newsletter->id) }}" method="post" class="d-inline" onsubmit="return confirm('Send this newsletter to all confirmed subscribers?');">
                                 @csrf
                                 <button type="submit" class="btn btn-success btn-sm">Send</button>
                              </form>
                              <form action="{{ route('newsletters.destroy', $newsletter->id) }}" method="post" class="d-inline" onsubmit="return confirm('Delete this draft?');">
                                 @csrf
                                 @method('DELETE')
                                 <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>
                           @endunless
                        </td>
                     </tr>
                  @empty
                     <tr><td colspan="5" class="text-center text-muted">No newsletters yet.</td></tr>
                  @endforelse
               </tbody>
            </table>
         </div>
         @if ($newsletters->hasPages())
            <div class="card-footer">{{ $newsletters->links() }}</div>
         @endif
      </div>

      <div class="card">
         <div class="card-header">
            <h3 class="card-title">
               Subscribers —
               confirmed: {{ $counts['confirmed'] ?? 0 }},
               pending: {{ $counts['pending'] ?? 0 }},
               unsubscribed: {{ $counts['unsubscribed'] ?? 0 }}
            </h3>
         </div>
         <div class="card-body p-0">
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th style="width: 1%">ID</th>
                     <th>Email</th>
                     <th>Status</th>
                     <th>Subscribed</th>
                     <th>Confirmed</th>
                     <th style="width: 10%"></th>
                  </tr>
               </thead>
               <tbody>
                  @forelse ($subscribers as $subscriber)
                     <tr>
                        <td>{{ $subscriber->id }}</td>
                        <td>{{ $subscriber->email }}</td>
                        <td><span class="badge badge-{{ $badges[$subscriber->status] ?? 'light' }}">{{ $subscriber->status }}</span></td>
                        <td>{{ $subscriber->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $subscriber->confirmed_at?->format('Y-m-d H:i') ?? '—' }}</td>
                        <td class="text-right">
                           <form action="{{ route('newsletters.subscribers.destroy', $subscriber->id) }}" method="post" onsubmit="return confirm('Delete this subscriber permanently?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                           </form>
                        </td>
                     </tr>
                  @empty
                     <tr><td colspan="6" class="text-center text-muted">No subscribers yet.</td></tr>
                  @endforelse
               </tbody>
            </table>
         </div>
         @if ($subscribers->hasPages())
            <div class="card-footer">{{ $subscribers->links() }}</div>
         @endif
      </div>
   </section>
@endsection
