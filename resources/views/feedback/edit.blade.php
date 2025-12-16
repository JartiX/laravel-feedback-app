@extends('layouts.app')

@section('title', 'Редактирование отзыва')

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
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s;
    }
    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
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
    .rating-group {
        display: flex;
        gap: 10px;
        flex-direction: row;
        align-items: center;
    }
    .rating-group input[type="radio"] {
        width: auto;
        margin: 0;
    }
    .rating-group label {
        margin: 0;
        font-weight: normal;
    }
    .tags-group {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }
    .tag-checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tag-checkbox input[type="checkbox"] {
        width: auto;
        margin: 0;
    }
@endsection

@section('content')
    <div class="form-container">
        <h2 class="form-title">Редактирование отзыва</h2>

        <form method="POST" action="{{ route('feedback.update', $feedback) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="category_id">Категория *</label>
                <select name="category_id" id="category_id" required>
                    <option value="">Выберите категорию</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $feedback->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="subject">Тема *</label>
                <input type="text" name="subject" id="subject" value="{{ old('subject', $feedback->subject) }}" required>
                @error('subject')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="message">Сообщение *</label>
                <textarea name="message" id="message" required>{{ old('message', $feedback->message) }}</textarea>
                @error('message')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Статус *</label>
                <select name="status" id="status" required>
                    <option value="pending" {{ old('status', $feedback->status) == 'pending' ? 'selected' : '' }}>Новый</option>
                    <option value="in_progress" {{ old('status', $feedback->status) == 'in_progress' ? 'selected' : '' }}>В работе</option>
                    <option value="resolved" {{ old('status', $feedback->status) == 'resolved' ? 'selected' : '' }}>Решен</option>
                    <option value="closed" {{ old('status', $feedback->status) == 'closed' ? 'selected' : '' }}>Закрыт</option>
                </select>
                @error('status')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Оценка</label>
                <div class="rating-group">
                    @for($i = 1; $i <= 5; $i++)
                        <label class="rating-label">
                            <input type="radio" name="rating" value="{{ $i }}" {{ old('rating', $feedback->rating) == $i ? 'checked' : '' }}>
                            {{ $i }} ⭐
                        </label>
                    @endfor
                </div>
                @error('rating')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Теги</label>
                <div class="tags-group">
                    @foreach($tags as $tag)
                        <label class="tag-checkbox">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                {{ in_array($tag->id, old('tags', $selectedTags)) ? 'checked' : '' }}>
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
                @error('tags')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="submit-btn">Сохранить изменения</button>
        </form>
    </div>
@endsection
