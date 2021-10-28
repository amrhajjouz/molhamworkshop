<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Office\{CreateOfficeRequest, UpdateOfficeRequest};
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Models\Office;

class OfficeController extends Controller {

          public function __construct () {
                    $this->middleware('auth');
          }

          public function create (CreateOfficeRequest $request) {

                    try {

                              // Create Branch
                              $office = Office::create($request->validated());

                              return response()->json($office);

                    } catch (\Exception $e) {
                              return ['error' => $e->getMessage()];
                    }
          }

          public function update (UpdateOfficeRequest $request) {

                    try {

                              // Fetch Branch
                              $office = Office::findOrFail($request->id);

                              // Update Branch
                              $office->update($request->validated());

                              return response()->json($office);

                    } catch (\Exception $e) {
                              return ['error' => $e->getMessage()];
                    }
          }

          public function retrieve ($id) {

                    try {

                              // Fetch Branch and Return
                              $data = Office::findOrFail($id);
                              $json = response()->json($data);
                              $qrData = [
                                        'lat' => $data['lat'],
                                        'lng' => $data['lng'],
                              ];
                              $qrData = json_encode($qrData);
                              $qr = QrCode::format('png')->size(100)->generate($qrData);
                              $data['qr'] = base64_encode($qr);
                              return response()->json($data);

                    } catch (\Exception $e) {
                              return ['error' => $e->getMessage()];
                    }
          }

          public function list (Request $request) {

                    try {

                              $search_query = ($request->has('q') ? [['name', 'like', '%' . $request->q . '%']] : null);

                              $offices = Office::orderBy('id', 'desc')->where($search_query)->paginate(5)->withQueryString();

                              return response()->json($offices);

                    } catch (\Exception $e) {
                              return ['error' => $e->getMessage()];
                    }
          }

}
