<?php


namespace App\Http\Traits;


use Wildside\Userstamps\Userstamps;

/**
 *  Make sure when we need to call that to use 'with' otherwise it will do call the database on each record
 */
trait HasUserstamps
{
    use Userstamps;

    public function getCreatedByNameAttribute()
    {
        if ($this->created_by == null) {
            return null;
        }

        return ["name" => $this->creator->name, "email" => $this->creator->email];
    }

    public function getUpdatedByNameAttribute()
    {
        if ($this->updated_by == null) {
            return null;
        }

        return $this->editor->name;
    }

    public function getDeletedByNameAttribute()
    {
        if ($this->deleted_by == null) {
            return null;
        }

        return $this->destroyer->name;
    }
}
