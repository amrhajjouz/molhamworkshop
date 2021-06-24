<?php

namespace App\Models;
use Spatie\Permission\Models\Permission as SpatieRPermissionModel;

class Permission extends SpatieRPermissionModel
{


    public function save($options = []) {
        $is_new = !$this->exists;
        $ret = parent::save($options);

        if($is_new){
            $super_admin = Role::find(config('app.super_admin_role_id'));
            $super_admin->givePermissionTo($this->name);
        }


        return $ret;
    }
    
}

