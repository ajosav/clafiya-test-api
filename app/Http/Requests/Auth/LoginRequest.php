<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Facades\ClafiyaUtil;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function requestUser()
    {
        $username = $this->input('username');
        $fieldType = ClafiyaUtil::setLoginFieldType($username);
        $user = User::where($fieldType, $username)->first();

        if(!$user)
            throw ValidationException::withMessages([
                $this->username() => "Either the " . $this->username() . " or password provided does not match",
            ]);

        Cache::put($username, $user);

        return $user;
    }
}
