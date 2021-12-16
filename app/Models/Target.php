<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Program;
use App\Traits\HasContents;

class Target extends BaseModel
{
    use HasContents;
    protected $contentFields = ['details', 'description', 'title'];
    protected $appends = ['proofreadable'];
    protected $table = "programs_targets";
    protected $guarded = [];
    protected $casts = [
        'documented' => 'boolean',
        'is_hidden' => 'boolean',
        'archived' => 'boolean',
        'ready_to_publish' => 'boolean',
        'created_at' =>  'datetime:Y-m-d H:i:s',
        'updated_at' =>  'datetime:Y-m-d H:i:s',
        'published_at' =>  'datetime:Y-m-d H:i:s',
        'canceled_at' =>  'datetime:Y-m-d H:i:s',
        'title' => 'json',
        "description" => "json",
        'details' => 'json',
        'available_locales' => 'json',
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
   
    public function purpose()
    {
        return $this->belongsTo(Purpose::class, 'purpose_id', 'id');
    }

    public function save(array $options = [])
    {
        $isNewTarget = !($this->exists);
        if ($isNewTarget) {
            do {
                $this->reference = Str::random(15);
            } while (self::where('reference', $this->reference)->exists());
            $this->code = $this->getApproriateCode();
            $this->available_locales = ['ar' => false, 'en' => false, 'de' => false, 'tr' => false, 'fr' => false, 'es' => false,];
        } else {
            $this->purpose->update(['title'=>$this->attributes['title']]);
        }
        $target = parent::save($options);
        return $target;
    }

    private function getApproriateCode()
    {
        switch ($this->targetable_type) {
            case "case":
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



    public function getProofreadableAttribute()
    {
        $proofreadable = [];
        foreach (getAvailableLocales() as $locale => $arName) {
            $proofreaded = true;
            foreach ($this->contentFields as $field) {
                if (!isset($this->$field[$locale]) || !$this->$field[$locale]['value']) {
                    $proofreaded = false;
                }
            }
            $proofreadable[$locale] = $proofreaded;
        }
        return $proofreadable;
    }
}
