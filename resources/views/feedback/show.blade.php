@extends('layouts.app')

@section('title', 'Просмотр отзыва - ' . $feedback->subject)

@section('styles')
    .feedback-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }
    .feedback-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    .feedback-header {
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }
    .feedback-title {
        font-size: 28px;
        color: #2d3748;
        margin-bottom: 10px;
    }
    .feedback-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        color: #718096;
        font-size: 14px;
    }
    .feedback-body {
        line-height: 1.8;
        color: #4a5568;
        margin-bottom: 20px;
    }
    .feedback-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }
    .tag-badge {
        background: #edf2f7;
        color: #4a5568;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 14px;
    }
    .status-badge {
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }
    .status-pending { background: #fef5e7; color: #f39c12; }
    .status-in_progress { background: #ebf5fb; color: #3498db; }
    .status-resolved { background: #eafaf1; color: #27ae60; }
    .status-closed { background: #f4f4f4; color: #7f8c8d; }
    .rating {
        color: #f39c12;
        font-size: 20px;
    }
    .actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-primary {
        background: #667eea;
        color: white;
    }
    .btn-danger {
        background: #e53e3e;
        color: white;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .comments-section {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .comment {
        border-left: 3px solid #667eea;
        padding: 15px;
        margin-bottom: 15px;
        background: #f7fafc;
        border-radius: 8px;
    }
    .comment-author {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 5px;
    }
    .comment-date {
        font-size: 12px;
        color: #a0aec0;
        margin-bottom: 10px;
    }
@endsection

@section('content')
    <div class="feedback-container">
        <div class="feedback-card">
            <div class="feedback-header">
                <h1 class="feedback-title">{{ $feedback->subject }}</h1>
                <div class="feedback-meta">
                    <span><strong>От:</strong> {{ $feedback->name }} ({{ $feedback->email }})</span>
                    <span><strong>Категория:</strong> {{ $feedback->category->name }}</span>
                    <span><strong>Дата:</strong> {{ $feedback->created_at->format('d.m.Y H:i') }}</span>
                    <span class="status-badge status-{{ $feedback->status }}">
                        @switch($feedback->status)
                            @case('pending') Новый @break
                            @case('in_progress') В работе @break
                            @case('resolved') Решен @break
                            @case('closed') Закрыт @break
                        @endswitch
                    </span>
                    @if($feedback->rating)
                        <span class="rating">
                            @for($i = 1; $i <= $feedback->rating; $i++) ⭐ @endfor
                        </span>
                    @endif
                </div>
            </div>

            <div class="feedback-body">
                {{ $feedback->message }}
            </div>

            @if($feedback->tags->count() > 0)
                <div class="feedback-tags">
                    @foreach($feedback->tags as $tag)
                        <span class="tag-badge">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif

            <div class="actions">
                <a href="{{ route('feedback.index') }}" class="btn btn-primary">← Назад к списку</a>
                <a href="{{ route('feedback.edit', $feedback) }}" class="btn btn-primary">Редактировать</a>
                <form method="POST" action="{{ route('feedback.destroy', $feedback) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить отзыв?')">Удалить</button>
                </form>
            </div>
        </div>

        @if($feedback->comments->count() > 0)
            <div class="comments-section">
                <h3 style="margin-bottom: 20px;">Комментарии ({{ $feedback->comments->count() }})</h3>
                @foreach($feedback->comments as $comment)
                    <div class="comment">
                        <div class="comment-author">{{ $comment->user->name ?? 'Аноним' }}</div>
                        <div class="comment-date">{{ $comment->created_at->format('d.m.Y H:i') }}</div>
                        <div>{{ $comment->content }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
