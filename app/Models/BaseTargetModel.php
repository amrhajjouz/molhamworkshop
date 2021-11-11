<?php

namespace App\Models;

use Exception;

/* 
 * this Class is base class and any model extends this will records in targets table 
*/

class BaseTargetModel extends BaseModel
{
    public function target()
    {
        return $this->morphOne('App\Models\Target', 'targetable');
    }

    public function save(array $options = [])
    {
        $requiredOptions = ['target'];
        foreach ($requiredOptions as $op) {
            if (!isset($options[$op])) throw new Exception('missed data ' . $op);
        }

        $newRecord = !$this->exists;
        $response = parent::save();

        if ($newRecord) {
            //  $options['target'] : required field in all purposeable models must pass it in options
            $target = $this->target()->create($options['target']);
            $this->target_id = $target->id;
        } else {
            $this->target()->update($options['target']);
        }

        return parent::save();
    }


    /////////////////////////// Target Actions //////////////////////////

    public function markAsPosted()
    {
        return $this->target->update(['published_at' => date('Y-m-d H:i:s', time())]);
    }
  
    public function markAsDocumented()
    {
        return $this->target->update(['documented' => true]);
    }

    public function markAsUndocumented()
    {
        return $this->target->update(['documented' => false]);
    }

    public function markAsArchived()
    {
        return $this->target->update(['archived' => true]);
    }

    public function markAsUnarchived()
    {
        return $this->target->update(['archived' => false]);
    }

    public function markAsHidden()
    {
        return $this->target->update(['is_hidden' => true]);
    }

    public function markAsVisible()
    {
        return $this->target->update(['is_hidden' => false]);
    }
  
    public function markAsReadyToPublish()
    {
        return $this->target->update(['ready_to_publish' => true]);
    }
   
    public function markAsProofread($targetLocale)
    {
        $contentsFields = ['title' , 'description' , 'details'];
        $target = $this->target;
        foreach ($contentsFields as $field) {
            $fieldNewValue = $target->$field;
            foreach ($target->$field as $locale => $value) {
                if(isset($target->$field[$targetLocale])){
                    $fieldNewValue[$targetLocale]['proofread'] = true;
                }
            }
            $target->$field = $fieldNewValue;
        }
        $target->save();
        foreach ($contentsFields as $field) {
            $target->contents()->where('name' ,$field)->where('locale' , $targetLocale)->orderBy('id' , 'desc')->first()->update(['proofread' => true]);
        }   
        return true;
    }
}
