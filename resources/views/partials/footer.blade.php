@php
    $isHome = request()->routeIs('home');
    $hideFooterForm = View::hasSection('hide_footer_form');
@endphp

<footer id="contact" class="pageContact">
    <div class="container">
        <div class="contactGridWrap">
            <div class="contact-left">
                <div class="logoFooter">
                    <a href="{{ route('home') }}" aria-label="Play Digital">
                        <img src="{{ asset('images/logoFooter.png') }}" alt="Play Digital">
                    </a>
                </div>

                <nav class="menuFooter" aria-label="Footer Navigation">
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ $isHome ? '#services' : route('home') . '#services' }}">Services</a></li>
                        <li><a href="{{ route('work.index') }}">Work</a></li>
                        <li><a href="{{ route('clients.index') }}">Client</a></li>
                        <li><a href="{{ $isHome ? '#about' : route('home') . '#about' }}">About</a></li>
                        <li><a href="{{ route('blog.index') }}">Blog</a></li>
                        <li><a href="{{ route('contact.index') }}">Contact</a></li>
                    </ul>
                </nav>

                <div class="contentContact">
                    <p><strong>{{ $siteConfig['company_name'] }}</strong></p>
                    @foreach($siteConfig['address_lines'] as $line)
                        <p>{{ $line }}</p>
                    @endforeach
                    <p style="margin-top: 8px;">
                        Office : <a href="tel:{{ $siteConfig['phone_tel'] }}">{{ $siteConfig['phone_display'] }}</a>
                    </p>
                    <p>
                        Email : <a href="mailto:{{ $siteConfig['email'] }}">{{ $siteConfig['email'] }}</a>
                    </p>
                    <a href="{{ $siteConfig['maps_url'] }}" target="_blank" rel="noopener noreferrer" class="mapDirectionLink">
                        ดูแผนที่เดินทางไปอาคาร Park Silom Tower (Google Maps) ↗
                    </a>
                </div>

                <div class="iconSocialFooter">
                    <a href="{{ $siteConfig['facebook_url'] }}" target="_blank" rel="noopener noreferrer" aria-label="Play Digital Facebook">
                        <img src="{{ asset('images/iconFacebook-footer.svg') }}" alt="Facebook">
                    </a>
                    <a href="{{ $siteConfig['youtube_channel_url'] }}" target="_blank" rel="noopener noreferrer" aria-label="Play Digital YouTube">
                        <img src="{{ asset('images/iconYoutubeFooter.svg') }}" alt="YouTube">
                    </a>
                </div>

                <div class="boxCopyright">
                    {{ $siteConfig['copyright'] }}
                </div>
            </div>

            @unless($hideFooterForm)
                <div class="contact-right">
                    @include('partials.contact-form', ['light' => false, 'formId' => 'footer_inquiry_form'])
                </div>
            @endunless
        </div>
        <div class="clear"></div>
    </div>
</footer>
