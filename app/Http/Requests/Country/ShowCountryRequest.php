<?php

namespace App\Http\Requests\Country;

use App\Country;
use App\Repositories\CountryRepository;
use Illuminate\Foundation\Http\FormRequest;

class ShowCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $country = $this->getModel('country', Country::class);
        return !$this->user() || $this->user()->can('show', $country);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
