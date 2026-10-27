@extends('layouts.app')

@section('title', 'Client - Play digital ' . $siteConfig['tagline_top'])

@section('content')
    <section class="paragraph paragraphClient">
        <div class="container">
            <header class="sectionHeaderClassic">
                <h1 class="top">CLIENTS</h1>
                <div class="bottom">BRANDS THAT PLAY TO WIN WITH US</div>
            </header>

            <div class="pageClients">
                <ul>
                    @foreach($clients as $client)
                        <li>
                            <section title="{{ $client->name }}">
                                <figure>
                                    <img
                                        src="{{ asset($client->logo_path) }}"
                                        alt="{{ $client->name }}"
                                        loading="lazy"
                                    >
                                </figure>
                            </section>
                        </li>
                    @endforeach
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </section>
@endsection
