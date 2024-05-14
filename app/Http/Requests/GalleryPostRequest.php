<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GalleryPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array <string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        return [
            // Validar que nos llegan los valores necesarios y con el formato adecuado
            'language' => 'required|max:50',
            'title' => 'required|max:255',
            'serieName' => 'max:255',
            'artist' => 'required|max:255',
            'year' => 'max:255',
            'inventoryId' => 'required|max:255',
            'status' => 'max:50',
            'dimensions' => 'max:255',
            'price' => 'required',
            'currency' => 'max:3'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array <string, string>
     */
    public function messages(): array
    {
        return [
            // Generar los mensajes para los errores
            'title.required' => 'A title is required',
            'artist.required' => 'A artist is required',
            'inventoryId.required' => 'A inventory ID is required',
            'price.required' => 'A price is required',
        ];
    }

    protected function failedValidation(Validator $validator)
{
    throw new HttpResponseException(
        response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422)
    );
}


}
