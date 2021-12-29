<?php

namespace App\Rules;

use App\Http\Inspections\Spam;
use Illuminate\Contracts\Validation\Rule;

class SpamDetection implements Rule
{

    private $spam;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->spam= new Spam();

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
       return ! $this->spam->detect($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The comment contains Spam.';
    }
}
