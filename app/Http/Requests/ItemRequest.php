<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required', 'between:3,255',
                Rule::unique('items')
                    ->where(function ($query) {
                        $query->where('category_id', $this->category_id)
                            ->where('location_id', $this->location_id);
                    })
            ],
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'category_id' => ['required', 'numeric',],
            'location_id' => ['required', 'numeric',],
        ];
    }
}
