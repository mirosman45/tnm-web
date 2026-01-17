@extends('layout')

@section('title', __('messages.about'))

@section('content')

<!-- About This Site Section -->
<div style="max-width:1000px;margin:50px auto; padding:20px; background:rgba(255,255,255,0.05); border-radius:12px; box-shadow:var(--shadow-md);">
    <h1 style="font-size:2rem;margin-bottom:20px;color:var(--text);">
        {{ __('messages.about_title') }}
    </h1>

    <p style="margin-bottom:20px;line-height:1.8;color:var(--text-muted);">
        {{ __('messages.about_text_paragraph_1') }}
    </p>

    <h2 style="font-size:1.5rem;margin-bottom:12px;color:var(--text);">
        {{ __('messages.about_section_1_title') }}
    </h2>
    <p style="margin-bottom:20px;line-height:1.6;color:var(--text-muted);">
        {{ __('messages.about_section_1_text') }}
    </p>

    <h2 style="font-size:1.5rem;margin-bottom:12px;color:var(--text);">
        {{ __('messages.about_section_2_title') }}
    </h2>
    <p style="margin-bottom:20px;line-height:1.6;color:var(--text-muted);">
        {{ __('messages.about_section_2_text') }}
    </p>

    <h2 style="font-size:1.5rem;margin-bottom:12px;color:var(--text);">
        {{ __('messages.about_section_3_title') }}
    </h2>
    <p style="margin-bottom:20px;line-height:1.6;color:var(--text-muted);">
        {{ __('messages.about_section_3_text') }}
    </p>

    <h2 style="font-size:1.5rem;margin-bottom:12px;color:var(--text);">
        {{ __('messages.about_section_4_title') }}
    </h2>
    <p style="margin-bottom:20px;line-height:1.6;color:var(--text-muted);">
        {{ __('messages.about_section_4_text') }}
    </p>

    <h2 style="font-size:1.5rem;margin-bottom:12px;color:var(--text);">
        {{ __('messages.about_section_5_title') }}
    </h2>
    <p style="margin-bottom:20px;line-height:1.6;color:var(--text-muted);">
        {{ __('messages.about_section_5_text') }}
    </p>

    <h2 style="font-size:1.5rem;margin-bottom:12px;color:var(--text);">
        {{ __('messages.about_section_6_title') }}
    </h2>
    <p style="margin-bottom:20px;line-height:1.6;color:var(--text-muted);">
        {{ __('messages.about_section_6_text') }}
    </p>
</div>

@endsection
