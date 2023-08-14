<?php

namespace App\Http\Requests\CMS\Customer;

use App\Constants\GeneralStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('cms')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|unique:customers,username',
            'name' => 'required',
            'email' => 'required|unique:customers,email',
            'phone' => 'nullable|unique:customers,phone',
            'password' => 'required',
        ];
    }

    /**
     * Final result of the form request.
     *
     * @return array
     */
    public function credentials()
    {
        return [
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => normalize_phone($this->phone),
            'password' => Hash::make($this->password),
            'status' => GeneralStatus::ACTIVE,
        ];
    }
}
