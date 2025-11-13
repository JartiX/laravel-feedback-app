@extends('layouts.app')

@section('title', 'О проекте - Feedback App')

@section('styles')
    .about-container {
        max-width: 900px;
        margin: 0 auto;
        background: #fff;
        padding: 50px 60px;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .page-title {
        text-align: center;
        font-size: 38px;
        margin-bottom: 40px;
        color: #2d3748;
        font-weight: 700;
    }

    .about-container h3 {
        font-size: 24px;
        margin-top: 35px;
        margin-bottom: 15px;
        color: #5a67d8;
    }

    .about-container p, 
    .about-container li {
        line-height: 1.8;
        color: #4a5568;
        font-size: 17px;
    }

    .about-container ul {
        margin-left: 25px;
        list-style-type: disc;
    }

    .about-container section {
        margin-bottom: 40px;
    }

    .tech-stack {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 20px;
    }

    .tech-item {
        padding: 10px 18px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 25px;
        font-weight: 600;
        font-size: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }

    .tech-item:hover {
        transform: translateY(-3px);
    }
@endsection

@section('content')
    <div class="about-container">
        <h1 class="page-title">О проекте Feedback App</h1>

        <section>
            <p>
                <strong>Feedback App</strong> — это современное веб-приложение для сбора и управления обратной связью,
                разработанное на фреймворке <strong>Laravel</strong>. Оно позволяет пользователям оставлять отзывы,
                а администраторам — удобно просматривать и анализировать их.
            </p>
        </section>

        <section>
            <h3>Основные возможности</h3>
            <ul>
                <li>Простая и интуитивная форма для отправки отзывов</li>
                <li>Серверная валидация всех данных</li>
                <li>Сохранение отзывов в формате JSON с уникальными именами</li>
                <li>Удобный просмотр всех отзывов в табличном виде</li>
                <li>Автоматическая сортировка по дате</li>
                <li>Адаптивный дизайн</li>
            </ul>
        </section>

        <section>
            <h3>Версия</h3>
            <p><strong>v1.0</strong> — первая стабильная версия приложения.</p>
        </section>

        <section>
            <h3>Архитектура</h3>
            <p>
                Приложение построено на архитектуре MVC (Model-View-Controller) и использует ключевые компоненты Laravel:
            </p>
            <ul>
                <li><strong>Routing</strong> — обработка HTTP-запросов</li>
                <li><strong>Controllers</strong> — реализация бизнес-логики</li>
                <li><strong>Blade</strong> — шаблонизация представлений</li>
                <li><strong>Validation</strong> — проверка корректности данных</li>
                <li><strong>Storage</strong> — работа с файловой системой</li>
                <li><strong>Session</strong> — передача сообщений между запросами</li>
            </ul>
        </section>
    </div>
@endsection
