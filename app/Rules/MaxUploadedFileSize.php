<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxUploadedFileSize implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($parameters)
    {
        $this->param = $parameters;
    }

    public $param;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $total_size = array_reduce($value, function ( $sum, $item ) {
            $sum += filesize($item->path());
            return $sum;
        });

        return $total_size < $this->param * 1024;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Превышен общий объем файлов!';
    }
}
