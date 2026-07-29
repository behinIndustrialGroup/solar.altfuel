<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstallerApplicationRequest extends FormRequest
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
        return [
            'first_name'  => ['required', 'string', 'max:100'],
            'last_name'   => ['required', 'string', 'max:100'],
            'national_id' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'phone'       => ['required', 'string', 'regex:/^09[0-9]{9}$/'],
            'province'    => ['required', 'string', 'max:100'],
            'city'        => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name'  => 'نام',
            'last_name'   => 'نام خانوادگی',
            'national_id' => 'کد ملی',
            'phone'       => 'شماره موبایل',
            'province'    => 'استان',
            'city'        => 'شهر',
            'description' => 'توضیحات',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required'  => 'وارد کردن نام الزامی است.',
            'last_name.required'   => 'وارد کردن نام خانوادگی الزامی است.',
            'national_id.required' => 'وارد کردن کد ملی الزامی است.',
            'national_id.regex'    => 'کد ملی باید دقیقاً ۱۰ رقم عددی باشد.',
            'phone.required'       => 'وارد کردن شماره موبایل الزامی است.',
            'phone.regex'          => 'شماره موبایل باید با ۰۹ شروع شده و ۱۱ رقم باشد (مثال: 09123456789).',
            'province.required'    => 'انتخاب استان الزامی است.',
            'city.required'        => 'وارد کردن شهر الزامی است.',
            'description.max'      => 'توضیحات نمی‌تواند بیشتر از ۲۰۰۰ کاراکتر باشد.',
        ];
    }
}
