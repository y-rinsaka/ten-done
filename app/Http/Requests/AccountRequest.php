<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Account;
class AccountRequest extends FormRequest
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
    public function rules(Request $request)
    {
        // バリデーションルールはAccountモデルに記載
        $rules = Account::$rules;

        // メソッドがPATCHのとき=つまりupdate()アクションが呼ばれるとき
        if ($request->method() == 'PATCH') {
            // passwordのrequiredの条件を外し、nullableにする
            $key = array_search('required', $rules['password']);
            unset($rules['password'][$key]);
            array_push($rules['password'], 'nullable');

            // updateのときに、元のemailと同じ値であってもバリデーションエラーにならないようにする
            // https://readouble.com/laravel/6.x/ja/validation.html#rule-unique
            $key = array_search('unique:accounts', $rules['taiko_id']);
            unset($rules['taiko_id'][$key]);
            array_push($rules['taiko_id'], Rule::unique('accounts')->ignore(Auth::user()));
        }
        return $rules;
    }

    /**
     * バリデーションエラーメッセージ
     *
     * @return array
     */
    public function messages()
    {
        // Accountモデルに記述しているエラーメッセージを返す
        return Account::$messages;
    }
}
