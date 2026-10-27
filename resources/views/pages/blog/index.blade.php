@extends('layouts.app')

@section('title', 'Blog - Play digital ' . $siteConfig['tagline_top'])

@section('content')
    <section class="paragraph paragraphClient">
        <div class="container">
            <header class="sectionHeaderClassic">
                <h1 class="top">BLOG</h1>
                <div class="bottom">DIGITAL MARKETING IDEAS &amp; INSIGHTS</div>
            </header>

            <div class="blogGridClassic">
                @foreach($posts as $post)
                    <article class="blogCardClassic">
                        @if($post->cover_image)
                            <a href="{{ route('blog.show', $post) }}">
                                <figure>
                                    <img src="{{ asset($post->cover_image) }}" alt="{{ $post->title }}" loading="lazy">
                                </figure>
                            </a>
                        @endif
                        <div class="blogCardBody">
                            <span class="blogCategoryTag">{{ $post->category }}</span>
                            <h3>
                                <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
                            </h3>
                            <p>{{ $post->excerpt }}</p>
                            <a href="{{ route('blog.show', $post) }}" class="blogReadMore">Read More →</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
