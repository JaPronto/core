<?php

namespace App\Http\Requests\SubOrganization;

use App\SubOrganization;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->getModel('sub_organization', SubOrganization::class));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string',
            'founded_at' => 'nullable',
            'description' => 'nullable|string',
            'country_id' => 'nullable|exists:countries,id',
            'organization_id' => 'nullable|exists:organizations,id'
        ];
    }
}
