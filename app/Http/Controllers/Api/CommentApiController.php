<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Comment::query()->withRelations();

        if ($request->boolean('only_approved')) {
            $query->approved();
        }

        if ($request->boolean('only_pending')) {
            $query->pending();
        }

        $query->recent();

        $comments = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => CommentResource::collection($comments),
            'meta' => [
                'total' => $comments->total(),
            ]
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'commentable_type' => 'required|string|in:App\Models\Feedback',
            'commentable_id' => 'required|integer',
            'content' => 'required|string|min:5|max:1000',
        ]);

        $comment = Comment::create($validated);
        $comment->load(['user', 'commentable']);

        return response()->json([
            'success' => true,
            'message' => 'Комментарий создан',
            'data' => new CommentResource($comment)
        ], 201);
    }

    public function approve(Comment $comment): JsonResponse
    {
        $comment->update(['is_approved' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Комментарий одобрен',
            'data' => new CommentResource($comment)
        ]);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Комментарий удален'
        ]);
    }

    public function forEntity(string $type, int $id): JsonResponse
    {
        $modelClass = 'App\\Models\\' . ucfirst($type);

        if (!class_exists($modelClass)) {
            return response()->json([
                'success' => false,
                'message' => 'Недопустимый тип сущности'
            ], 400);
        }

        $comments = Comment::where('commentable_type', $modelClass)
            ->where('commentable_id', $id)
            ->approved()
            ->withRelations()
            ->recent()
            ->get();

        return response()->json([
            'success' => true,
            'data' => CommentResource::collection($comments)
        ]);
    }
}
