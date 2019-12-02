<?php

namespace TradefiUBA\Rules;

use Illuminate\Contracts\Validation\Rule;

class TraderoomModulo implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($value % 1000 === 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Volume must be multiple of a thousand e.g 1,000 , 2,000 , 123,000 etc ';
    }
}
