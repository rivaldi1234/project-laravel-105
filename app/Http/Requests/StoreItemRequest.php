<?php // app/Http/Request/StoreItemRequest

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    protected function prepareForValidation() {
        $input = $this->all();

        array_walk($input, function (&$val) {
            if (is_string($val)) {
                $val = trim(strip_tags($val));
            }
        });

        $this->merge($input);
    }

    public function rules() {
        return [
            'name'        => 'required|string|max:255',
            'quantity'    => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}