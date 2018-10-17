<?php

namespace App\Http\Requests\SubOrganization;

use App\SubOrganization;
use Illuminate\Foundation\Http\FormRequest;

class DeleteSubOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('delete', $this->getModel('sub_organization', SubOrganization::class));
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
