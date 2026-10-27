@php
    $isHome = request()->routeIs('home');
    $isWork = request()->routeIs('work.*');
    $isClients = request()->routeIs('clients.*');
    $isBlog = request()->routeIs('blog.*');
    $isContact = request()->routeIs('contact.*');
@endphp

<header class="mainHeader">
    <div class="container overflowNone">
        <div class="logoMain">
            <a href="{{ route('home') }}" aria-label="Play Digital Home">
                <img src="{{ asset('images/playdigital-logo.png') }}" alt="Play Digital">
            </a>
        </div>

        <div class="iconSocial">
            <nav>
                <a href="{{ $siteConfig['facebook_url'] }}" target="_blank" rel="noopener noreferrer" aria-label="Play Digital Facebook">
                    <img src="{{ asset('images/iconFacebook.svg') }}" alt="Facebook">
                </a>
            </nav>
            <nav>
                <a href="{{ $siteConfig['youtube_channel_url'] }}" target="_blank" rel="noopener noreferrer" aria-label="Play Digital YouTube">
                    <img src="{{ asset('images/iconYoutube.svg') }}" alt="YouTube">
                </a>
            </nav>
            <div class="clear"></div>
        </div>

        <nav class="menuMain" aria-label="Main Navigation">
            <ul>
                <li>
                    <a href="{{ route('home') }}" class="{{ $isHome ? 'active' : '' }}">Home</a>
                </li>
                <li>
                    <a href="{{ $isHome ? '#services' : route('home') . '#services' }}">Services</a>
                </li>
                <li class="hasSubmenu">
                    <a href="{{ route('work.index') }}" class="{{ $isWork ? 'active' : '' }}">Work</a>
                    @if($navCategories->isNotEmpty())
                        <ul class="subMenuWork">
                            <span class="caretTop"></span>
                            @foreach($navCategories as $navCat)
                                <li>
                                    <a href="{{ route('work.category', ['category' => $navCat->slug]) }}">
                                        {{ $navCat->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
                <li>
                    <a href="{{ route('clients.index') }}" class="{{ $isClients ? 'active' : '' }}">Client</a>
                </li>
                <li>
                    <a href="{{ $isHome ? '#about' : route('home') . '#about' }}">About</a>
                </li>
                <li>
                    <a href="{{ route('blog.index') }}" class="{{ $isBlog ? 'active' : '' }}">Blog</a>
                </li>
                <li>
                    <a href="{{ $isContact ? '#contact-page' : '#contact' }}" class="{{ $isContact ? 'active' : '' }}">Contact</a>
                </li>
            </ul>
        </nav>

        <div class="clear"></div>
    </div>
</header>

<div class="headerSpacer"></div>

{{-- Mobile Burger Bar (.Menumobile) --}}
<div class="Menumobile">
    <div class="boxMenuBurger">
        <div class="dl-menuwrapper">
            <button type="button" class="dl-trigger" data-burger-trigger aria-expanded="false" aria-label="Open Menu">Open Menu</button>
            <ul class="dl-menu" data-burger-menu>
                <li><a href="{{ route('home') }}" class="{{ $isHome ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ $isHome ? '#services' : route('home') . '#services' }}">Services</a></li>
                <li>
                    <button type="button" class="dl-sub-toggle" data-mobile-work-toggle aria-expanded="false">
                        <span>Work</span>
                        <span>▾</span>
                    </button>
                    <ul class="dl-submenu">
                        <li><a href="{{ route('work.index') }}">ALL WORK</a></li>
                        @foreach($navCategories as $navCat)
                            <li>
                                <a href="{{ route('work.category', ['category' => $navCat->slug]) }}">
                                    {{ $navCat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="{{ route('clients.index') }}" class="{{ $isClients ? 'active' : '' }}">Client</a></li>
                <li><a href="{{ $isHome ? '#about' : route('home') . '#about' }}">About</a></li>
                <li><a href="{{ route('blog.index') }}" class="{{ $isBlog ? 'active' : '' }}">Blog</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
    </div>
</div>
