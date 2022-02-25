<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UserContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\UserResidence;
use App\Http\Requests\UserResidence\{CreateUserResidenceRequest, UpdateUserResidenceRequest,ListUserResidenceRequest,DeleteUserResidenceRequest,RetrieveUserResidenceRequest};

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
                'father_name.ar.between' => 'طول اسم الأب يجب ان يكون بين 3-20 حرف',
                'father_name.en.required' => 'اسم الأب باللغة الإنكليزية حقل مطلوب',
                /*'name.string' => 'يجب أن يكون الاسم حقل نصي مؤلف من حروف وأرقام',
                'name.between' => 'طول اسم المدينة يجب ان يكون بين 3-20 حرف ',*/
                //'email.required' => 'البريد الالكتروني الجديد مطلوب',
                //'email.email' => 'البريد الالكتروني الذي أدخلته غير صالح',
                //'email.unique' => 'البريد الالكتروني الذي أدخلته مستخدم من قبل حساب آخر',
                'gender.required' => 'الجنس حقل مطلوب',
                'birth_date.required' => 'تاريخ الميلاد حقل مطلوب',
                'country_code.required' => 'كود الجنسية حقل مطلوب',
                'marital_status.required' => 'الحالة الإجتماعية حقل مطلوب',
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
                'gender' => 'required',
                'birth_date' => 'required|date',
                'country_code' => 'required',
                'marital_status' => 'required',
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
            $user->country_code = $request->input('country_code');
            $user->locale = $request->input('locale');
            $user->marital_status = $request->input('marital_status');
            //$user->bio = (empty($request->input('bio'))) ? null : html_entity_decode($request->input('bio'));

            $user->save();

            return response()->json([]);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function my_info (Request $request) {

                    try {

                              $messages = [
                                        'first_name.ar.required' => 'الأسم باللغة العربية حقل مطلوب',
                                        'first_name.en.required' => 'الأسم باللغة الإنكليزية حقل مطلوب',
                                        'last_name.ar.required' => 'اللقب باللغة العربية حقل مطلوب',
                                        'last_name.en.required' => 'اللقب باللغة الإنكليزية حقل مطلوب',
                                        'mother_name.ar.required' => 'اسم الأم باللغة العربية حقل مطلوب',
                                        'mother_name.en.required' => 'اسم الأم باللغة الإنكليزية حقل مطلوب',
                                        'father_name.ar.required' => 'اسم الأب باللغة العربية حقل مطلوب',
                                        'father_name.ar.between' => 'طول اسم الأب يجب ان يكون بين 3-20 حرف',
                                        'father_name.en.required' => 'اسم الأب باللغة الإنكليزية حقل مطلوب',
                                        'gender.required' => 'الجنس حقل مطلوب',
                                        'birth_date.required' => 'تاريخ الميلاد حقل مطلوب',
                                        'country_code.required' => 'كود الجنسية حقل مطلوب',
                                        'marital_status.required' => 'الحالة الإجتماعية حقل مطلوب',

                                        'current_country_code.required' => 'الدولة حقل مطلوب',
                                        'current_city_id.required' => 'المدينة حقل مطلوب',
                                        'current_full_address.required' => 'العنوان التفصيلي حقل مطلوب',
                                        'current_residence_file.required' => 'وثيقة العنوان حقل مطلوب',

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

                                        'education_level.required' => 'المستوى التعليمي حقل مطلوب',
                                        'education_section.required' => 'الفرع حقل مطلوب',
                                        'institution_name.required' => 'المنشأة التعليمية حقل مطلوب',
                                        'education_country.required' => 'البلد حقل مطلوب',
                                        'study_language.required' => 'لغة الدراسة حقل مطلوب',
                                        'education_status.required' => 'الحالة الدراسية حقل مطلوب',
                                        'graduated_year.required' => 'سنة التخرج حقل مطلوب',
                                        'gpa.required' => 'المعدل التراكمي حقل مطلوب',
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
                                        'gender' => 'required',
                                        'birth_date' => 'required|date',
                                        'country_code' => 'required',
                                        'marital_status' => 'required',
                                        'locale' => ['string', Rule::in(['ar', 'en'])],

                                        'current_country_code' => 'required|string',
                                        'current_city_id' => 'required|string',
                                        'current_full_address' => 'required|string',
                                        'current_residence_file' => 'required|string',

                                        'phone' => 'required|numeric',
                                        'whatsapp' => 'required|numeric',
                                        'reference_person_name' => 'required|string',
                                        'reference_person_phone' => 'required|numeric',
                                        'reference_person_relation_type' => 'required|string',
                                        'facebook' => 'required|string',
                                        'instagram' => 'required|string',

                                        'education_level' => 'required',
                                        'education_section' => 'required',
                                        'institution_name' => 'required',
                                        'education_country' => 'required',
                                        'study_language' => 'required',
                                        'education_status' => 'required',
                                        'graduated_year' => 'required',
                                        'gpa' => 'required',
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
                              $user->country_code = $request->input('country_code');
                              $user->locale = $request->input('locale');
                              $user->marital_status = $request->input('marital_status');

                              $user->current_country_code = $request->input('current_country_code');
                              $user->current_city_id = $request->input('current_city_id');
                              $user->current_full_address = $request->input('current_full_address');
                              $user->current_residence_file = $request->input('current_residence_file');

                              $user->phone = $request->input('phone');
                              $user->whatsapp = $request->input('whatsapp');
                              $user->reference_person_name = $request->input('reference_person_name');
                              $user->reference_person_phone = $request->input('reference_person_phone');
                              $user->reference_person_relation_type = $request->input('reference_person_relation_type');
                              $user->facebook = $request->input('facebook');
                              $user->instagram = $request->input('instagram');

                              $user->education_level = $request->input('education_level');
                              $user->education_section = $request->input('education_section');
                              $user->institution_name = $request->input('institution_name');
                              $user->education_country = $request->input('education_country');
                              $user->study_language = $request->input('study_language');
                              $user->education_status = $request->input('education_status');
                              $user->graduated_year = $request->input('graduated_year');
                              $user->gpa = $request->input('gpa');

                              //dd($user);

                              $user->save();

                              return response()->json([]);

                    } catch (\Exception $e) {
                              return ['error' => $e->getMessage()];
                    }
          }

    public function residence_data (Request $request) {

        try {

            $messages = [
                'current_country_code.required' => 'الدولة حقل مطلوب',
                'current_city_id.required' => 'المدينة حقل مطلوب',
                'current_full_address.required' => 'العنوان التفصيلي حقل مطلوب',
                'current_residence_file.required' => 'وثيقة العنوان حقل مطلوب',
            ];

            $rules = [
                'current_country_code' => 'required|string',
                'current_city_id' => 'required|string',
                'current_full_address' => 'required|string',
                'current_residence_file' => 'required|string',
            ];

            //dd($request->all());
            $validator = Validator::make ($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
            }

            $user = Auth::user();
            $user->current_country_code = $request->input('current_country_code');
            $user->current_city_id = $request->input('current_city_id');
            $user->current_full_address = $request->input('current_full_address');
            $user->current_residence_file = $request->input('current_residence_file');

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
            ];

            $rules = [
                'blood_type' => 'required',
            ];

            $validator = Validator::make ($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
            }

            $user = Auth::user();
            $user->blood_type = $request->input('blood_type');
            $user->physical_disability = $request->input('physical_disability');
            $user->communicable_diseases = $request->input('communicable_diseases');
            $user->chronic_diseases = $request->input('chronic_diseases');
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
                'institution_name.required' => 'المنشأة التعليمية حقل مطلوب',
                'education_country.required' => 'البلد حقل مطلوب',
                'study_language.required' => 'لغة الدراسة حقل مطلوب',
                'education_status.required' => 'الحالة الدراسية حقل مطلوب',
                'graduated_year.required' => 'سنة التخرج حقل مطلوب',
                'gpa.required' => 'المعدل التراكمي حقل مطلوب',

            ];

            $rules = [
                'education_level' => 'required',
                'education_section' => 'required',
                'institution_name' => 'required',
                'education_country' => 'required',
                'study_language' => 'required',
                'education_status' => 'required',
                'graduated_year' => 'required',
                'gpa' => 'required',

            ];

            $validator = Validator::make ($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'errors' => $validator->errors()]);
            }

            $user = Auth::user();
            $user->education_level = $request->input('education_level');
            $user->education_section = $request->input('education_section');
            $user->institution_name = $request->input('institution_name');
            $user->education_country = $request->input('education_country');
            $user->study_language = $request->input('study_language');
            $user->education_status = $request->input('education_status');
            $user->graduated_year = $request->input('graduated_year');
            $user->gpa = $request->input('gpa');
            $user->save();

            return response()->json([]);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function contracts () {

        try {
            $userContracts = UserContract::with('user')->where('user_id', auth()->id())->orderBy('id', 'desc')->paginate(5);

            //dd($userContracts);
            return response()->json($userContracts);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
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
