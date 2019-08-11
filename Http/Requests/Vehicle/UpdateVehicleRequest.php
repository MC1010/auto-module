<?php

namespace Plugins\Auto\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'year' => 'required|integer',
            'make' => 'required|string',
            'model' => 'required|string',
            'color' => 'required|string',
            'state' => 'nullable|string|required_with:plate',
            'plate' => 'nullable|string|required_with:state',
            'vin' => 'nullable|string'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
