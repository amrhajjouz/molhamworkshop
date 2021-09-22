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

    public function makePosted()
    {
        return $this->target->update(['posted_at' => date('Y-m-d H:i:s', time())]);
    }

    public function makeDocumented()
    {
        return $this->target->update(['documented' => true]);
    }

    public function makeUndocumented()
    {
        return $this->target->update(['documented' => false]);
    }

    public function makeArchived()
    {
        return $this->target->update(['archived' => true]);
    }

    public function makeUnarchived()
    {
        return $this->target->update(['archived' => false]);
    }

    public function makeAsHidden()
    {
        return $this->target->update(['hidden' => true]);
    }

    public function makeAsUnhidden()
    {
        return $this->target->update(['hidden' => false]);
    }
}
