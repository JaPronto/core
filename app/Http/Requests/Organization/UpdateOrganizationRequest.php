<?php

namespace App\Http\Requests\Organization;

use App\Organization;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->getModel('organization', Organization::class));
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
            'country_id' => 'nullable|exists:countries,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image'
        ];
    }
}
