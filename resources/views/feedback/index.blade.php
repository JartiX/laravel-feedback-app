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
    .table-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
    }
    td {
        padding: 15px;
        border-bottom: 1px solid #e2e8f0;
    }
    tbody tr:hover {
        background: #f7fafc;
    }
    tbody tr:last-child td {
        border-bottom: none;
    }
    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: #a0aec0;
        font-size: 18px;
    }
    .message-cell {
        max-width: 400px;
        overflow: hidden;
        text-overflow: ellipsis;
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
@endsection

@section('content')
    <h2 class="page-title">Все отзывы</h2>

    <p class="stats">Всего отзывов: {{ count($feedbacks) }}</p>

    @if(count($feedbacks) > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Тема</th>
                        <th>Сообщение</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feedbacks as $feedback)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($feedback['created_at'])->format('d.m.Y H:i') }}</td>
                            <td>{{ $feedback['name'] }}</td>
                            <td>{{ $feedback['email'] }}</td>
                            <td>{{ $feedback['subject'] }}</td>
                            <td class="message-cell">{{ $feedback['message'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="no-data">
            Пока нет отзывов. Станьте первым!<br>
            <a href="{{ route('feedback.create') }}" class="add-feedback">Оставить отзыв →</a>
        </div>
    @endif
@endsection
