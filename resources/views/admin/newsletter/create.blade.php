@extends('layouts.admin')

@section('content')
   <div class="pt-3 pl-3">
      <h3>New Newsletter</h3>
   </div>
   <div class="card-body pb-0">
      <form action="{{ route('newsletters.store') }}" method="post">
         @csrf
         <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" maxlength="255" class="form-control @error('subject') is-invalid @enderror" placeholder="Enter the subject">
            @error('subject')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
         </div>
         <div class="form-group">
            <label for="body">Text</label>
            <textarea id="body" name="body" rows="12" class="form-control @error('body') is-invalid @enderror" placeholder="Plain text. Line breaks are kept.">{{ old('body') }}</textarea>
            @error('body')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
         </div>
         <p class="text-muted">An unsubscribe link is added to every email automatically.</p>
   </div>
   <div class="card-footer">
      <button type="submit" class="btn btn-primary">Save newsletter</button>
      <a href="{{ route('newsletters.index') }}" class="btn btn-default">Cancel</a>
   </div>
      </form>
@endsection
