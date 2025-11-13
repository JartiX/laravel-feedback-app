<header class="header">
    <div class="container header-inner">
        <div class="logo">
            <span class="logo-icon">FB</span>
            <span class="logo-text">Feedback App</span>
        </div>

        <nav class="nav">
            <a href="{{ route('home') }}">Главная</a>
            <a href="{{ route('feedback.create') }}">Обратная связь</a>
            <a href="{{ route('feedback.index') }}">Отзывы</a>
            <a href="{{ route('about') }}">О проекте</a>
        </nav>
    </div>
</header>