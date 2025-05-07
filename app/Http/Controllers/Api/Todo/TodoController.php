<?php

namespace App\Http\Controllers\Api\Todo;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Todo\TodoRequest;
use App\Http\Resources\Todo\TodoResource;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::query()->where('user_id', auth()->id())->get();


        return TodoResource::collection($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoRequest $request)
    {
        $todo = Todo::create($request->only('title', 'body') + [
            'user_id'=> auth()->id(),
        ]);

        return response()->json([
            'data'  =>new TodoResource($todo)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        Gate::authorize('view', $todo);

        return new TodoResource($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        Gate::authorize('update', $todo);

        $todo->update($request->only('title', 'body'));

        return response()->json(['data'=>new TodoResource($todo)], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        Gate::authorize('delete', $todo);

        $todo->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
