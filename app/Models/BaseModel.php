<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{

    protected $guarded = [];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function save(array $options = [])
    {
        $isNew = !$this->exists;
        if ($isNew) {
            if (Schema::hasColumn($this->getTable(), "created_by")) $this->created_by = auth()->id();
        }
        if (Schema::hasColumn($this->getTable(), "updated_by")) {
            $this->updated_by = auth()->id();
        }
        return parent::save($options);
    }
}
