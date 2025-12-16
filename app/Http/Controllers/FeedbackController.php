<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        $tags = Tag::withFeedbackCount()->orderBy('name')->get();

        return view('feedback.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'required|string|min:5|max:200',
            'message' => 'required|string|min:10|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ], [
            'category_id.required' => 'Выберите категорию',
            'name.required' => 'Поле "Имя" обязательно для заполнения',
            'name.min' => 'Имя должно содержать минимум 2 символа',
            'email.required' => 'Поле "Email" обязательно для заполнения',
            'email.email' => 'Введите корректный email адрес',
            'subject.required' => 'Поле "Тема" обязательно для заполнения',
            'message.required' => 'Поле "Сообщение" обязательно для заполнения',
        ]);

        try {
            $feedback = DB::transaction(function () use ($validated, $request) {
                $feedback = Feedback::create($validated);

                if ($request->has('tags') && is_array($request->tags)) {
                    $feedback->tags()->attach($request->tags);
                }

                return $feedback;
            });

            return redirect()->route('feedback.create')
                ->with('success', 'Ваше сообщение успешно отправлено! Спасибо за обратную связь.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Произошла ошибка при отправке. Попробуйте снова.');
        }
    }

    public function index(Request $request)
    {
        $query = Feedback::query()
            ->withRelations()
            ->withCount('comments');

        if ($request->filled('status')) {
            $query->status($request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->boolean('rated')) {
            $query->rated();
        }

        $feedbacks = $query->recent()->paginate(15)->withQueryString();

        $categories = Category::active()->withCount('feedbacks')->get();
        $statuses = [
            'pending' => 'Новый',
            'in_progress' => 'В работе',
            'resolved' => 'Решен',
            'closed' => 'Закрыт'
        ];

        return view('feedback.index', compact('feedbacks', 'categories', 'statuses'));
    }

    public function show(Feedback $feedback)
    {
        $feedback->load([
            'category',
            'user',
            'tags',
            'comments' => fn($q) => $q->approved()->withRelations()->recent()
        ]);

        return view('feedback.show', compact('feedback'));
    }

    public function edit(Feedback $feedback)
    {
        $categories = Category::active()->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $selectedTags = $feedback->tags->pluck('id')->toArray();

        return view('feedback.edit', compact('feedback', 'categories', 'tags', 'selectedTags'));
    }

    public function update(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subject' => 'required|string|min:5|max:200',
            'message' => 'required|string|min:10|max:1000',
            'status' => 'required|in:pending,in_progress,resolved,closed',
            'rating' => 'nullable|integer|min:1|max:5',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        DB::transaction(function () use ($feedback, $validated, $request) {
            $feedback->update($validated);

            if ($request->has('tags')) {
                $feedback->tags()->sync($request->tags);
            } else {
                $feedback->tags()->detach();
            }
        });

        return redirect()->route('feedback.show', $feedback)
            ->with('success', 'Отзыв успешно обновлен');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('feedback.index')
            ->with('success', 'Отзыв успешно удален');
    }
}
