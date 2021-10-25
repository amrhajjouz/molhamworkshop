<?php

namespace App\Http\Controllers;

use App\Http\Requests\Receiver\CreateReceiverRequest;
use App\Http\Requests\Receiver\UpdateReceiverRequest;
use App\Models\Receiver;
use Exception;

class ReceiverController extends Controller
{
    public function create(CreateReceiverRequest $request)
    {
        try {
            $data = $request->validated();
            $receiver = Receiver::create($data);
            return response()->json($receiver);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateReceiverRequest $request)
    {
        try {
            $receiver = Receiver::findOrFail($request->id);
            $input = $request->validated();
            $receiver->update($input);
            return response()->json($receiver);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve($id)
    {
        try {
            $receiver = Receiver::with("country")->findOrFail($id)->append(["country_name"]);
            return response()->json($receiver->makeHidden("country"));
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list()
    {
        try {
            return Receiver::with("country")
                ->orderBy('id', 'desc')
                ->SearchByName(request()->q)
                ->PaginateWithAppend("country_name");
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
