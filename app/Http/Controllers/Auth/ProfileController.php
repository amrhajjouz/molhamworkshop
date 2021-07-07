<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App;
use Validator;

class ProfileController extends Controller {
    
    public function __construct () {
        $this->middleware('auth');
    }
    
    public function update_info (Request $request) {

        try {
            
            $messages = [
                'name.required' => 'الاسم حقل مطلوب',
                'name.string' => 'يجب أن يكون الاسم حقل نصي مؤلف من حروف وأرقام',
                'name.between' => 'طول اسم المدينة يجب ان يكون بين 3-20 حرف ',
                'email.required' => 'البريد الالكتروني الجديد مطلوب',
                'email.email' => 'البريد الالكتروني الذي أدخلته غير صالح',
                'email.unique' => 'البريد الالكتروني الذي أدخلته مستخدم من قبل حساب آخر',
            ];

            $rules = [
                'name' => 'required|string|between:3,20',
                'email' => ['required', 'email', Rule::unique('users')->ignore(Auth::id())],
            ];

            $validator = Validator::make ($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
            }

            $user = Auth::user();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();

            return response()->json([]);
            
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    public function change_password (Request $request) {
        
        $messages = [
            'new.required' => 'كلمة المرور حقل مطلوب',
            'new.between' => 'طول كلمة المرور يجب ان يكون بين 6-20 حرف',
            'new.unique' => 'كلمة المرور لا تتطابق مع تأكيدها',
        ];
        
        $rules = [
            'new' => 'required|between:6,20|confirmed',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
        }
        
        $user = Auth::user();
        $user->password = bcrypt($request->input('new'));
        $user->save();
        
        return response()->json([]);
    }



    public function listNotifications(Request $request)
    {
        try {
            $user = auth()->user();
            $notifications = $user->notifications()
                ->where(function ($q) use ($request) {
                    if ($request->has('q')) {
                        $q->where('name', 'like', '%' . $request->q . '%');
                    }
                })->paginate(5)->withQueryString();

            $notifications->markAsRead();
            return response()->json($notifications);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
}
