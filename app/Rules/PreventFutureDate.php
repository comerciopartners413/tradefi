<?php

namespace TradefiUBA\Rules;

use Illuminate\Contracts\Validation\Rule;

class PreventFutureDate implements Rule
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
        $current_date  = \Carbon\Carbon::now();
        $selected_date = \Carbon\Carbon::parse($value);
        if ($selected_date > $current_date) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Date of birth cannot be future date';
    }
}
