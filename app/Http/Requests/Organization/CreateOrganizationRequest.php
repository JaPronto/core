<?php

namespace App\Http\Requests\Organization;

use App\Organization;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Organization::class);
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
            'founded_at' => 'required',
            'country_id' => 'required|exists:countries,id',
            'description' => 'required|string',
            'image' => 'required|image'
        ];
    }
}
