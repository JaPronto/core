<?php

namespace App\Http\Requests\SubOrganization;

use App\SubOrganization;
use Illuminate\Foundation\Http\FormRequest;

class CreateSubOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', SubOrganization::class);
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
            'description' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'organization_id' => 'required|exists:organizations,id'
        ];
    }
}
