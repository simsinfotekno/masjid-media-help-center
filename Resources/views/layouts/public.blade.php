@php
    $siteLinks = config('masjidmediahelpcenter.links.'.app()->getLocale(), config('masjidmediahelpcenter.links.id'));
    $sourceUrl = config('masjidmediahelpcenter.source_url');
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('masjidmediahelpcenter::site.tagline').' — Masjid Media')</title>
    <meta name="theme-color" content="#0e1318">
    <link rel="icon" type="image/png" href="{{ asset('modules/masjidmediahelpcenter/img/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('modules/masjidmediahelpcenter/img/logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,700|outfit:300,400,500,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('modules/masjidmediahelpcenter/css/helpcenter.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="wrap site-header-inner">
            <div class="site-header-left">
                <a href="{{ url('/') }}" class="site-brand">
                    <img src="{{ asset('modules/masjidmediahelpcenter/img/logo.png') }}" alt="">
                    <span class="site-brand-name">Masjid Media</span>
                    <span class="site-brand-tag">{{ __('masjidmediahelpcenter::site.tagline') }}</span>
                </a>

                <nav class="site-nav">
                    <a href="{{ $siteLinks['docs'] }}">{{ __('masjidmediahelpcenter::site.nav_guides') }}</a>
                    <a href="{{ route('masjidmediahelpcenter.contact.show') }}">{{ __('masjidmediahelpcenter::site.nav_contact') }}</a>
                    <a href="{{ $siteLinks['website'] }}">{{ __('masjidmediahelpcenter::site.nav_website') }}</a>
                </nav>
            </div>

            <a href="{{ url()->current() }}?lang={{ __('masjidmediahelpcenter::site.lang_switch_code') }}" class="site-lang">
                {{ strtoupper(__('masjidmediahelpcenter::site.lang_switch_code')) }}
            </a>
        </div>

        <nav class="wrap site-nav-mobile">
            <a href="{{ $siteLinks['docs'] }}">{{ __('masjidmediahelpcenter::site.nav_guides') }}</a>
            <a href="{{ route('masjidmediahelpcenter.contact.show') }}">{{ __('masjidmediahelpcenter::site.nav_contact') }}</a>
            <a href="{{ $siteLinks['website'] }}">{{ __('masjidmediahelpcenter::site.nav_website') }}</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="wrap site-footer-grid">
            <div class="site-footer-brand">
                <p class="site-footer-logo">
                    <img src="{{ asset('modules/masjidmediahelpcenter/img/logo.png') }}" alt="">
                    <span>Masjid Media</span>
                </p>
                <p class="site-footer-tagline">{{ __('masjidmediahelpcenter::site.footer.tagline') }}</p>
            </div>
            <div>
                <p class="eyebrow">{{ __('masjidmediahelpcenter::site.footer.help') }}</p>
                <ul class="site-footer-links">
                    <li><a href="{{ $siteLinks['mobile_guide'] }}">{{ __('masjidmediahelpcenter::site.footer.mobile_guide') }}</a></li>
                    <li><a href="{{ $siteLinks['tv_guide'] }}">{{ __('masjidmediahelpcenter::site.footer.tv_guide') }}</a></li>
                    <li><a href="{{ $siteLinks['docs'] }}">{{ __('masjidmediahelpcenter::site.footer.docs') }}</a></li>
                    <li><a href="{{ route('masjidmediahelpcenter.contact.show') }}">{{ __('masjidmediahelpcenter::site.footer.contact') }}</a></li>
                </ul>
            </div>
            <div>
                <p class="eyebrow">{{ __('masjidmediahelpcenter::site.footer.legal') }}</p>
                <ul class="site-footer-links">
                    <li><a href="{{ $siteLinks['privacy'] }}">{{ __('masjidmediahelpcenter::site.footer.privacy') }}</a></li>
                    <li><a href="{{ $siteLinks['terms'] }}">{{ __('masjidmediahelpcenter::site.footer.terms') }}</a></li>
                    <li><a href="{{ $siteLinks['delete_account'] }}">{{ __('masjidmediahelpcenter::site.footer.deletion') }}</a></li>
                    @if ($sourceUrl)
                        <li><a href="{{ $sourceUrl }}" rel="noopener">{{ __('masjidmediahelpcenter::site.footer.source') }}</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="site-footer-bottom">
            <p class="wrap">&copy; {{ date('Y') }} {{ __('masjidmediahelpcenter::site.footer.copyright') }}</p>
        </div>
    </footer>
</body>
</html>
