@extends('layouts.app')

@section('title', $work->title . ' - Play digital ' . $siteConfig['tagline_top'])

@section('content')
    <section class="paragraph paragraphDetail">
        <div class="container">
            <div class="navigator">
                @if($work->category)
                    <a href="{{ route('work.category', ['category' => $work->category->slug]) }}">&lt; back to {{ $work->category->name }}</a>
                @else
                    <a href="{{ route('work.index') }}">&lt; back</a>
                @endif
            </div>

            <div class="pageDetail">
                <div class="galleryDetail">
                    @if($work->isVideo())
                        <div class="detailVideoEmbed">
                            <iframe
                                src="https://www.youtube.com/embed/{{ $work->youtube_id }}?rel=0&playsinline=1"
                                title="{{ $work->title }}"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen"
                                referrerpolicy="strict-origin-when-cross-origin"
                                allowfullscreen
                            ></iframe>
                        </div>
                    @endif

                    <ul>
                        @php
                            $images = !empty($work->gallery_images) ? $work->gallery_images : [$work->thumbnail];
                        @endphp
                        @foreach($images as $img)
                            @if(! $work->isVideo() || $loop->index > 0)
                                <li>
                                    <div class="detailVisualBox">
                                        <img src="{{ asset($img) }}" alt="{{ $work->title }}" class="detailMainImg">
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="contentDetail">
                    <article>
                        <h1 class="title">{{ $work->title }}</h1>
                        @if($work->subtitle)
                            <div style="font-size: 16px; color: #642f96; font-weight: 600; margin: -6px 0 14px;">
                                {{ $work->subtitle }}
                            </div>
                        @endif

                        <div class="metaList">
                            @if($work->client_name)
                                <div><strong>Client :</strong> {{ $work->client_name }}</div>
                            @endif
                            @if($work->product_name)
                                <div><strong>Product :</strong> {{ $work->product_name }}</div>
                            @endif
                            @if($work->campaign_name)
                                <div><strong>Campaign :</strong> {{ $work->campaign_name }}</div>
                            @endif
                            @if($work->media_type)
                                <div><strong>Media :</strong> {{ $work->media_type }}</div>
                            @endif
                        </div>

                        @if($work->description)
                            <div style="font-weight: 700; color: #111111; margin-bottom: 6px;">Detail :</div>
                            <div class="detail">{{ $work->description }}</div>
                        @endif

                        @if($work->external_url)
                            <div class="externalLinkBox">
                                <div style="font-weight: 700; color: #111111; margin-bottom: 4px;">Link</div>
                                <a href="{{ $work->external_url }}" target="_blank" rel="noopener noreferrer">
                                    {{ $work->external_url }}
                                </a>
                            </div>
                        @endif

                        @if($work->isVideo())
                            <div style="margin-top: 20px;">
                                <button
                                    type="button"
                                    class="btnClassicPurple"
                                    data-open-youtube="{{ $work->youtube_id }}"
                                >
                                    ▶ Open Video Lightbox
                                </button>
                            </div>
                        @endif
                    </article>
                </div>

                <div class="clear"></div>
            </div>

            @if($relatedWorks->isNotEmpty())
                <div style="margin-top: 64px;">
                    <header class="sectionHeaderClassic">
                        <h2 class="top" style="font-size: 24px;">MORE IN {{ $work->category->name }}</h2>
                    </header>
                    <div class="pagePortFolioHome" style="padding-top: 24px;">
                        <ul>
                            @foreach($relatedWorks as $rel)
                                @include('partials.work-card', ['work' => $rel])
                            @endforeach
                        </ul>
                        <div class="clear"></div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
