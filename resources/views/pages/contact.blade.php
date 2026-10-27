@extends('layouts.app')

@section('title', 'Contact - Play digital ' . $siteConfig['tagline_top'])
@section('hide_footer_form', '1')

@section('content')
    <section id="contact-page" class="paragraph paragraphClient">
        <div class="container">
            <header class="sectionHeaderClassic">
                <h1 class="top">CONTACT US</h1>
                <div class="bottom">LET’S PLAY TO WIN TOGETHER</div>
            </header>

            <div class="contactGridWrap" style="margin-top: 44px;">
                <div class="contact-left" style="color: #333333;">
                    <div style="background: #f4f4f4; padding: 30px; border: 1px solid #e5e5e5;">
                        <h2 style="font-family: var(--pd-heading-font); font-size: 22px; color: #111111; margin-bottom: 12px;">
                            {{ $siteConfig['company_name'] }}
                        </h2>
                        <div style="line-height: 1.85; font-size: 15px; color: #444444;">
                            @foreach($siteConfig['address_lines'] as $line)
                                <div>{{ $line }}</div>
                            @endforeach
                            <div style="margin-top: 12px;">
                                <strong>Office :</strong>
                                <a href="tel:{{ $siteConfig['phone_tel'] }}" style="color: #642f96; font-weight: 700;">
                                    {{ $siteConfig['phone_display'] }}
                                </a>
                            </div>
                            <div>
                                <strong>Email :</strong>
                                <a href="mailto:{{ $siteConfig['email'] }}" style="color: #642f96;">
                                    {{ $siteConfig['email'] }}
                                </a>
                            </div>
                            <div style="margin-top: 12px; font-size: 13.5px; color: #666666;">
                                การเดินทาง: BTS ศาลาแดง / MRT สีลม (อาคารพาร์คสีลม ชั้น 19 ห้อง 1902-1903 ถนนคอนแวนต์)
                            </div>
                        </div>

                        <div style="margin-top: 22px;">
                            <a href="{{ $siteConfig['maps_url'] }}" target="_blank" rel="noopener noreferrer" class="btnClassicPurple">
                                เปิดแผนที่ Google Maps ↗
                            </a>
                        </div>
                    </div>
                </div>

                <div class="contact-right">
                    @include('partials.contact-form', ['light' => true, 'formId' => 'page_inquiry_form'])
                </div>
            </div>
        </div>
    </section>
@endsection
