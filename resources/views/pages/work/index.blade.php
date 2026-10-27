@extends('layouts.app')

@section('title', ($activeCategory ? $activeCategory->name . ' - ' : 'Work - ') . 'Play digital ' . $siteConfig['tagline_top'])

@section('content')
    <section class="paragraph paragraphClient">
        <div class="container">
            <header class="sectionHeaderClassic">
                <h1 class="top">{{ $activeCategory ? $activeCategory->name : 'WORK' }}</h1>
                <div class="bottom">{{ $siteConfig['tagline_bottom'] }}</div>
            </header>

            <nav class="workCategoryTabs" aria-label="Work Categories">
                <a href="{{ route('work.index') }}" class="{{ $activeCategory === null ? 'active' : '' }}">
                    ALL
                </a>
                @foreach($categories as $cat)
                    <a
                        href="{{ route('work.category', ['category' => $cat->slug]) }}"
                        class="{{ $activeCategory && $activeCategory->id === $cat->id ? 'active' : '' }}"
                    >
                        {{ $cat->name }}
                    </a>
                @endforeach
            </nav>

            <div class="pagePortFolioHome">
                @if($works->isEmpty())
                    <p style="text-align: center; padding: 48px 0; color: #777777;">
                        ยังไม่มีรายการผลงานในหมวดหมู่นี้
                    </p>
                @else
                    <ul>
                        @foreach($works as $work)
                            @include('partials.work-card', ['work' => $work])
                        @endforeach
                    </ul>
                @endif
                <div class="clear"></div>
            </div>
        </div>
    </section>
@endsection
