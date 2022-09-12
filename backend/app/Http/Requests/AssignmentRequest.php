<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'movie_id' => [
                'required',
                'integer',
                Rule::exists('movies', 'id')
            ],
            'turn_ids' => [
                'required',
                'array'
            ],
            'turn_ids.*' => [
                'integer',
                Rule::exists('turns', 'id')
            ],
            'itinerary' => [
                'required',
                'date_format:Y-m-d'
            ],
        ];
    }
}
