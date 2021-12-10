<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamOffice extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['translate_words'];

    public function user(){
        return $this->belongsTo(User::class, 'office_manager');
    }

    public function place(){
        return $this->belongsTo(Place::class, 'place_id');
    }

    //translate words
    public function getTranslateWordsAttribute(){

        $translate_words = [];

        if ($this->type == 'head_office'){
            $translate_words[] = 'مكتب رئيسي';
        }
        if ($this->type == 'branch_office'){
            $translate_words[] = 'مكتب فرعي';
        }
        return $translate_words;
    }
}
