<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodZero-Restaurant and Food</title>
  <link rel="icon" type="image/png" href="../assets/images/Brand.png">
  <link rel="stylesheet" href="/assets/css/auth/login.css">
</head>
  <body class="d-flex">
    <header>
      <a href="{{ route('home.page') }}">
        <h2 class="navbar-logo">FoodZero</h2>
      </a>
    </header>
    <div class="login-container">
      <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="input-group">
          <label for="email">Електронна пошта</label>
            <input type="email" id="email" name="email" class="@error('email') is-invalid @enderror" placeholder="Enter your email">
          @error('email')
            <div class="alert-danger">{{ $message }}</div>
          @enderror
        </div>
        <div class="input-group">
          <label for="password">Пароль</label>
            <input type="password" id="password" name="password" class="@error('password') is-invalid @enderror" placeholder="Enter your password">
          @error('password')
            <div class="alert-danger">{{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="login-btn">Увійти</button>
      </form>
    </div>
  </body>
</html>
