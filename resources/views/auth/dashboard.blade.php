@extends('layouts.admin')

@section('content')
<section>
    <main class="main-content">
        <div class="content">
            <h1>Вітаємо в Адмін Панелі!</h1>
        </div>
        <div class="stats">
            <div class="stat-card">
                <h3>Кількість користувачів</h3>
                <p>1,234</p>
            </div>
            <div class="stat-card">
                <h3>Продукти в наявності</h3>
                <p>678</p>
            </div>
            <div class="stat-card">
                <h3>Нове замовлення</h3>
                <p>15</p>
            </div>
        </div>
    </main>   
</section>
@endsection