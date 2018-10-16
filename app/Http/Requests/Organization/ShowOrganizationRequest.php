<?php

namespace App\Http\Requests\Organization;

use App\Organization;
use Illuminate\Foundation\Http\FormRequest;

class ShowOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !$this->user() || $this->user()->can('show', $this->getModel('organization', Organization::class));
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
