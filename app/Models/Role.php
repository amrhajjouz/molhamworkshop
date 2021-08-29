<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRoleModel;

class Role extends SpatieRoleModel
{
    protected $casts = ['title' => 'json', 'has_multiple_assignees' => 'boolean'];


    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    
    public function transform()
    {
        $role = $this->toArray();
        $locale = app()->getLocale();
        return array_merge($role , [
            'section' => ['name' => $this->section ? $this->section->name[$locale] : null ] , 
        ]);
    }
}
