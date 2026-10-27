<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactInquiryRequest extends FormRequest
{
    protected $errorBag = 'contact';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:160'],
            'service_interest' => ['nullable', 'string', 'max:160'],
            'subject' => ['nullable', 'string', 'max:200'],
            'message' => ['required', 'string', 'min:5', 'max:3000'],
            'website_url' => ['nullable', 'string', 'max:255'], // Honeypot field
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'กรุณากรอกชื่อผู้ติดต่อ (Please enter your name)',
            'email.required' => 'กรุณากรอกอีเมล (Please enter your email)',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง (Please enter a valid email address)',
            'message.required' => 'กรุณากรอกรายละเอียดที่ต้องการติดต่อ (Please enter your message)',
            'message.min' => 'กรุณากรอกข้อความอย่างน้อย 5 ตัวอักษร',
        ];
    }

    protected function getRedirectUrl(): string
    {
        $url = parent::getRedirectUrl();

        return str_contains($url, '#contact') ? $url : $url . '#contact';
    }
}
