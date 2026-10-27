@extends('layouts.app')

@section('title', 'Play digital ' . $siteConfig['tagline_top'])

@section('content')
    {{-- 1. Hero YouTube Showreel Banner --}}
    <section class="heroShowreel" aria-label="Play Digital Showreel">
        <div class="heroVideoAspect">
            <img
                src="{{ asset('images/showreel-poster.jpg') }}"
                alt="Play Digital Showreel"
                class="heroPoster"
            >
            <div class="heroIframeWrap">
                <div id="heroYoutubePlayer" data-video-id="{{ $siteConfig['youtube_showreel_id'] }}"></div>
            </div>
            <div class="heroOverlayBar">
                <div class="container heroOverlayInner">
                    <div class="heroCaption">
                        Play Digital — {{ $siteConfig['tagline_top'] }}
                    </div>
                    <div class="heroControls">
                        <button type="button" id="heroMuteToggle" class="heroBtn">
                            🔇 Unmute Sound
                        </button>
                        <button
                            type="button"
                            class="heroBtn"
                            data-open-youtube="{{ $siteConfig['youtube_showreel_id'] }}"
                        >
                            ▶ Watch Showreel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. Home Portfolio Showcase (.paragraphHome / .pagePortFolioHome) --}}
    <section class="paragraph paragraphHome">
        <div class="container">
            <header>
                <h1 class="top">{{ $siteConfig['tagline_top'] }}</h1>
                <div class="bottom">{{ $siteConfig['tagline_bottom'] }}</div>
            </header>

            <div class="pagePortFolioHome">
                <ul>
                    @foreach($featuredWorks as $work)
                        @include('partials.work-card', ['work' => $work])
                    @endforeach
                </ul>
                <div class="clear"></div>

                <div class="viewAllWorkWrap">
                    <a href="{{ route('work.index') }}" class="btnClassicPurple">View All Work</a>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. About & Play's Rules (.pageAbout / .pageAbout2) --}}
    <section id="about" class="paragraph pageAbout">
        <div class="container">
            <header>
                <h2 class="top">about</h2>
                <div class="bottom">{{ $siteConfig['about_subtitle'] }}</div>
            </header>

            <div class="pageContent">
                <p>{{ $siteConfig['about_description'] }}</p>
            </div>

            <div class="pageAbout2">
                <header>
                    <h3 class="top">Play's Rules</h3>
                </header>

                <div class="contentAbout2">
                    <ul>
                        @foreach($aboutRules as $rule)
                            <li>
                                <section>
                                    <figure>
                                        <img src="{{ asset($rule->icon_path) }}" alt="{{ $rule->title }}" loading="lazy">
                                    </figure>
                                    <article>
                                        <strong class="ruleTitle">{{ $rule->title }}</strong>
                                        <p>{{ $rule->description }}</p>
                                    </article>
                                </section>
                            </li>
                        @endforeach
                    </ul>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. Services (.pageService / .blogService — All 13 Services) --}}
    <section id="services" class="paragraph pageService">
        <div class="container">
            <header>
                <h2 class="top">Services</h2>
                <div class="bottom">{{ $siteConfig['services_subtitle'] }}</div>
            </header>

            <div class="blogService">
                <ul>
                    @foreach($services as $service)
                        <li class="{{ $service->code === '13' ? 'serviceWide' : '' }}">
                            <figure>
                                <img src="{{ asset($service->icon_path) }}" alt="{{ $service->title }}" loading="lazy">
                            </figure>
                            <article>
                                {{ $service->title }}
                                @if($service->subtitle)
                                    <span>{{ $service->subtitle }}</span>
                                @endif
                            </article>
                        </li>
                    @endforeach
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </section>
@endsection
