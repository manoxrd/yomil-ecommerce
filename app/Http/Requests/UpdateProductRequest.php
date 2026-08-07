<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
   * @return array<string, ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'name' => ['required', 'string', 'max:50', 'min:5'],
      'description' => ['nullable', 'string', 'max:255', 'min:10'],
      'price' => ['required', 'numeric', 'min:1'],
      'stock' => ['required', 'numeric', 'min:0'],
      'is_active' => ['required', 'boolean'],
      'thumbnail' => ['nullable', 'image'],
      'category_id' => ['required', 'exists:categories,id']
    ];
  }
}
