<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($sort = $request->get('sort')) {
            $query->orderBy($sort, 'asc');
        }

        return TaskResource::collection($query->get());
    }

    public function store(StoreTaskRequest $request): TaskResource
    {
        $task = Task::create($request->validated());
        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        $task->update($request->validated());
        return new TaskResource($task);
    }

    public function destroy(Task $task): Response
    {
        $task->delete();
        return response()->noContent();
    }
}
