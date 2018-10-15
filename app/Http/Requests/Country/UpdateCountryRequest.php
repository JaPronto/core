<?php

namespace App\Http\Requests\Country;

use App\Repositories\CountryRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCountryRequest extends FormRequest
{
    protected $countryRepository;

    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null, CountryRepository $countryRepository)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->countryRepository = $countryRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->route('country'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'name' => 'required|string',
            'code' => [
                'required',
                'string',
                Rule::unique('countries', 'code')->ignore($this->route('country')->id)
            ]
        ];
    }
}
