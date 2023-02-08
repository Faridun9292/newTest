<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules()
    {
        return [
            'order_date' => ['required', 'date_format:d.m.Y'],
            'phone' => ['nullable', 'min:12'],
            'email' => ['required', 'email'],
            'address' => ['required', 'string'],
            'coordinates'=>  ['nullable', 'string'],
            'price' => ['array', 'required'],
            'price.*' => ['numeric', 'required'],
            'count' => ['required', 'array'],
            'count.*' => ['required', 'integer'],
            'products_id' => ['required', 'array'],
            'products_id.*' => ['required', 'integer']
        ];
    }
}
