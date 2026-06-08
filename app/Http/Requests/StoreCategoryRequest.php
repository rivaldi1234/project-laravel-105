<?php // app/Http/Request/StoreCategoryRequest

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    protected function prepareForValidation() {
        $input = $this->all();

        // Menyisir kiriman data dan melakukan trim serta strip_tags jika tipenya string
        array_walk($input, function (&$val) {
            if (is_string($val)) {
                $val = trim(strip_tags($val));
            }
        });

        $this->merge($input); // Memasukkan kembali data yang sudah bersih ke dalam request
    }
}
public function rules() {
    return [
        'name' => 'required|string|max:255',
    ];
}