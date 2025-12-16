@extends('layouts.app')

@section('title', 'Все отзывы - Feedback App')

@section('styles')
    .page-title {
        text-align: center;
        font-size: 36px;
        margin-bottom: 30px;
        color: #2d3748;
    }
    .stats {
        text-align: center;
        margin-bottom: 30px;
        font-size: 18px;
        color: #4a5568;
    }
    .filters {
        background: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    .filters form {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: end;
    }
    .filter-group {
        flex: 1;
        min-width: 200px;
    }
    .filter-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: #4a5568;
    }
    .filter-group input,
    .filter-group select {
        width: 100%;
        padding: 10px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
    }
    .filter-btn {
        padding: 10px 20px;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
    }
    .filter-btn:hover {
        background: #5568d3;
    }
    .filter-btn-reset {
        background: #e2e8f0;
        color: #4a5568;
    }
    .filter-btn-reset:hover {
        background: #cbd5e0;
    }
    .table-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        overflow-x: auto;
    }
    table {
        width: 100%;
        min-width: 1000px;
        border-collapse: collapse;
        table-layout: fixed;
    }
    thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    th {
        padding: 15px 10px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
    }
    td {
        padding: 15px 10px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 14px;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    tbody tr:hover {
        background: #f7fafc;
    }
    tbody tr:last-child td {
        border-bottom: none;
    }

    /* Конкретные ширины для колонок */
    th:nth-child(1), td:nth-child(1) { width: 110px; } /* Дата */
    th:nth-child(2), td:nth-child(2) { width: 120px; } /* Имя */
    th:nth-child(3), td:nth-child(3) { width: 150px; } /* Email */
    th:nth-child(4), td:nth-child(4) { width: 100px; } /* Категория */
    th:nth-child(5), td:nth-child(5) { width: 200px; } /* Тема */
    th:nth-child(6), td:nth-child(6) { width: 100px; } /* Статус */
    th:nth-child(7), td:nth-child(7) { width: 80px; } /* Оценка */
    th:nth-child(8), td:nth-child(8) { width: 70px; text-align: center; } /* Комментарии */
    th:nth-child(9), td:nth-child(9) { width: 90px; text-align: center; } /* Действия */

    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: #a0aec0;
        font-size: 18px;
    }
    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: block;
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }
    .status-pending { background: #fef5e7; color: #f39c12; }
    .status-in_progress { background: #ebf5fb; color: #3498db; }
    .status-resolved { background: #eafaf1; color: #27ae60; }
    .status-closed { background: #f4f4f4; color: #7f8c8d; }
    .rating {
        color: #f39c12;
        white-space: nowrap;
    }
    .add-feedback {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 25px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: transform 0.3s, box-shadow 0.3s;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    .add-feedback:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    }
    .pagination-wrapper {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }
    .pagination {
        display: flex;
        gap: 8px;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .pagination li {
        display: inline-block;
    }
    .pagination a,
    .pagination span {
        display: inline-block;
        padding: 10px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        text-decoration: none;
        color: #4a5568;
        font-weight: 500;
        transition: all 0.3s;
    }
    .pagination a:hover {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }
    .pagination .active span {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }
    .pagination .disabled span {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .view-link {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        white-space: nowrap;
    }
    .view-link:hover {
        text-decoration: underline;
    }
    .success-message {
        background: #c6f6d5;
        color: #22543d;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        border-left: 4px solid #38a169;
        text-align: center;
    }

    /* Адаптивность для мобильных */
    @media (max-width: 768px) {
        .table-container {
            overflow-x: scroll;
        }
    }
@endsection

@section('content')
    <h2 class="page-title">Все отзывы</h2>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="{{ route('feedback.create') }}" class="add-feedback">+ Добавить отзыв</a>
    </div>

    <p class="stats">Всего отзывов: {{ $feedbacks->total() }}</p>

    <!-- Фильтры -->
    <div class="filters">
        <form method="GET" action="{{ route('feedback.index') }}">
            <div class="filter-group">
                <label>Поиск</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Поиск по теме, сообщению...">
            </div>

            <div class="filter-group">
                <label>Категория</label>
                <select name="category_id">
                    <option value="">Все категории</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }} ({{ $category->feedbacks_count }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label>Статус</label>
                <select name="status">
                    <option value="">Все статусы</option>
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label>С оценкой</label>
                <select name="rated">
                    <option value="">Все</option>
                    <option value="1" {{ request('rated') == '1' ? 'selected' : '' }}>Только с оценкой</option>
                </select>
            </div>

            <button type="submit" class="filter-btn">Применить</button>
            <a href="{{ route('feedback.index') }}" class="filter-btn filter-btn-reset">Сбросить</a>
        </form>
    </div>

    @if($feedbacks->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Категория</th>
                        <th>Тема</th>
                        <th>Статус</th>
                        <th>Оценка</th>
                        <th>Комм.</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feedbacks as $feedback)
                        <tr>
                            <td>{{ $feedback->created_at->format('d.m.Y') }}<br><small style="color: #a0aec0;">{{ $feedback->created_at->format('H:i') }}</small></td>
                            <td><span class="text-truncate" title="{{ $feedback->name }}">{{ $feedback->name }}</span></td>
                            <td><span class="text-truncate" title="{{ $feedback->email }}">{{ $feedback->email }}</span></td>
                            <td><span class="text-truncate" title="{{ $feedback->category->name ?? '-' }}">{{ $feedback->category->name ?? '-' }}</span></td>
                            <td><span class="text-truncate" title="{{ $feedback->subject }}">{{ $feedback->subject }}</span></td>
                            <td>
                                <span class="status-badge status-{{ $feedback->status }}">
                                    @switch($feedback->status)
                                        @case('pending') Новый @break
                                        @case('in_progress') В работе @break
                                        @case('resolved') Решен @break
                                        @case('closed') Закрыт @break
                                    @endswitch
                                </span>
                            </td>
                            <td class="rating">
                                @if($feedback->rating)
                                    @for($i = 1; $i <= $feedback->rating; $i++) ⭐ @endfor
                                @else
                                    <span style="color: #cbd5e0;">-</span>
                                @endif
                            </td>
                            <td style="text-align: center;">{{ $feedback->comments_count ?? 0 }}</td>
                            <td style="text-align: center;">
                                <a href="{{ route('feedback.show', $feedback) }}" class="view-link">Просмотр</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Пагинация -->
        @if($feedbacks->hasPages())
            <div class="pagination-wrapper">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($feedbacks->onFirstPage())
                        <li class="disabled"><span>« Назад</span></li>
                    @else
                        <li><a href="{{ $feedbacks->previousPageUrl() }}" rel="prev">« Назад</a></li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($feedbacks->getUrlRange(1, $feedbacks->lastPage()) as $page => $url)
                        @if ($page == $feedbacks->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($feedbacks->hasMorePages())
                        <li><a href="{{ $feedbacks->nextPageUrl() }}" rel="next">Вперед »</a></li>
                    @else
                        <li class="disabled"><span>Вперед »</span></li>
                    @endif
                </ul>
            </div>
        @endif
    @else
        <div class="no-data">
            @if(request()->hasAny(['search', 'category_id', 'status', 'rated']))
                Ничего не найдено по заданным фильтрам.
            @else
                Пока нет отзывов. Станьте первым!
            @endif
            <br>
            <a href="{{ route('feedback.create') }}" class="add-feedback">Оставить отзыв →</a>
        </div>
    @endif
@endsection
