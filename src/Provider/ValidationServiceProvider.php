<?php

namespace Sciice\Provider;

use Sciice\Rule\Mobile;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        foreach ($this->registerRule() as $item) {
            $rules = $item['class'];

            Validator::replacer($item['name'], function ($message, $attribute, $rule, $parameters) use ($rules) {
                return $rules->message();
            });

            Validator::extend($item['name'], function ($attribute, $value, $parameters, $validator) use ($rules) {
                return $rules->passes($attribute, $value);
            });
        }
    }

    protected function registerRule()
    {
        return [
            [
                'name'  => 'mobile',
                'class' => new Mobile(),
            ],
        ];
    }
}
