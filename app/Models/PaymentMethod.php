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

    public function methodable()
    {
        return $this->morphTo();
    }

    public function save(array $options = [])
    {
        $isNew = !$this->exists;
        if ($isNew) {
            $class = null;
            $this->future_usage = true;
            $this->type = $options['type'];
            $this->donor_id = auth('donor')->user()->id;
            switch ($options['type']) {
                case 'card': $class = StripeCard::class; break;
                case 'swish_account':$class = SwishAccount::class;break;
                case 'ideal_account':$class = StripeIdealAccount::class;break;
                case 'sofort_account':$class = StripeSofortAccount::class;break;
                case 'sepa_account':$class = StripeSepaAccount::class;break;
                default:throw new Exception('unrecognized type');break;
            }

    // dd(\Illuminate\Database\Eloquent\Relations\Relation::getMorphedModel('stripe_'.'card'));

            // type is not passed into methodable
            unset($options['type']);
            $methodable =  \Illuminate\Database\Eloquent\Relations\Relation::getMorphedModel('stripe_'.$this->type)::create($options);
            $this->methodable_type = 'stripe_'.$this->type;
            $this->methodable_id = $methodable->id;
        } else {
            dd('TODO');
        }
        return parent::save();
    }

    public function apiTransform()
    {
        // dd($this , $this->methodable);
        return ['id' => $this->id,'type' => $this->type ,$this->type => $this->methodable->apiTransform()];
    }
}
