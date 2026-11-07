{{-- Shown instead of a list when there is nothing to display. --}}
<div class="empty-state" role="status">
    <h2 class="empty-state-title">{{ $title }}</h2>
    @isset($text)
        <p class="empty-state-text">{{ $text }}</p>
    @endisset
</div>
