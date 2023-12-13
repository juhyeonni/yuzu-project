<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    $emailRule = "required|email|max:255|unique:users";
    if ($this->user()->email === $this->input("email")) {
      $emailRule = "required|email|max:255";
    }

    $usernameRule = "required|max:255|unique:users";
    if ($this->user()->username === $this->input("username")) {
      $usernameRule = "required|max:255";
    }

    // dd($this->input());

    return [
      "name" => "required|max:255",
      "email" => $emailRule,
      "username" => $usernameRule,
      "password" => "required|min:8",
      "new_password" => "nullable|min:8|confirmed",
      "photo" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240",
    ];
  }
}
