<?php

namespace App\Common\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\{Place, Target};
use App\Facades\Helper;
use App\Common\Traits\HasPlace;

class BaseTargetModel extends Model
{
    use HasPlace;

    protected $model_path;
    //bool
    protected $has_places;

    const targetAttributes = [
        'required',
        'received',
        'left',
        'left_to_complete',
        'spent',
        'beneficiaries_count',
        'archived',
        'documented',
        'visible',
        'posted',
    ];

    // abstract function target();

    public static function Table()
    {
        return with(new static)->getTable();
    }

    // public function transform(){

    //     if(isset($this->transformer)){
    //         $class = $this->transformer;
    //         return $class::transform($this);
    //     }

    //     return $this;
    // }

    // public function getModelTypeAttribute(){
    //     $rec = \App\Models\ModelLevel::where('name',self::Table())
    //             ->first();
    //     return $rec;
    // }



    public function save(array $options = [])
    {
        $newRecord = !($this->exists);
        parent::save($options);
        
        
        if ($newRecord) {
            // Create Target 
            $reference = Helper::generateRandomString(15);


            do {
                $reference = Helper::generateRandomString(15);
            } while (Target::where('reference', $reference)->exists());


            $target = new \App\Models\Target();
            $target->purpose_id = $this->id;

            if (isset($this->model_path)) {
                $target->purpose_type = $this->model_path;
            } else {
                $target->purpose_type = self::Table();
            }
            $target->reference = $reference;




            $target->fill($options['target']); //
            switch (get_class($this)) {
                case "App\Models\Cases":
                    $target = $this->beforeSaveCase($target);
                    break;
                case "App\Models\Sponsorship":
                    $target = $this->beforeSaveSponsorship($target);
                    break;
                case "App\Models\Student":
                    $target = $this->beforeSaveStudent($target);
                    break;
                case "App\Models\Event":
                    $target = $this->beforeSaveEvent($target);
                    break;

                default:
                    # code...
                    break;
            }

            $target->save();

            
            if ($this->has_places && isset($options['places'])) {
                $this->places()->attach($options['places']);
            }
            $this->target_id = $target->id;
            
            return parent::save();
        } else {

            /////////////////////// update /////////////////////////
            $target = $this->parent;

            $target->fill($options['target']); //
            switch (get_class($this)) {
                case "App\Models\Cases":
                    $target = $this->beforeSaveCase($target);
                    break;

                default:
                    # code...
                    break;
            }

            $target->save();


            if ($this->has_places && isset($options['places'])) {

                // /////////////////////// delete /////////////////////////
                // $places = $this->places;
                // foreach($places as $item){
                //     // $this->places()->detach([$item->id]);
                //     $this->places()->detach([$item->id]);
                // }
                
                foreach($options['places'] as $key => $val){
                    if(!is_array($val)) continue;
                    $attach = Place::find($val['id']);

                    // $prev = $this->places()->attach($attach);
                    $prev = $this->places()->sync($attach);
                    
                }
                //to delete 
                // dd($options['places']);
                // $to_delete = $this->places()->whereNotIn('place_id' , $options['places'])->get();
                // foreach($to_delete  as $item){
                    
                //     $this->places()->detach($item->id);
                // }
            }

        }
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Target', 'target_id', 'id');
    }



    public function delete(array $options = [])
    {

        $this->target->delete();

        return parent::delete();
    }

    //return Target
    private function beforeSaveCase(Target $target)
    {

        if (isset($target->category_id)) {
            if ($target->category_id == 4) {
                // طبية 
                $target->section_id = 1;
            } elseif ($target->category_id == 5) {
                $target->section_id = 2;
                //انسانية
            }
        }

        return $target;
    }

    private function beforeSaveSponsorship(Target $target)
    {

        if (isset($target->category_id)) {
            if ($target->category_id == 2) {
                // طبية 
                $target->section_id = 1;
            } elseif ($target->category_id == 3) {
                $target->section_id = 2;
                //الاسرة
            } elseif ($target->category_id == 1) {
                $target->section_id = 4;
                //كفالة يتيم
            }
        }
        return $target;
    }

    private function beforeSaveStudent(Target $target)
    {
        //التعليم
        $target->section_id = 5;
        $target->beneficiaries_count = 1;

        return $target;
    }

    private function beforeSaveEvent(Target $target)
    {
        //الحماية
        $target->section_id = 4;

        return $target;
    }
}
