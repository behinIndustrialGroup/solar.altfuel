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
            'mobile' => ['required', 'string', 'max:20'],
            'landline' => ['nullable', 'string', 'max:20'],
            'bill_identifier' => ['nullable', 'string', 'max:255'],

            // Installation location
            'province' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:20'],
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
        ];

        // Conditional rules based on applicant type
        if ($applicantType === ApplicantType::INDIVIDUAL->value) {
            $rules['first_name'] = ['required', 'string', 'max:255'];
            $rules['last_name'] = ['required', 'string', 'max:255'];
            $rules['national_code'] = ['required', 'string', 'max:20'];
        } elseif ($applicantType === ApplicantType::COMPANY->value) {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['registration_number'] = ['required', 'string', 'max:50'];
            $rules['mobile'] = ['required', 'string', 'max:20'];
            $rules['ceo_national_id'] = ['required', 'string', 'max:20'];
            $rules['bill_identifier'] = ['required', 'string', 'max:255'];
        } elseif ($applicantType === ApplicantType::FOREIGNER->value) {
            $rules['first_name'] = ['required', 'string', 'max:255'];
            $rules['last_name'] = ['required', 'string', 'max:255'];
            $rules['immigration_code'] = ['required', 'string', 'max:20'];
            $rules['bill_identifier'] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'applicant_type' => 'نوع متقاضی',
            'first_name' => 'نام',
            'last_name' => 'نام خانوادگی',
            'mobile' => 'شماره موبایل',
            'national_code' => 'کد ملی',
            'company_name' => 'نام شرکت',
            'registration_number' => 'شماره ثبت شرکت',
            'ceo_national_id' => 'شناسه مدیر عامل',
            'immigration_code' => 'کد اتباع',
            'landline' => 'تلفن ثابت',
            'bill_identifier' => 'شناسه قبض برق',
            'province' => 'استان',
            'city' => 'شهر',
            'postal_code' => 'کد پستی',
            'address' => 'آدرس دقیق',
            'usage_type' => 'نوع کاربری',
            'is_shared_property' => 'نوع ملک مشاع',
            'installation_area' => 'مساحت تقریبی محل نصب',
            'surface_type' => 'نوع سطح محل نصب',
            'purpose' => 'هدف',
            'capacity_kw' => 'ظرفیت (کیلو وات)',
            'has_three_phase' => 'برق ۳ فاز',
            'wants_loan' => 'تمایل به دریافت وام',
            'description' => 'توضیحات',
        ];
    }
}
