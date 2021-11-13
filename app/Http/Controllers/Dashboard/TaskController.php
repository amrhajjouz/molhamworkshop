<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\{CreateTaskRequest, UpdateTaskRequest, ListTaskRequest, DeleteTaskRequest, RetrieveTaskRequest};
use App\Models\Task;

class TaskController extends Controller
{

    public function create(CreateTaskRequest $request)
    {
        try {
            $task = Task::create($request->safe()->except(['labels']));
            $task->labels()->sync($request->safe()->only(['labels'])['labels']);

            return response()->json($task);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateTaskRequest $request)
    {
        try {
            $task = Task::findOrFail($request->id);

            $task->update($request->safe()->except(['labels']));
            $task->labels()->sync($request->safe()->only(['labels'])['labels']);
            return response()->json($task);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve($id, RetrieveTaskRequest $request)
    {
        try {
            return response()->json(Task::with(['board', 'labels'])->findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list(ListTaskRequest $request)
    {

        try {
            $tasks = Task::with(['board', 'labels'])->orderBy('id', 'desc')->paginate(5);

            return response()->json($tasks);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
    public function remove($id)
    {

        try {
            $task = Task::findOrFail($id);
            $task->labels()->sync([]);
            Task::destroy($id);

            return response()->json();
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
