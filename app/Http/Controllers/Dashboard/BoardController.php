<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Board\{CreateBoardRequest, UpdateBoardRequest, ListBoardRequest, DeleteBoardRequest, RetrieveBoardRequest};
use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{

    public function create(CreateBoardRequest $request)
    {
        try {
            $board = Board::create($request->validated());

            return response()->json($board);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateBoardRequest $request)
    {
        try {
            $board = Board::findOrFail($request->id);

            $board->update($request->validated());

            return response()->json($board);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve($id, RetrieveBoardRequest $request)
    {
        try {
            return response()->json(Board::with('labels')->findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
    public function search(Request $request)
    {
        try {
            $boards = Board::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name', 'like', "%" . $request->q . "%");
                }
            })->take(10)->get()->map(function ($board) {
                return  ['id' => $board->id, 'text' => $board->name];
            });
            return response()->json($boards);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list(ListBoardRequest $request)
    {

        try {
            $boards = Board::orderBy('id', 'desc')->paginate(5);

            return response()->json($boards);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
    public function retrieveWithTasks($id, RetrieveBoardRequest $request)
    {

        try {
            return response()->json(Board::with(['labels', 'tasks.labels', 'tasks.reporter', 'tasks.asignee'])->findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
