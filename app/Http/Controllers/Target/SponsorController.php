<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Http\Requests\Target\Sponsor\{CreateRequest, UpdateRequest};
use App\Models\{Sponsor, Donor};
use Illuminate\Support\Facades\Log;


class SponsorController extends BaseController
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->model = \App\Models\Sponsor::class;
    }

    public function create(CreateRequest $request)
    {

        try {
            $data = $request->validated();

            $purpose = $data['purpose_type']::find($data['purpose_id']); // Student Or Sponsorship 

            $donor = Donor::findOrfail($data['donor_id']);

            $target = $purpose->parent;

            $percentage = $data['percentage'];

            $model_type = null;


            // determin purpose instance of which model
            if ($purpose instanceof \App\Models\Sponsorship) {
                $model_type = 'sponsorship';
            } else if ($purpose instanceof \App\Models\Student) {
                $model_type = 'student';
            } else {
                Log::info('Helper AssignToSponsor assign wront object');
                throw $this->_exception('invalid Model type');
            }


            //check if this sponsor already sponsored this purpose
            $sponsor = Sponsor::where('purpose_type', $model_type)
                ->where('purpose_id', $purpose->id)
                ->where('donor_id', $donor->id)
                ->first();

            if (!is_null($sponsor)) {
                throw $this->_exception('already sponsored');
            }

            $config_amount = config('general.least_sponsore_amount'); // this value configure in config to compare sponsor percentage with it

            // at least must pay 10$
            $required = $target->required;

            //calculate value that sponsor pay it percently
            $real_amount = ($required * $request->percentage) / 100;


            if ($real_amount < $config_amount  && $purpose->percentage_to_complete() != $percentage) {
                throw $this->_exception('at least must pay 10 dolar');
            }

            $sponsor = new Sponsor();
            $sponsor->purpose_type = $model_type;
            $sponsor->purpose_id = $purpose->id;
            $sponsor->percentage = $percentage;
            $sponsor->active = true;
            $sponsor->donor_id = $donor->id;
            $sponsor->save();

            if ($model_type == 'sponsorship') {
                if ($purpose->sponsors->sum('percentage') >= 100) {
                    $purpose->sponsored = true;
                    $purpose->save();
                }
            }

            return $this->_response($sponsor->transform());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());;
        }
    }

    public function update(UpdateRequest $request)
    {
        try {

            $object = $this->model::findOrFail($request->id);

            $data = $request->validated();

            $purpose = $object->purpose;

            //id in array mean calculate sum percentage for this purpose without sponsor has this id 
            $current_total_without_this_sponsor = $purpose->total_sponsores_percentage([$object->id]);

            if ((100 - $current_total_without_this_sponsor) < $data['percentage']) {
                throw $this->_exception('big percentage');
            }

            $target = $purpose->parent;
            $required = $target->required;
            $real_amount = ($required * $request->percentage) / 100;
            $config_amount = config('general.least_sponsore_amount');
            $percentage = $request->percentage;

            if (
                $real_amount < $config_amount  && $purpose->percentage_to_complete() != $percentage
            ) {
                throw $this->_exception('at least must pay 10 dolar');
            }

            $object->percentage = $data['percentage'];
            $object->save();


            if ($purpose instanceof \App\Models\Sponsorship) {
                $this->afterUpdateSponsership($purpose, $current_total_without_this_sponsor, $data);
            } else if ($purpose instanceof \App\Models\Student) {
                $this->afterUpdateStudent($purpose, $current_total_without_this_sponsor, $data);
            } else {
                throw $this->_exception('missing data');
            }

            return $this->_response($object->transform());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }


    // check if sponsored 
    protected function afterUpdateSponsership($purpose, $current_total_without_this_sponsor, $data)
    {

        if (($current_total_without_this_sponsor + $data['percentage']) >= 100) {
            $purpose->sponsored = true;
        } else {
            $purpose->sponsored = false;
        }

        $purpose->save();
    }


    // TODO if there any action on update student sponsor 
    protected function afterUpdateStudent($purpose, $current_total_without_this_sponsor, $data)
    {

        // if (($current_total_without_this_sponsor + $data['percentage']) >= 100) {
        //     $purpose->status = 'fully_funded';
        // } else {
        //     $purpose->status = 'not_funded';
        // }

        // $purpose->save();
    }
}
