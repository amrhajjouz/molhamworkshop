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
        return $this->target->update(['posted_at' => date('Y-m-d H:i:s', time())]);
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
}
