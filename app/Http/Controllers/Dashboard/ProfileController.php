<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\TimesheetUsersChecks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

          public function timesheet(Request  $request){
                    try {

                              // Fetch Branch and Return
                              $id = Auth::id();
                              $userData = App\Models\User::findOrFail($id);
                              $data = Office::findOrFail($userData->office_id);
                              $checks = TimesheetUsersChecks::orderBy('created_at', 'desc')->where('user_id', $id)->paginate(5);;
                              return response()->json($checks);

                    } catch (\Exception $e) {
                              return ['error' => $e->getMessage()];
                    }
          }

          public function generateQrCode(Request $request){
                    $id = Auth::id();
                    $userData = App\Models\User::findOrFail($id);
                    $data = Office::findOrFail($userData->office_id);
                    $qrData = [
                              'lat' => $data['lat'],
                              'lng' => $data['lng'],
                    ];
                    $qrData = json_encode($qrData);
                    $qr = QrCode::format('png')->size(200)->generate($qrData);
                    $data['qr'] = base64_encode($qr);
                    return response()->json($data);
          }

}
