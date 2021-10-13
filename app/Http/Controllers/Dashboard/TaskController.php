<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\{CreateTaskRequest, UpdateTaskRequest,ListTaskRequest,DeleteTaskRequest,RetrieveTaskRequest};
use App\Models\Task;

class TaskController extends Controller {

    public function create (CreateTaskRequest $request) {
        try {
            $task = Task::create($request->validated());

            return response()->json($task);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateTaskRequest $request) {
        try {
            $task = Task::findOrFail($request->id);

            $task->update($request->validated());

            return response()->json($task);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id, RetrieveTaskRequest $request) {
        try {
            return response()->json(Task::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (ListTaskRequest $request) {

        try {
            $tasks = Task::orderBy('id', 'desc')->paginate(5);

            return response()->json($tasks);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
