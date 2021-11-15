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
                'first_name.ar.required' => 'الأسم باللغة العربية حقل مطلوب',
                'first_name.en.required' => 'الأسم باللغة الإنكليزية حقل مطلوب',
                'last_name.ar.required' => 'اللقب باللغة العربية حقل مطلوب',
                'last_name.en.required' => 'اللقب باللغة الإنكليزية حقل مطلوب',
                'mother_name.ar.required' => 'اسم الأم باللغة العربية حقل مطلوب',
                'mother_name.en.required' => 'اسم الأم باللغة الإنكليزية حقل مطلوب',
                'father_name.ar.required' => 'اسم الأب باللغة العربية حقل مطلوب',
                'father_name.en.required' => 'اسم الأب باللغة الإنكليزية حقل مطلوب',
                /*'name.string' => 'يجب أن يكون الاسم حقل نصي مؤلف من حروف وأرقام',
                'name.between' => 'طول اسم المدينة يجب ان يكون بين 3-20 حرف ',*/
                //'email.required' => 'البريد الالكتروني الجديد مطلوب',
                //'email.email' => 'البريد الالكتروني الذي أدخلته غير صالح',
                //'email.unique' => 'البريد الالكتروني الذي أدخلته مستخدم من قبل حساب آخر',
                'gender.required' => 'الجنس حقل مطلوب',
                'birth_date.required' => 'تاريخ الميلاد حقل مطلوب',
                'nationality_code.required' => 'كود الجنسية حقل مطلوب',
            ];

            $rules = [
                'first_name.ar' => 'required|string|between:3,20',
                'first_name.en' => 'required|string|between:3,20',
                'last_name.ar' => 'required|string|between:3,20',
                'last_name.en' => 'required|string|between:3,20',
                'father_name.ar' => 'required|string|between:3,20',
                'father_name.en' => 'required|string|between:3,20',
                'mother_name.ar' => 'required|string|between:3,20',
                'mother_name.en' => 'required|string|between:3,20',
                //'email' => ['required', 'email', Rule::unique('users')->ignore(Auth::id())],
                'gender' => 'required',
                'birth_date' => 'required|date',
                'nationality_code' => 'required',
                'locale' => ['string', Rule::in(['ar', 'en'])],
                //'bio' => 'nullable|string',
            ];

            $validator = Validator::make ($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
            }

            $user = Auth::user();
            $user->first_name = ['ar' => $request->input('first_name.ar'),'en' => $request->input('first_name.en')];
            $user->last_name = ['ar' => $request->input('last_name.ar'),'en' => $request->input('last_name.en')];
            $user->father_name = ['ar' => $request->input('father_name.ar'),'en' => $request->input('father_name.en')];
            $user->mother_name = ['ar' => $request->input('mother_name.ar'),'en' => $request->input('mother_name.en')];
            //$user->email = $request->input('email');
            $user->gender = $request->input('gender');
            $user->birth_date = $request->input('birth_date');
            $user->nationality_code = $request->input('nationality_code');
            $user->locale = $request->input('locale');
            //$user->bio = (empty($request->input('bio'))) ? null : html_entity_decode($request->input('bio'));

            $user->save();

            return response()->json([]);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function residence_data (Request $request) {

        try {

            $messages = [
                'place_of_birth.required' => 'مكان الولادة حقل مطلوب',
                'document_type.required' => 'نوع الوثيقة حقل مطلوب',
                'document_number.required' => 'رقم الوثيقة حقل مطلوب',
                'document_number.numeric' => 'رقم الوثيقة يجب ان يكون رقم',
                'document_expiration_date.required' => 'تاريخ الصلاحية حقل مطلوب',
                'current_residence.required' => 'بلد الإقامة الحالي حقل مطلوب',
            ];

            $rules = [
                'place_of_birth' => 'required|string',
                'document_type' => 'required|string',
                'document_number' => 'required|numeric',
                'document_expiration_date' => 'required|date',
                'current_residence' => 'required|string',
            ];

            //dd($request->all());
            $validator = Validator::make ($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
            }

            $user = Auth::user();
            $user->place_of_birth = $request->input('place_of_birth');
            $user->document_type = $request->input('document_type');
            $user->document_number = $request->input('document_number');
            $user->document_expiration_date = $request->input('document_expiration_date');
            $user->current_residence = $request->input('current_residence');
            $user->save();

            return response()->json([]);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function contact_data (Request $request) {


        try {

            $messages = [
                'phone.required' => 'رقم الهاتف حقل مطلوب',
                'phone.numeric' => 'رقم الهاتف يجب أن يكون رقم',
                'whatsapp.required' => 'رقم الوتس أب حقل مطلوب',
                'whatsapp.numeric' => 'رقم الوتس أب يجب أن يكون رقم',
                'reference_person_name.required' => 'اسم شخص مقرب حقل مطلوب',
                'reference_person_phone.required' => 'رقم هاتف الشخص حقل مطلوب',
                'reference_person_phone.numeric' => 'حقل رقم هاتف الشخص يجب أن يكون رقم',
                'reference_person_relation_type.required' => 'صلة القرابة حقل مطلوب',
                'facebook.required' => 'رابط صفحتك على فيسبوك حقل مطلوب',
                'instagram.required' => 'رابط حسابك على الإنستغرام حقل مطلوب',
            ];

            $rules = [
                'phone' => 'required|numeric',
                'whatsapp' => 'required|numeric',
                'reference_person_name' => 'required|string',
                'reference_person_phone' => 'required|numeric',
                'reference_person_relation_type' => 'required|string',
                'facebook' => 'required|string',
                'instagram' => 'required|string',
            ];

            //dd($request->all());
            $validator = Validator::make ($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
            }

            $user = Auth::user();
            $user->phone = $request->input('phone');
            $user->whatsapp = $request->input('whatsapp');
            $user->reference_person_name = $request->input('reference_person_name');
            $user->reference_person_phone = $request->input('reference_person_phone');
            $user->reference_person_relation_type = $request->input('reference_person_relation_type');
            $user->facebook = $request->input('facebook');
            $user->instagram = $request->input('instagram');
            $user->save();

            return response()->json([]);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function employment_data (Request $request) {


        /*try {

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
        }*/
    }

    public function experiences_and_skills (Request $request) {

        try {

            $messages = [
                'previous_work.required' => 'العمل السابق حقل مطلوب',
            ];

            $rules = [
                'previous_work' => 'required',
            ];

            $validator = Validator::make ($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
            }

            $user = Auth::user();
            $user->previous_work = $request->input('previous_work');
            $user->employer = $request->input('employer');
            $user->country_worked_in = $request->input('country_worked_in');
            $user->job_title_worked_in = $request->input('job_title_worked_in');
            $user->start_date_worked_in = $request->input('start_date_worked_in');
            $user->end_date_worked_in = $request->input('end_date_worked_in');
            $user->save();

            return response()->json([]);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function additional_data (Request $request) {

        try {

            $messages = [
                'blood_type.required' => 'زمرة الدم حقل مطلوب',
                'physical_disability.required' => 'الاعاقة الجسدية حقل مطلوب',
                'communicable_diseases.required' => 'الامراض السارية حقل مطلوب',
            ];

            $rules = [
                'blood_type' => 'required',
                'physical_disability' => 'required',
                'communicable_diseases' => 'required',
            ];

            $validator = Validator::make ($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
            }

            $user = Auth::user();
            $user->blood_type = $request->input('blood_type');
            $user->physical_disability = $request->input('physical_disability');
            $user->communicable_diseases = $request->input('communicable_diseases');
            $user->physical_disability_description = $request->input('physical_disability_description');
            $user->communicable_diseases_description = $request->input('communicable_diseases_description');
            $user->save();

            return response()->json([]);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function education (Request $request) {

        try {

            $messages = [
                'education_level.required' => 'المستوى التعليمي حقل مطلوب',
                'education_section.required' => 'الفرع حقل مطلوب',
                'educational_facility.required' => 'المنشأة التعليمية حقل مطلوب',
                'educational_country.required' => 'البلد حقل مطلوب',
                'educational_language.required' => 'لغة الدراسة حقل مطلوب',
                'educational_status.required' => 'الحالة الدراسية حقل مطلوب',
                'graduation_year.required' => 'سنة التخرج حقل مطلوب',
                'average.required' => 'المعدل حقل مطلوب',
                'native_language.required' => 'اللغة الام حقل مطلوب',
                'other_languages.required' => 'لغات اخرى حقل مطلوب',

            ];

            $rules = [
                'education_level' => 'required',
                'education_section' => 'required',
                'educational_facility' => 'required',
                'educational_country' => 'required',
                'educational_language' => 'required',
                'educational_status' => 'required',
                'graduation_year' => 'required',
                'average' => 'required',
                'native_language' => 'required',
                'other_languages' => 'required',
            ];

            $validator = Validator::make ($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
            }

            $user = Auth::user();
            $user->education_level = $request->input('education_level');
            $user->education_section = $request->input('education_section');
            $user->educational_facility = $request->input('educational_facility');
            $user->educational_country = $request->input('educational_country');
            $user->educational_language = $request->input('educational_language');
            $user->educational_status = $request->input('educational_status');
            $user->graduation_year = $request->input('graduation_year');
            $user->average = $request->input('average');
            $user->native_language = $request->input('native_language');
            $user->other_languages = $request->input('other_languages');
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
}
