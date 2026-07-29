<?php

namespace SolarPlantRequests\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SolarPlantRequests\Enums\ApplicantType;

class StoreSolarPlantRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $applicantType = $this->input('applicant_type');

        $rules = [
            // Applicant info
            'applicant_type' => ['required', 'string', 'in:individual,company,foreigner'],
            'mobile' => ['required', 'digits:11'],
            'landline' => ['nullable', 'string', 'max:20'],
            'bill_identifier' => ['nullable', 'string', 'max:255'],

            // Installation location
            'province' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'digits:10'],
            'address' => ['required', 'string'],

            // Technical specs
            'usage_type' => ['required', 'string', 'in:villa,industrial,commercial,agriculture,apartment'],
            'is_shared_property' => ['required', 'boolean'],
            'installation_area' => ['nullable', 'integer', 'min:0'],
            'surface_type' => ['required', 'string', 'in:flat,sloped,ground,other'],
            'purpose' => ['required', 'string', 'in:off_grid,on_grid,hybrid'],
            'capacity_kw' => ['required', 'integer', 'min:1'],
            'has_three_phase' => ['required', 'boolean'],
            'wants_loan' => ['required', 'boolean'],
            'description' => ['nullable', 'string', 'max:2000'],
            'images'      => ['nullable', 'array', 'max:4'],
            'images.*'    => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'documents'   => ['nullable', 'array', 'max:4'],
            'documents.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];

        // Conditional rules based on applicant type
        if ($applicantType === ApplicantType::INDIVIDUAL->value) {
            $rules['first_name'] = ['required', 'string', 'max:255'];
            $rules['last_name'] = ['required', 'string', 'max:255'];
            $rules['national_code'] = ['required', 'digits:10'];
            $rules['mobile'] = ['required', 'digits:11'];
            $rules['bill_identifier'] = ['required', 'string', 'max:255'];
        } elseif ($applicantType === ApplicantType::COMPANY->value) {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['registration_number'] = ['required', 'string', 'max:50'];
            $rules['mobile'] = ['required', 'digits:11'];
            $rules['bill_identifier'] = ['required', 'string', 'max:255'];
        } elseif ($applicantType === ApplicantType::FOREIGNER->value) {
            $rules['first_name'] = ['required', 'string', 'max:255'];
            $rules['last_name'] = ['required', 'string', 'max:255'];
            $rules['immigration_code'] = ['required', 'string', 'max:20'];
            $rules['mobile'] = ['required', 'digits:11'];
            $rules['bill_identifier'] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            // applicant_type
            'applicant_type.required'      => 'لطفاً نوع متقاضی را انتخاب کنید.',
            'applicant_type.in'            => 'نوع متقاضی انتخاب‌شده معتبر نیست.',

            // individual
            'first_name.required'          => 'وارد کردن نام الزامی است.',
            'first_name.max'               => 'نام نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',
            'last_name.required'           => 'وارد کردن نام خانوادگی الزامی است.',
            'last_name.max'                => 'نام خانوادگی نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',
            'national_code.required'       => 'وارد کردن کد ملی الزامی است.',
            'national_code.max'            => 'کد ملی نمی‌تواند بیش از ۱۰ رقم باشد.',

            // company
            'company_name.required'        => 'وارد کردن نام شرکت الزامی است.',
            'registration_number.required' => 'وارد کردن شماره ثبت شرکت الزامی است.',
            'ceo_national_id.required'     => 'وارد کردن شناسه مدیر عامل الزامی است.',
            'ceo_national_id.max'          => 'شناسه مدیر عامل نمی‌تواند بیش از ۱۰ رقم باشد.',

            // foreigner
            'immigration_code.required'    => 'وارد کردن کد اتباع الزامی است.',

            // common applicant
            'mobile.required'              => 'وارد کردن شماره موبایل الزامی است.',
            'mobile.digits'                   => 'شماره موبایل باید 11 رقم باشد.',
            'bill_identifier.required'     => 'وارد کردن شناسه قبض برق الزامی است.',
            'bill_identifier.max'          => 'شناسه قبض برق نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

            // location
            'province.required'            => 'لطفاً نام استان را وارد کنید.',
            'city.required'                => 'لطفاً نام شهر را وارد کنید.',
            'postal_code.required'         => 'وارد کردن کد پستی الزامی است.',
            'postal_code.digits'              => 'کد پستی باید 10 رقم باشد',
            'address.required'             => 'وارد کردن آدرس دقیق الزامی است.',

            // technical
            'usage_type.required'          => 'لطفاً نوع کاربری را انتخاب کنید.',
            'usage_type.in'                => 'نوع کاربری انتخاب‌شده معتبر نیست.',
            'is_shared_property.required'  => 'لطفاً مشخص کنید ملک مشاع است یا خیر.',
            'installation_area.integer'    => 'مساحت محل نصب باید یک عدد صحیح باشد.',
            'installation_area.min'        => 'مساحت محل نصب نمی‌تواند منفی باشد.',
            'surface_type.required'        => 'لطفاً نوع سطح محل نصب را انتخاب کنید.',
            'surface_type.in'              => 'نوع سطح انتخاب‌شده معتبر نیست.',
            'purpose.required'             => 'لطفاً هدف از نصب را انتخاب کنید.',
            'purpose.in'                   => 'هدف انتخاب‌شده معتبر نیست.',
            'capacity_kw.required'         => 'وارد کردن ظرفیت (کیلو وات) الزامی است.',
            'capacity_kw.integer'          => 'ظرفیت باید یک عدد صحیح باشد.',
            'capacity_kw.min'              => 'ظرفیت باید حداقل ۱ کیلو وات باشد.',
            'has_three_phase.required'     => 'لطفاً مشخص کنید برق ۳ فاز دارید یا خیر.',
            'wants_loan.required'          => 'لطفاً مشخص کنید تمایل به دریافت وام دارید یا خیر.',
            'description.max'              => 'توضیحات نمی‌تواند بیش از ۲۰۰۰ کاراکتر باشد.',
            'images.array'                 => 'فرمت تصاویر نامعتبر است.',
            'images.max'                   => 'حداکثر ۱۰ تصویر مجاز است.',
            'images.*.file'                => 'هر آیتم باید یک فایل معتبر باشد.',
            'images.*.mimes'               => 'فرمت تصاویر باید JPG یا PNG باشد.',
            'images.*.max'                 => 'حجم هر تصویر نمی‌تواند بیش از ۵ مگابایت باشد.',
            'documents.array'              => 'فرمت مدارک نامعتبر است.',
            'documents.max'                => 'حداکثر ۱۰ فایل مدرک مجاز است.',
            'documents.*.file'             => 'هر آیتم باید یک فایل معتبر باشد.',
            'documents.*.mimes'            => 'فرمت مدارک باید JPG، PNG یا PDF باشد.',
            'documents.*.max'              => 'حجم هر فایل مدرک نمی‌تواند بیش از ۵ مگابایت باشد.',
        ];
    }

    public function attributes(): array
    {
        return [
            'applicant_type'    => 'نوع متقاضی',
            'first_name'        => 'نام',
            'last_name'         => 'نام خانوادگی',
            'mobile'            => 'شماره موبایل',
            'national_code'     => 'کد ملی',
            'company_name'      => 'نام شرکت',
            'registration_number' => 'شماره ثبت شرکت',
            'ceo_national_id'   => 'شناسه مدیر عامل',
            'immigration_code'  => 'کد اتباع',
            'landline'          => 'تلفن ثابت',
            'bill_identifier'   => 'شناسه قبض برق',
            'province'          => 'استان',
            'city'              => 'شهر',
            'postal_code'       => 'کد پستی',
            'address'           => 'آدرس دقیق',
            'usage_type'        => 'نوع کاربری',
            'is_shared_property' => 'نوع ملک مشاع',
            'installation_area' => 'مساحت تقریبی محل نصب',
            'surface_type'      => 'نوع سطح محل نصب',
            'purpose'           => 'هدف',
            'capacity_kw'       => 'ظرفیت (کیلو وات)',
            'has_three_phase'   => 'برق ۳ فاز',
            'wants_loan'        => 'تمایل به دریافت وام',
            'description'       => 'توضیحات',
        ];
    }
}
