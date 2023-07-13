<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    public const ALLOWANCE_ID_KEY = 'allowance_id';

    public const EXPENSE_KEY = 'expense';

    public const MEMO_KEY = 'memo';

    public const TYPE_KEY = 'type';

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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            self::EXPENSE_KEY => 'required',
            self::MEMO_KEY => 'required',
            self::TYPE_KEY => 'required',
        ];
    }
}
