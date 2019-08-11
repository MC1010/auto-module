<?php

namespace Plugins\Auto\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'date' => 'required|date_format:mdY',
            'mileage' => 'integer|nullable',
            'location' => 'string|nullable',
            'type' => 'string|nullable',
            'notes' => 'string|nullable'
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
