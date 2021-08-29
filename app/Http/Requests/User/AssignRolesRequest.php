<?php

namespace App\Http\Requests\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AssignRolesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  auth()->user()->can("*");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'roles_ids' => ['required', 'array'],
        ];
    }

    public function prepareForValidation()
    {
        $roles = $this->roles_ids;
        foreach ($roles as $r) {
            $role = Role::findOrFail($r);
            if ($role->has_multiple_assignees) continue;

            $alreadyAssigned = DB::table('model_has_roles')
            ->where('model_type', 'App\Models\User')
            ->where('role_id', $role->id)
            ->exists();
            if($alreadyAssigned){
                throw ValidationException::withMessages([
                    'roles_ids' => ['can not assign role ' . $role->name . ' because already assigned'],
                ]);
            }
        }
    }
}
