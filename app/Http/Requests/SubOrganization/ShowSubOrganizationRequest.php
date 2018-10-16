<?php

namespace App\Http\Requests\SubOrganization;

use App\Organization;
use Illuminate\Foundation\Http\FormRequest;

class ShowSubOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !$this->user() || $this->user()->can('show', $this->getModel('sub_organization', Organization::class));
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
