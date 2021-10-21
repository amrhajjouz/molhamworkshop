<?php

namespace App\Http\Controllers\Dashboard;

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
                'locale' => ['string', Rule::in(['ar', 'en'])],
                'bio' => 'nullable|string',
            ];

            $validator = Validator::make ($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
            }

            $user = Auth::user();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->locale = $request->input('locale');
            $user->bio = (empty($request->input('bio'))) ? null : html_entity_decode($request->input('bio'));
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

    public function job_data (Request $request) {


        try {

            $messages = [
                'job_number.required' => 'الرقم الوظيفي حقل مطلوب',
                'job_number.string' => 'يجب أن يكون الرقم الوظيفي حقل نصي مؤلف من أرقام',
                'job_title.required' => 'المسمى الوظيفي حقل مطلوب',
                'job_title.string' => 'يجب أن يكون المسمى الوظيفي حقل نصي مؤلف من حروف وأرقام',
            ];

            $rules = [
                'job_number' => 'required|string',
                'job_title' => 'required|string',
            ];

            //dd($request->all());
            $validator = Validator::make ($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
            }

            $user = Auth::user();
            $user->job_number = $request->input('job_number');
            $user->job_title = $request->input('job_title');
            $user->save();

            return response()->json([]);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function national_data (Request $request) {

        try {

            $messages = [
                'nationality.required' => 'الجنسية حقل مطلوب',
                'document_type.required' => 'نوع الوثيقة حقل مطلوب',
            ];

            $rules = [
                'nationality' => 'required',
                'document_type' => 'required',
            ];

            //dd($request->all());
            $validator = Validator::make ($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
            }

            $user = Auth::user();
            $user->nationality = $request->input('nationality');
            $user->document_type = $request->input('document_type');
            $user->save();

            return response()->json([]);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function housing_data (Request $request) {

        try {

            $messages = [
                'country.required' => 'الدولة حقل مطلوب',
                'governorate.required' => 'المحافظة حقل مطلوب',
                'city.required' => 'المدينة حقل مطلوب',
                'detailed_address.required' => 'العنوان بالتفصيل حقل مطلوب',
            ];

            $rules = [
                'country' => 'required',
                'governorate' => 'required',
                'city' => 'required',
                'detailed_address' => 'required',
            ];

            $validator = Validator::make ($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
            }

            $user = Auth::user();
            $user->country = $request->input('country');
            $user->governorate = $request->input('governorate');
            $user->city = $request->input('city');
            $user->detailed_address = $request->input('detailed_address');
            $user->save();

            return response()->json([]);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function education_record (Request $request) {

        try {

            $messages = [
                'education_level.required' => 'المستوى التعليمي حقل مطلوب',
                'graduation_year.required' => 'سنة التخرج حقل مطلوب',
            ];

            $rules = [
                'education_level' => 'required',
                'graduation_year' => 'required',
            ];

            $validator = Validator::make ($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
            }

            $user = Auth::user();
            $user->education_level = $request->input('education_level');
            $user->graduation_year = $request->input('graduation_year');
            $user->save();

            return response()->json([]);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
