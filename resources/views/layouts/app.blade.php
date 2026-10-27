<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Play digital ' . $siteConfig['tagline_top'])</title>
    <meta name="description" content="@yield('meta_description', $siteConfig['about_description'])">
    <meta property="og:title" content="@yield('title', 'Play digital ' . $siteConfig['tagline_top'])">
    <meta property="og:description" content="@yield('meta_description', $siteConfig['about_description'])">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('images/showreel-poster.jpg') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/css.css') }}">
</head>
<body>
    @include('partials.header')

    <main id="main-content" class="mainWhiteSurface">
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Showreel / Video Lightbox Modal --}}
    <div id="videoLightboxModal" class="videoModalBackdrop" aria-hidden="true" role="dialog" aria-label="Play Digital Video Player">
        <div class="boxControlVDO">
            <button type="button" id="videoLightboxClose" class="videoModalClose" aria-label="Close video">✕ Close</button>
            <iframe
                id="videoLightboxFrame"
                src=""
                title="Play Digital Video"
                allow="autoplay; encrypted-media; picture-in-picture; fullscreen"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen
            ></iframe>
        </div>
    </div>

    <script src="{{ asset('js/site.js') }}" defer></script>
</body>
</html>
