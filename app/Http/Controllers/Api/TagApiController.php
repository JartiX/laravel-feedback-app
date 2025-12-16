<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class TagApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Tag::query();

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->boolean('popular')) {
            $query->popular($request->get('limit', 10));
        } else {
            $query->withFeedbackCount();
        }

        $tags = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => TagResource::collection($tags),
            'meta' => [
                'total' => $tags->total(),
            ]
        ]);
    }

    public function show(Tag $tag): JsonResponse
    {
        $tag->loadCount('feedbacks');

        return response()->json([
            'success' => true,
            'data' => new TagResource($tag)
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:tags,name',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $tag = Tag::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Тег создан',
            'data' => new TagResource($tag)
        ], 201);
    }

    public function update(Request $request, Tag $tag): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:50|unique:tags,name,' . $tag->id,
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $tag->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Тег обновлен',
            'data' => new TagResource($tag)
        ]);
    }

    public function destroy(Tag $tag): JsonResponse
    {
        $tag->delete();

        return response()->json([
            'success' => true,
            'message' => 'Тег удален'
        ]);
    }

    public function popular(): JsonResponse
    {
        $tags = Tag::popular(10)->get();

        return response()->json([
            'success' => true,
            'data' => TagResource::collection($tags)
        ]);
    }
}
