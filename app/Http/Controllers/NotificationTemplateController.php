<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NotificationTemplate\{CreateNotificationTemplateRequest, UpdateNotificationTemplateRequest};
use App\Models\NotificationTemplate;

class NotificationTemplateController extends Controller
{
    public function create(CreateNotificationTemplateRequest $request)
    {
        try {
            return response()->json(NotificationTemplate::create($request->validated()));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(UpdateNotificationTemplateRequest $request)
    {
        try {
            $notificationTemplate = NotificationTemplate::findOrFail($request->id);
            $notificationTemplate->update($request->validated());
            return response()->json($notificationTemplate);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function retrieve($id)
    {
        try {
            return response()->json(NotificationTemplate::findOrFail($id));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list(Request $request)
    {
        try {
            $notificationTemplate = NotificationTemplate::orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name', 'like', '%' . $request->q . '%');
                    $q->orWhere('body->ar', 'like', '%' . $request->q . '%');
                    $q->orWhere('body->en', 'like', '%' . $request->q . '%');
                }
            })->paginate(5)->withQueryString();
            return response()->json($notificationTemplate);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
