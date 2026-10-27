<li>
    <a href="{{ route('work.show', ['work' => $work->slug]) }}">
        <div class="boxPort">
            <figure style="background-image: url('{{ asset($work->thumbnail) }}');">
                <img src="{{ asset('images/spaceQuadrate.png') }}" alt="{{ $work->title }}" loading="lazy" style="width:100%; height:100%; opacity:0;">
            </figure>
            <article>
                <div class="name">{{ $work->title }}</div>
                @if($work->subtitle)
                    <div class="discription">{{ $work->subtitle }}</div>
                @endif
                @if($work->category)
                    <nav>{{ $work->category->name }}</nav>
                @endif
            </article>
        </div>
    </a>
</li>
