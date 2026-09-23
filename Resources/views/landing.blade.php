@extends('masjidmediahelpcenter::layouts.public')

@php
    // Icons are drawn once and referenced by <use>, as on the website's about page.
    $tiles = [
        ['href' => $links['mobile_guide'], 'icon' => 'phone', 'label' => 'label_guide', 'key' => 'mobile_guide'],
        ['href' => $links['tv_guide'], 'icon' => 'tv', 'label' => 'label_guide', 'key' => 'tv_guide'],
        ['href' => $links['docs'], 'icon' => 'book', 'label' => 'label_guide', 'key' => 'docs'],
        ['href' => $links['privacy'], 'icon' => 'shield', 'label' => 'label_legal', 'key' => 'privacy'],
        ['href' => $links['terms'], 'icon' => 'file', 'label' => 'label_legal', 'key' => 'terms'],
        ['href' => route('masjidmediahelpcenter.contact.show'), 'icon' => 'mail', 'label' => 'label_support', 'key' => 'contact'],
    ];
@endphp

@section('content')
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <defs>
            <symbol id="hc-ic-phone" viewBox="0 0 24 24"><rect x="6" y="2" width="12" height="20" rx="2.5"/><path d="M11 18h2"/></symbol>
            <symbol id="hc-ic-tv" viewBox="0 0 24 24"><rect x="2.5" y="4" width="19" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></symbol>
            <symbol id="hc-ic-book" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V3H6.5A2.5 2.5 0 0 0 4 5.5z"/><path d="M4 19.5A2.5 2.5 0 0 0 6.5 22H20v-5"/></symbol>
            <symbol id="hc-ic-shield" viewBox="0 0 24 24"><path d="M12 3 5 6v5.5c0 4.4 3 8 7 9.5 4-1.5 7-5.1 7-9.5V6z"/><path d="m9 12 2 2 4-4"/></symbol>
            <symbol id="hc-ic-file" viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6"/></symbol>
            <symbol id="hc-ic-mail" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></symbol>
        </defs>
    </svg>

    <section class="page-head">
        <div class="page-head-glow" aria-hidden="true"></div>
        <div class="wrap-narrow page-head-inner">
            <p class="eyebrow">{{ __('masjidmediahelpcenter::site.landing.eyebrow') }}</p>
            <h1>{{ __('masjidmediahelpcenter::site.landing.heading') }}</h1>
            <p class="page-head-sub">{{ __('masjidmediahelpcenter::site.landing.subheading') }}</p>
        </div>
    </section>

    <section class="wrap section">
        <p class="eyebrow">{{ __('masjidmediahelpcenter::site.landing.section_eyebrow') }}</p>
        <h2 class="section-title">{{ __('masjidmediahelpcenter::site.landing.section_title') }}</h2>

        <div class="tiles">
            @foreach ($tiles as $tile)
                <a href="{{ $tile['href'] }}" class="tile">
                    <span class="tile-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><use href="#hc-ic-{{ $tile['icon'] }}"/></svg>
                    </span>
                    <p class="eyebrow">{{ __('masjidmediahelpcenter::site.landing.'.$tile['label']) }}</p>
                    <h3 class="tile-title">
                        {{ __('masjidmediahelpcenter::site.landing.card_'.$tile['key'].'_title') }}
                        <span class="tile-arrow" aria-hidden="true">&rarr;</span>
                    </h3>
                    <p class="tile-body">{{ __('masjidmediahelpcenter::site.landing.card_'.$tile['key'].'_desc') }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <section class="section-band">
        <div class="wrap-narrow section-band-inner">
            <p class="eyebrow">{{ __('masjidmediahelpcenter::site.landing.cta_title') }}</p>
            <p class="section-band-body">{{ __('masjidmediahelpcenter::site.landing.cta_body') }}</p>
            <a href="{{ route('masjidmediahelpcenter.contact.show') }}" class="btn-brass">
                {{ __('masjidmediahelpcenter::site.landing.cta_button') }}
                <span aria-hidden="true">&rarr;</span>
            </a>
        </div>
    </section>
@endsection
