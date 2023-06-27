<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Services;

class UniqueCronType implements Rule
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
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // If the value is not null, check if the cron type is already registered
        return Services::where('cron_type', $value)->count() == 0;
    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        return 'This Type has been registered.';
    }
}
