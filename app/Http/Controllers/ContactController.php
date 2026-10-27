<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactInquiryRequest;
use App\Models\ContactInquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('pages.contact');
    }

    public function store(StoreContactInquiryRequest $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();

        // Silently drop bots filling hidden honeypot field
        if (! empty($validated['website_url'] ?? null)) {
            $successMsg = 'ขอบคุณสำหรับข้อความ ทีมงาน Play Digital ได้รับข้อมูลเรียบร้อยแล้วครับ';

            if ($request->expectsJson()) {
                return response()->json(['status' => 'ok', 'message' => $successMsg], 201);
            }

            return back()->with('contact_success', $successMsg);
        }

        $inquiry = ContactInquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'company' => $validated['company'] ?? null,
            'service_interest' => $validated['service_interest'] ?? null,
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
            'status' => 'new',
        ]);

        Log::info('New Play Digital contact inquiry received', [
            'inquiry_id' => $inquiry->id,
            'name' => $inquiry->name,
            'email' => $inquiry->email,
            'service_interest' => $inquiry->service_interest,
        ]);

        $successMessage = 'ขอบคุณสำหรับข้อมูลการติดต่อ ทีมงาน Play Digital ได้รับข้อความของคุณเรียบร้อยแล้ว และจะติดต่อกลับโดยเร็วที่สุดครับ';

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'ok',
                'message' => $successMessage,
                'inquiry_id' => $inquiry->id,
            ], 201);
        }

        $previous = url()->previous();
        $target = str_contains($previous, '#contact') ? $previous : $previous . '#contact';

        return redirect()->to($target)->with('contact_success', $successMessage);
    }
}
