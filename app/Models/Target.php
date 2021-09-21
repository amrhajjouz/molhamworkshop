<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Program;

class Target extends BaseModel
{
    protected $table = "programs_targets";
    protected $guarded = [];
    protected $casts = [
        'documented' => 'boolean',
        'hidden' => 'boolean',
        'archived' => 'boolean',
        'created_at' =>  'datetime:Y-m-d H:i:s',
        'updated_at' =>  'datetime:Y-m-d H:i:s',
        'posted_at' =>  'datetime:Y-m-d H:i:s',
        'canceled_at' =>  'datetime:Y-m-d H:i:s',
    ];

    public function targetable()
    {
        return $this->morphTo();
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function save(array $options = [])
    {
        if (!($this->exists)) {
            do {
                $this->reference = Str::random(15);
            } while (self::where('reference', $this->reference)->exists());

            $this->code = $this->getApproriateCode();
        }
        return parent::save($options);
    }

    private function getApproriateCode()
    {
        switch ($this->targetable_type) {
            case "cases":
                return "CAS" . $this->targetable_id;
                break;

            default:
                return null;
                break;
        }
        /*
    CAM1000
    SPO1000
    EVE1000
    CAM
    SPO
    EVE
    PRO
    FUN
    */
    }
}
