<?php

namespace App\Common\Base;

use App\Common\Base\BaseModel as Model;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\{Place, Target};
use App\Facades\Helper;

/* 
 * this Class is base class and any model extends this will records in targets table 
*/
class BaseTargetModel extends Model
{

    protected $model_path;
    protected $has_places;


    /* 
     * return table name in database 
    */
    // public static function Table()
    // {
    //     return with(new static)->getTable();
    // }

    public function places()
    {
        return $this->morphToMany('App\Models\Place', 'placeable');
    }
   
    public function admins()
    {
        return $this->morphToMany('App\Models\User', 'adminable' , 'admins', null , 'user_id');
    }

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

            //model_path property comes from child

            if (isset($this->model_path)) {
                $target->purpose_type = $this->model_path;
            } else {
                $target->purpose_type = self::Table();
            }

            $target->reference = $reference;




            $target->fill($options['target']); 

            //do anything on create new record
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

            /* 
             * has_places comes from child class  
             *  check if has places then assign any place_id comes in options
            */

            if($this->has_places && isset($options['places_ids'])){
                    $this->places()->attach($options['places_ids']);
            }


           /* 
            * save admins_ids array if current model has admins as supervisors 
            *  
           */

            if($this->has_admins && isset($options['admins_ids'])){
                    $this->admins()->attach($options['admins_ids']);
            }

            $this->target_id = $target->id;
            return parent::save();

        } else {
            
            /////////////////////// update /////////////////////////
            
            $target = $this->parent;
           
            if(isset($options['target'])){

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
            }

            //assign any place_id comes in options and remove old records
            if (isset($options['places_ids'])) {
                if ($this->has_places && isset($options['places_ids'])) {
                        $this->places()->sync($options['places_ids']);
                }
            }
          
          /* 
           * check if there is modifications on admins for this model
           *  
           *  
          */
            if (isset($options['admins_ids'])) {
                if ($this->admins && isset($options['admins_ids'])) {
                    // foreach($options['admins_ids'] as $key => $val){
                        $this->admins()->sync($options['admins_ids']);
                    // }
                }
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
        //TODO: add new catgory and assign student
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
