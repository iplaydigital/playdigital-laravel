@extends('layouts.app')

@section('title', $post->title . ' - Play digital')

@section('content')
    <section class="paragraph paragraphClient">
        <div class="container">
            <div class="blogArticleWrap">
                <div class="navigator">
                    <a href="{{ route('blog.index') }}">&lt; back to Blog</a>
                </div>

                <span class="blogCategoryTag">{{ $post->category }}</span>
                <h1>{{ $post->title }}</h1>

                @if($post->published_at)
                    <div style="font-size: 13px; color: #888888; margin-bottom: 22px;">
                        {{ $post->published_at->format('d M Y') }} · Play Digital Co., Ltd.
                    </div>
                @endif

                @if($post->cover_image)
                    <figure style="margin-bottom: 24px;">
                        <img src="{{ asset($post->cover_image) }}" alt="{{ $post->title }}" style="width: 100%; border: 1px solid #eaeaea;">
                    </figure>
                @endif

                <div class="blogArticleContent">{{ $post->body }}</div>

                @if($recentPosts->isNotEmpty())
                    <div style="margin-top: 56px; padding-top: 32px; border-top: 1px solid #e6e6e6;">
                        <h2 style="font-family: var(--pd-heading-font); font-size: 20px; color: #111111; margin-bottom: 20px; text-transform: uppercase;">
                            More Articles
                        </h2>
                        <div class="blogGridClassic" style="grid-template-columns: repeat(2, 1fr); margin-top: 0;">
                            @foreach($recentPosts as $rel)
                                <article class="blogCardClassic">
                                    <div class="blogCardBody">
                                        <span class="blogCategoryTag">{{ $rel->category }}</span>
                                        <h3><a href="{{ route('blog.show', $rel) }}">{{ $rel->title }}</a></h3>
                                        <a href="{{ route('blog.show', $rel) }}" class="blogReadMore">Read More →</a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
