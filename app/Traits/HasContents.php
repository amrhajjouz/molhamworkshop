<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

trait HasContents
{

    public function contents()
    {
        return $this->morphMany(\App\Models\Content::class, 'contentable')->orderBy('id', 'desc');
    }


    public function updateContentFields($contentsData)
    {
        foreach ($this->contentFields as $field) {
            if (isset($contentsData[$field])) {
                $fieldNewValue = $this->$field;
                $availableLocales = $this->available_locales;
                foreach ($contentsData[$field] as $locale => $value) {
                    $availableLocales[$locale] = true;
                    $fieldNewValue[$locale] = $value;
                    $this->contents()->firstOrCreate(['name' => $field, 'value' => $value['value'], 'locale' => $locale, 'proofread' => $value['proofread'], 'auto_generated' => $value['auto_generated']]);
                }
                $this->$field = $fieldNewValue;
                if(Schema::hasColumn($this->getTable(), "available_locales")){
                    $this->available_locales = $availableLocales;
                }
            }
        }
        return $this->save();
    }
    
}
