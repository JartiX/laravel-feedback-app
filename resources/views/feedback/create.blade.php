@extends('layouts.app')

@section('title', 'Обратная связь - Feedback App')

@section('styles')
    .form-container {
        max-width: 700px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .form-title {
        text-align: center;
        font-size: 32px;
        margin-bottom: 30px;
        color: #2d3748;
    }
    .form-group {
        margin-bottom: 25px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #4a5568;
    }
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s;
    }
    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
    }
    .form-group textarea {
        resize: vertical;
        min-height: 150px;
    }
    .error-message {
        color: #e53e3e;
        font-size: 14px;
        margin-top: 5px;
    }
    .success-message {
        background: #c6f6d5;
        color: #22543d;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        border-left: 4px solid #38a169;
    }
    .submit-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
@endsection

@section('content')
    <div class="form-container">
        <h2 class="form-title">Форма обратной связи</h2>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('feedback.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Имя *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="subject">Тема *</label>
                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required>
                @error('subject')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="message">Сообщение *</label>
                <textarea name="message" id="message" required>{{ old('message') }}</textarea>
                @error('message')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="submit-btn">Отправить сообщение</button>
        </form>
    </div>
@endsection
