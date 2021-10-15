<?php

namespace App\Models;

use App\Traits\HasContents;

class SocialMediaPost extends BaseModel
{
    use HasContents;
    protected $contentFields = ['body'];
    protected $appends = ['proofreadable'];
    protected $table = "social_media_posts";
    protected $guarded = [];
    protected $casts = [
        'ready_to_publish' => 'boolean',
        'body' => 'json',
        'published_at' =>  'datetime:Y-m-d H:i:s',
        'created_at' =>  'datetime:Y-m-d H:i:s',
        'updated_at' =>  'datetime:Y-m-d H:i:s',
        'approved_at' =>  'datetime:Y-m-d H:i:s',
        'rejected_at' =>  'datetime:Y-m-d H:i:s',
    ];

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

    public function save(array $options = [])
    {
        $newRecord = !$this->exists;
        $socialMediaPost = parent::save();
        if ($newRecord) {
            foreach ($this->contentFields as $field) {
                $this->contents()->create(['name' => $field, 'locale' => 'ar', 'value' => $this->body['ar']['value'], 'auto_generated' => false, 'proofread' => false]);
            }
        }
        return $socialMediaPost;
    }

    public function markAsProofread($targetLocale)
    {
        $contentsFields = $this->contentFields;
        foreach ($contentsFields as $field) {
            $fieldNewValue = $this->$field;
            foreach ($this->$field as $locale => $value) {
                if (isset($this->$field[$targetLocale])) {
                    $fieldNewValue[$targetLocale]['proofread'] = true;
                }
            }
            $this->$field = $fieldNewValue;
        }
        $this->save();
        foreach ($contentsFields as $field) {
            $this->contents()->where('name', $field)->where('locale', $targetLocale)->orderBy('id', 'desc')->firstOrFail()->update(['proofread' => true]);
        }
        return true;
    }
}
