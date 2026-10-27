@php
    $isLight = $light ?? false;
    $formId = $formId ?? 'footer-contact-form';
@endphp

<div class="contactFormCard {{ $isLight ? 'lightCard' : '' }}">
    <div class="contactFormTitle">Contact Us / ส่งข้อความถึงเรา</div>
    <p class="contactFormSub">ปรึกษาโปรเจกต์เว็บไซต์ แคมเปญดิจิทัล วิดีโอ และโซเชียลมีเดียกับทีม Play Digital</p>

    <form action="{{ route('contact.store', [], false) }}" method="POST" id="{{ $formId }}" data-contact-form novalidate>
        @csrf

        {{-- Anti-spam honeypot --}}
        <div class="honeypotWrap" aria-hidden="true">
            <label for="{{ $formId }}_website_url">Website</label>
            <input type="text" name="website_url" id="{{ $formId }}_website_url" tabindex="-1" autocomplete="off">
        </div>

        <div data-form-feedback>
            @if(session('contact_success'))
                <div class="alertSuccess" role="status">
                    {{ session('contact_success') }}
                </div>
            @endif

            @if($errors->contact->any())
                <div class="alertError" role="alert">
                    @foreach($errors->contact->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="formRow2">
            <div class="formGroup">
                <label for="{{ $formId }}_name">ชื่อผู้ติดต่อ (Name) *</label>
                <input
                    type="text"
                    name="name"
                    id="{{ $formId }}_name"
                    class="formControl"
                    value="{{ old('name') }}"
                    placeholder="ชื่อ - นามสกุล"
                    required
                >
            </div>
            <div class="formGroup">
                <label for="{{ $formId }}_email">อีเมล (Email) *</label>
                <input
                    type="email"
                    name="email"
                    id="{{ $formId }}_email"
                    class="formControl"
                    value="{{ old('email') }}"
                    placeholder="name@company.com"
                    required
                >
            </div>
        </div>

        <div class="formRow2">
            <div class="formGroup">
                <label for="{{ $formId }}_phone">เบอร์โทรศัพท์ (Phone)</label>
                <input
                    type="tel"
                    name="phone"
                    id="{{ $formId }}_phone"
                    class="formControl"
                    value="{{ old('phone') }}"
                    placeholder="08X-XXX-XXXX"
                >
            </div>
            <div class="formGroup">
                <label for="{{ $formId }}_company">บริษัท / แบรนด์ (Company)</label>
                <input
                    type="text"
                    name="company"
                    id="{{ $formId }}_company"
                    class="formControl"
                    value="{{ old('company') }}"
                    placeholder="ชื่อบริษัท หรือ แบรนด์"
                >
            </div>
        </div>

        <div class="formGroup">
            <label for="{{ $formId }}_service">บริการที่สนใจ (Service of Interest)</label>
            <select name="service_interest" id="{{ $formId }}_service" class="formControl">
                <option value="">-- เลือกบริการที่สนใจ (Select Service) --</option>
                @foreach($serviceOptions as $svc)
                    @php
                        $fullSvcName = trim($svc->title . ' ' . ($svc->subtitle ?? ''));
                    @endphp
                    <option value="{{ $fullSvcName }}" @selected(old('service_interest') === $fullSvcName)>
                        {{ $fullSvcName }}
                    </option>
                @endforeach
                <option value="Other / Full Digital Campaign" @selected(old('service_interest') === 'Other / Full Digital Campaign')>
                    Other / Full Digital Campaign
                </option>
            </select>
        </div>

        <div class="formGroup">
            <label for="{{ $formId }}_message">รายละเอียดที่ต้องการติดต่อ (Message) *</label>
            <textarea
                name="message"
                id="{{ $formId }}_message"
                class="formControl"
                placeholder="เล่าโจทย์ธุรกิจ เป้าหมาย หรือรายละเอียดโปรเจกต์ของคุณ..."
                required
            >{{ old('message') }}</textarea>
        </div>

        <button type="submit" class="btnSubmitContact">Send Message</button>
    </form>
</div>
