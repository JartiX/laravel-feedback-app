@extends('layouts.app')

@section('title', 'Главная - Feedback App')

@section('styles')
    .hero {
        text-align: center;
        padding: 60px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 15px;
        margin-bottom: 40px;
    }
    .hero h2 {
        font-size: 42px;
        margin-bottom: 20px;
        color: #2d3748;
    }
    .hero p {
        font-size: 20px;
        color: #4a5568;
        margin-bottom: 30px;
    }
    .btn {
        display: inline-block;
        padding: 15px 35px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: transform 0.3s, box-shadow 0.3s;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    }
    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }
    .feature {
        padding: 30px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    .feature:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
    .feature h3 {
        color: #667eea;
        margin-bottom: 15px;
        font-size: 24px;
    }
@endsection

@section('content')
    <div class="hero">
        <h2>Добро пожаловать в Feedback App</h2>
        <p>Простое и удобное приложение для сбора обратной связи</p>
        <a href="{{ route('feedback.create') }}" class="btn">Оставить отзыв</a>
    </div>

    <div class="features">
        <div class="feature">
            <h3>Простая форма</h3>
        </div>

        <div class="feature">
            <h3>Валидация</h3>
        </div>

        <div class="feature">
            <h3>Удобный просмотр</h3>
        </div>
    </div>
@endsection
