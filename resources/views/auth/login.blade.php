<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign in | FoodZero Admin</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/images/Brand.png') }}">
  <link rel="stylesheet" href="@assetv('assets/css/auth/login.css')">
</head>
<body>
  <main class="login-page">
    <a class="login-logo" href="{{ route('home.page') }}" aria-label="FoodZero — back to the website">
      <svg class="login-logo__mark" width="34" height="34" viewBox="0 0 34 34" fill="none" aria-hidden="true" focusable="false">
        <circle cx="17" cy="17" r="16" stroke="currentColor" stroke-width="2" opacity=".45"/>
        <path d="M10 24c-.5-8 4.5-13.5 14-14.5.5 9.5-4.5 14.5-14 14.5Z" fill="currentColor"/>
        <path d="M10 24c3.2-4.6 6.6-7.7 10.6-9.8" stroke="#233000" stroke-width="1.6" stroke-linecap="round"/>
      </svg>
      <span>FoodZero</span>
    </a>
    <div class="login-container">
      <h1 class="login-title">Admin sign in</h1>
      <p class="login-lead">Welcome back. Sign in to manage the menu, the blog and reservations.</p>
      @if (session('message'))
        <div class="login-error" role="alert">{{ session('message') }}</div>
      @endif
      <form action="{{ route('admin.login.submit') }}" method="post">
        @csrf
        <div class="input-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="username" required autofocus>
          @error('email')
            <div class="alert-danger" role="alert">{{ $message }}</div>
          @enderror
        </div>
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
          @error('password')
            <div class="alert-danger" role="alert">{{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="login-btn">Sign in</button>
      </form>
    </div>
    <a class="login-back" href="{{ route('home.page') }}">&larr; Back to the website</a>
  </main>
</body>
</html>
