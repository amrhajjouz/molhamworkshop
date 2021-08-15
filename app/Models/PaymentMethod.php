<?php

namespace App\Models;

use App\Exceptions\ApiException;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Relation;

class PaymentMethod extends Model
{
    use SoftDeletes;
    protected $table = 'payment_methods';
    protected $casts = ['deleted_at' => 'datetime:Y-m-d H:i:s', 'created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s', 'future_usage' => "boolean"];

    public function methodable()
    {
        return $this->morphTo();
    }

    public function save(array $options = [])
    {
        $isNew = !$this->exists;
        if ($isNew) {
            $alias = null;
            $this->future_usage = true;
            $this->type = $options['type'];
            $this->donor_id = auth('donor')->user()->id;
            switch ($options['type']) {
                case 'card': $alias = "stripe_card"; break;
                case 'swish_account':$alias = "swish_account";break;
                case 'ideal_account':$alias = "stripe_ideal_account";break;
                case 'sofort_account':$alias ="stripe_sofort_account";break;
                case 'sepa_account':$alias = "StripeSepaAccount";break;
                default:throw new ApiException('unrecognized_payment_method_type');break;
            }
            // type is not passed into methodable
            unset($options['type']);
            $methodable = Relation::getMorphedModel($alias)::create($options);
            $this->methodable_type =  $alias;
            $this->methodable_id = $methodable->id;
        } else {
            dd('TODO');
        }
        return parent::save();
    }

    public function apiTransform()
    {
        return ['id' => $this->id,'type' => $this->type ,$this->type => $this->methodable->apiTransform()];
    }
}
