<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FeedbackApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Feedback::query()->withRelations();

        if ($request->has('status')) {
            $query->status($request->status);
        }

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->boolean('only_rated')) {
            $query->rated();
        }

        if ($request->boolean('only_pending')) {
            $query->pending();
        }

        $query->recent();

        $feedbacks = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => FeedbackResource::collection($feedbacks),
            'meta' => [
                'current_page' => $feedbacks->currentPage(),
                'last_page' => $feedbacks->lastPage(),
                'per_page' => $feedbacks->perPage(),
                'total' => $feedbacks->total(),
            ]
        ]);
    }

    public function show(Feedback $feedback): JsonResponse
    {
        $feedback->load(['user', 'category', 'tags', 'comments.user']);

        return response()->json([
            'success' => true,
            'data' => new FeedbackResource($feedback)
        ]);
    }

    public function store(Request $request): JsonResponse
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
        ]);

        $feedback = Feedback::create($validated);

        if ($request->has('tags')) {
            $feedback->tags()->attach($request->tags);
        }

        $feedback->load(['category', 'tags']);

        return response()->json([
            'success' => true,
            'message' => 'Отзыв успешно создан',
            'data' => new FeedbackResource($feedback)
        ], 201);
    }

    public function update(Request $request, Feedback $feedback): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|min:2|max:100',
            'email' => 'sometimes|email|max:100',
            'subject' => 'sometimes|string|min:5|max:200',
            'message' => 'sometimes|string|min:10|max:1000',
            'status' => 'sometimes|in:pending,in_progress,resolved,closed',
            'rating' => 'nullable|integer|min:1|max:5',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $feedback->update($validated);

        if ($request->has('tags')) {
            $feedback->tags()->sync($request->tags);
        }

        $feedback->load(['category', 'tags']);

        return response()->json([
            'success' => true,
            'message' => 'Отзыв успешно обновлен',
            'data' => new FeedbackResource($feedback)
        ]);
    }

    public function destroy(Feedback $feedback): JsonResponse
    {
        $feedback->delete();

        return response()->json([
            'success' => true,
            'message' => 'Отзыв успешно удален'
        ]);
    }

    public function restore(int $id): JsonResponse
    {
        $feedback = Feedback::withTrashed()->findOrFail($id);
        $feedback->restore();

        return response()->json([
            'success' => true,
            'message' => 'Отзыв восстановлен',
            'data' => new FeedbackResource($feedback)
        ]);
    }

    public function forceDelete(int $id): JsonResponse
    {
        $feedback = Feedback::withTrashed()->findOrFail($id);
        $feedback->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Отзыв окончательно удален'
        ]);
    }

    public function trashed(): JsonResponse
    {
        $feedbacks = Feedback::onlyTrashed()->withRelations()->recent()->paginate(15);

        return response()->json([
            'success' => true,
            'data' => FeedbackResource::collection($feedbacks),
            'meta' => [
                'total' => $feedbacks->total(),
            ]
        ]);
    }
}