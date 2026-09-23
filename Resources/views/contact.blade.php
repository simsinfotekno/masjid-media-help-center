@extends('masjidmediahelpcenter::layouts.public')

@section('title', __('masjidmediahelpcenter::site.contact.heading').' — Masjid Media')

@section('content')
    <section class="page-head">
        <div class="page-head-glow" aria-hidden="true"></div>
        <div class="wrap-narrow page-head-inner">
            <p class="eyebrow">{{ __('masjidmediahelpcenter::site.contact.eyebrow') }}</p>
            <h1>{{ __('masjidmediahelpcenter::site.contact.heading') }}</h1>
            <p class="page-head-sub">{{ __('masjidmediahelpcenter::site.contact.subheading') }}</p>
        </div>
    </section>

    <section class="wrap section">
        @if (session('mm_contact_success'))
            <div class="notice notice-success">
                <h2>{{ __('masjidmediahelpcenter::site.contact.success_title') }}</h2>
                <p>{{ __('masjidmediahelpcenter::site.contact.success_body') }}</p>
                <a href="{{ url('/') }}" class="btn-quiet">
                    <span aria-hidden="true">&larr;</span>
                    {{ __('masjidmediahelpcenter::site.contact.back_to_home') }}
                </a>
            </div>
        @elseif (session('mm_contact_fallback'))
            @php $fallbackEmail = session('mm_contact_fallback'); @endphp
            <div class="notice notice-error">
                <h2>{{ __('masjidmediahelpcenter::site.contact.fallback_title') }}</h2>
                <p>{!! __('masjidmediahelpcenter::site.contact.fallback_body', ['email' => '<a href="mailto:'.e($fallbackEmail).'">'.e($fallbackEmail).'</a>']) !!}</p>
            </div>
        @else
            <form class="panel" method="POST" action="{{ route('masjidmediahelpcenter.contact.submit') }}">
                {{ csrf_field() }}

                {{-- Honeypot: left blank by real visitors, hidden via CSS. --}}
                <div class="hp" aria-hidden="true">
                    <label for="website">Website</label>
                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>
                <input type="hidden" name="started_at" value="{{ $startedAt }}">

                <div class="field-row">
                    <div class="field{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">{{ __('masjidmediahelpcenter::site.contact.label_name') }}</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="name" required>
                        @if ($errors->has('name'))
                            <p class="field-error">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <div class="field{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">{{ __('masjidmediahelpcenter::site.contact.label_email') }}</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                        @if ($errors->has('email'))
                            <p class="field-error">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                </div>

                <div class="field{{ $errors->has('topic') ? ' has-error' : '' }}">
                    <label for="topic">{{ __('masjidmediahelpcenter::site.contact.label_topic') }}</label>
                    <select id="topic" name="topic" required>
                        <option value="">{{ __('masjidmediahelpcenter::site.contact.placeholder_topic') }}</option>
                        @foreach ($topics as $key => $label)
                            <option value="{{ $key }}" {{ old('topic') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('topic'))
                        <p class="field-error">{{ $errors->first('topic') }}</p>
                    @endif
                </div>

                <div class="field{{ $errors->has('subject') ? ' has-error' : '' }}">
                    <label for="subject">{{ __('masjidmediahelpcenter::site.contact.label_subject') }}</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required>
                    @if ($errors->has('subject'))
                        <p class="field-error">{{ $errors->first('subject') }}</p>
                    @endif
                </div>

                <div class="field{{ $errors->has('message') ? ' has-error' : '' }}">
                    <label for="message">{{ __('masjidmediahelpcenter::site.contact.label_message') }}</label>
                    <textarea id="message" name="message" placeholder="{{ __('masjidmediahelpcenter::site.contact.placeholder_message') }}" required>{{ old('message') }}</textarea>
                    @if ($errors->has('message'))
                        <p class="field-error">{{ $errors->first('message') }}</p>
                    @endif
                </div>

                <div class="form-actions">
                    <a href="{{ url('/') }}" class="link-quiet">&larr; {{ __('masjidmediahelpcenter::site.contact.back_to_home') }}</a>
                    <button type="submit" class="btn-brass">
                        {{ __('masjidmediahelpcenter::site.contact.submit') }}
                        <span aria-hidden="true">&rarr;</span>
                    </button>
                </div>
            </form>
        @endif
    </section>
@endsection
