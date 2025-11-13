<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FeedbackController extends Controller
{
    private $storageDirectory = 'feedback';

    public function create()
    {
        return view('feedback.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'required|string|min:5|max:200',
            'message' => 'required|string|min:10|max:1000',
        ], [
            'name.required' => 'Поле "Имя" обязательно для заполнения',
            'name.min' => 'Имя должно содержать минимум 2 символа',
            'name.max' => 'Имя не должно превышать 100 символов',
            'email.required' => 'Поле "Email" обязательно для заполнения',
            'email.email' => 'Введите корректный email адрес',
            'subject.required' => 'Поле "Тема" обязательно для заполнения',
            'subject.min' => 'Тема должна содержать минимум 5 символов',
            'message.required' => 'Поле "Сообщение" обязательно для заполнения',
            'message.min' => 'Сообщение должно содержать минимум 10 символов',
            'message.max' => 'Сообщение не должно превышать 1000 символов',
        ]);

        $data = array_merge($validated, [
            'created_at' => now()->format('Y-m-d H:i:s'),
            'id' => Str::uuid()->toString()
        ]);

        if (!Storage::exists($this->storageDirectory)) {
            Storage::makeDirectory($this->storageDirectory);
        }

        $filename = 'feedback_' . time() . '_' . Str::random(8) . '.json';
        $filepath = $this->storageDirectory . '/' . $filename;

        Storage::put($filepath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('feedback.create')
            ->with('success', 'Ваше сообщение успешно отправлено! Спасибо за обратную связь.');
    }

    public function index()
    {
        $feedbacks = [];

        if (Storage::exists($this->storageDirectory)) {
            $files = Storage::files($this->storageDirectory);

            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
                    $content = Storage::get($file);
                    $feedback = json_decode($content, true);
                    if ($feedback) {
                        $feedbacks[] = $feedback;
                    }
                }
            }

            usort($feedbacks, function ($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });
        }

        return view('feedback.index', compact('feedbacks'));
    }
}