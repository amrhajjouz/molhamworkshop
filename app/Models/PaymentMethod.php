<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use SoftDeletes;
    protected $table = 'payment_methods';
    protected $casts = ['deleted_at' => 'datetime:Y-m-d H:i:s', 'created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s', 'future_usage' => "boolean"];
    protected $guarded = [];
    
    public function methodable()
    {
        return $this->morphTo();
    }

    public function save(array $options = [])
    {
        
        if (!$this->exists) {
            $this->type = getPaymentMethodType($this->methodable_type);
            $methodable =  getMorphedModel($this->methodable_type)::create($this->methodable);
            $this->methodable_id = $methodable->id;
            unset($this->methodable);
        }
        
        return parent::save();
    }
    
    public function apiTransform()
    {
        return ['id' => $this->id,'type' => $this->type, $this->type => $this->methodable->apiTransform()];
    }
}
