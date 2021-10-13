<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Board\{CreateBoardRequest, UpdateBoardRequest,ListBoardRequest,DeleteBoardRequest,RetrieveBoardRequest};
use App\Models\Board;

class BoardController extends Controller {

    public function create (CreateBoardRequest $request) {
        try {
            $board = Board::create($request->validated());

            return response()->json($board);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateBoardRequest $request) {
        try {
            $board = Board::findOrFail($request->id);

            $board->update($request->validated());

            return response()->json($board);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id, RetrieveBoardRequest $request) {
        try {
            return response()->json(Board::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (ListBoardRequest $request) {

        try {
            $boards = Board::orderBy('id', 'desc')->paginate(5);

            return response()->json($boards);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
