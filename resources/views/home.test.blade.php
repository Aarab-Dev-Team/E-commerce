@extends('layouts.app')

@section('title', 'Aura Studio — Objects with intention')

@push('styles')
    @vite(['resources/css/homepage.css'])
    <style>
        /* =============================================
           HERO — Animated Sea Background
           ============================================= */
        .hero {
            position: relative;
            min-height: 92vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            background: linear-gradient(
                180deg,
                #0d2b3e 0%,
                #1a4a6b 25%,
                #1f6278 50%,
                #2a8a7a 75%,
                #3aaa8c 100%
            );
        }

        /* Sky glow */
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 50% at 50% 0%,
                rgba(255, 210, 160, 0.18) 0%,
                transparent 70%);
            z-index: 1;
        }

        /* Deep shimmer overlay */
        .hero-shimmer {
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                92deg,
                transparent 0px,
                rgba(255,255,255,0.015) 1px,
                transparent 2px,
                transparent 80px
            );
            z-index: 1;
            animation: shimmerShift 18s linear infinite;
        }

        @keyframes shimmerShift {
            0%   { transform: translateX(0); }
            100% { transform: translateX(80px); }
        }

        /* Wave layers */
        .waves-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 2;
            line-height: 0;
        }

        .wave-svg {
            display: block;
            width: 100%;
        }

        .wave-layer-1 path {
            animation: waveMove1 9s ease-in-out infinite;
            transform-origin: center bottom;
        }
        .wave-layer-2 path {
            animation: waveMove2 12s ease-in-out infinite;
            transform-origin: center bottom;
        }
        .wave-layer-3 path {
            animation: waveMove3 7s ease-in-out infinite;
            transform-origin: center bottom;
        }

        @keyframes waveMove1 {
            0%, 100% { d: path("M0,60 C150,100 350,20 500,60 C650,100 850,20 1000,60 C1150,100 1350,20 1440,60 L1440,180 L0,180 Z"); }
            50%       { d: path("M0,80 C180,40 380,110 540,70 C700,30 900,100 1060,60 C1220,20 1380,80 1440,50 L1440,180 L0,180 Z"); }
        }
        @keyframes waveMove2 {
            0%, 100% { d: path("M0,90 C200,50 400,130 600,90 C800,50 1000,130 1200,90 C1320,70 1380,100 1440,80 L1440,180 L0,180 Z"); }
            50%       { d: path("M0,60 C220,100 420,30 620,80 C820,120 1020,40 1220,80 C1340,100 1400,60 1440,90 L1440,180 L0,180 Z"); }
        }
        @keyframes waveMove3 {
            0%, 100% { d: path("M0,110 C240,70 480,150 720,110 C960,70 1200,140 1440,100 L1440,180 L0,180 Z"); }
            50%       { d: path("M0,130 C260,90 520,160 760,120 C1000,80 1240,150 1440,110 L1440,180 L0,180 Z"); }
        }

        /* Floating particles */
        .sea-particles {
            position: absolute;
            inset: 0;
            z-index: 3;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            animation: particleFloat linear infinite;
        }

        @keyframes particleFloat {
            0%   { transform: translateY(0) translateX(0) scale(1); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 0.6; }
            100% { transform: translateY(-120px) translateX(30px) scale(0.4); opacity: 0; }
        }

        /* Light rays */
        .light-rays {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 140%;
            height: 70%;
            z-index: 1;
            background: conic-gradient(
                from 260deg at 50% 0%,
                transparent 0deg,
                rgba(255,220,150,0.06) 8deg,
                transparent 16deg,
                transparent 32deg,
                rgba(255,220,150,0.04) 40deg,
                transparent 48deg,
                transparent 60deg,
                rgba(255,220,150,0.05) 68deg,
                transparent 76deg
            );
            animation: raysPulse 8s ease-in-out infinite;
        }

        @keyframes raysPulse {
            0%, 100% { opacity: 0.8; }
            50%       { opacity: 1.2; }
        }

        /* Floating fish silhouette */
        .fish-silhouette {
            position: absolute;
            z-index: 4;
            opacity: 0.12;
            animation: fishSwim 30s linear infinite;
        }

        @keyframes fishSwim {
            0%   { transform: translateX(-200px) translateY(0px); opacity: 0; }
            5%   { opacity: 0.12; }
            45%  { transform: translateX(40vw) translateY(-40px); opacity: 0.12; }
            50%  { transform: translateX(50vw) translateY(-50px) scaleX(-1); opacity: 0.10; }
            95%  { transform: translateX(calc(100vw + 200px)) translateY(20px) scaleX(-1); opacity: 0.10; }
            100% { transform: translateX(calc(100vw + 200px)) translateY(20px) scaleX(-1); opacity: 0; }
        }

        /* Hero Content */
        .hero-content {
            position: relative;
            z-index: 10;
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0 var(--gutter);
            padding-bottom: 140px;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.65);
            margin-bottom: 28px;
            opacity: 0;
            animation: heroFadeUp 0.9s ease-out 0.3s forwards;
        }

        .hero-eyebrow::before {
            content: '';
            display: inline-block;
            width: 32px;
            height: 1px;
            background: rgba(255,255,255,0.4);
        }

        .hero h1 {
            color: #fff;
            font-size: clamp(52px, 7vw, 96px);
            font-weight: 300;
            letter-spacing: -0.03em;
            line-height: 1.0;
            max-width: 700px;
            margin-bottom: 24px;
            opacity: 0;
            animation: heroFadeUp 1s ease-out 0.5s forwards;
        }

        .hero h1 em {
            font-style: italic;
            color: rgba(255,255,255,0.75);
        }

        .hero-sub {
            font-size: 17px;
            color: rgba(255, 255, 255, 0.72);
            max-width: 420px;
            line-height: 1.7;
            margin-bottom: 40px;
            font-weight: 300;
            opacity: 0;
            animation: heroFadeUp 1s ease-out 0.7s forwards;
        }

        .hero-cta-group {
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
            opacity: 0;
            animation: heroFadeUp 1s ease-out 0.9s forwards;
        }

        .btn-hero {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.35);
            color: #fff;
            font-size: 13px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            font-weight: 400;
            border-radius: 2px;
            backdrop-filter: blur(8px);
            transition: all 0.25s ease;
            cursor: pointer;
        }

        .btn-hero:hover {
            background: rgba(255,255,255,0.28);
            border-color: rgba(255,255,255,0.6);
            transform: translateY(-1px);
        }

        .btn-hero-solid {
            background: var(--accent-clay);
            border-color: var(--accent-clay);
        }

        .btn-hero-solid:hover {
            background: #b5572f;
            border-color: #b5572f;
        }

        .hero-scroll-hint {
            position: absolute;
            bottom: 48px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            opacity: 0;
            animation: heroFadeUp 1s ease-out 1.4s forwards;
        }

        .hero-scroll-hint span {
            font-size: 10px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.45);
        }

        .scroll-line {
            width: 1px;
            height: 40px;
            background: linear-gradient(to bottom, rgba(255,255,255,0.45), transparent);
            animation: scrollPulse 2s ease-in-out infinite;
        }

        @keyframes scrollPulse {
            0%, 100% { transform: scaleY(1); opacity: 0.45; }
            50%       { transform: scaleY(0.6); opacity: 0.15; }
        }

        @keyframes heroFadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* =============================================
           SCROLL REVEAL
           ============================================= */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }

        /* =============================================
           CATEGORIES SECTION — upgraded
           ============================================= */
        .categories-section {
            padding: 100px var(--gutter);
            max-width: var(--container-width);
            margin: 0 auto;
        }

        .section-label {
            font-size: 11px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--text-secondary);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            max-width: 40px;
            height: 1px;
            background: var(--border-color);
        }

        .section-heading {
            font-size: clamp(32px, 4vw, 48px);
            font-weight: 300;
            letter-spacing: -0.03em;
            color: var(--text-main);
            margin-bottom: 48px;
            max-width: 400px;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .category-card {
            border-radius: 4px;
            overflow: hidden;
            position: relative;
            aspect-ratio: 3/4;
            cursor: pointer;
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .category-card:hover {
            transform: translateY(-6px);
        }

        .category-card-inner {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 32px;
            transition: background 0.4s ease;
        }

        .category-card:hover .category-card-inner {
            filter: brightness(0.97);
        }

        .category-icon-wrap {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transition: transform 0.4s ease;
        }

        .category-card:hover .category-icon-wrap {
            transform: scale(1.08) translateY(-4px);
        }

        .category-icon-wrap svg {
            width: 100%;
            height: auto;
        }

        .category-name {
            font-size: 16px;
            font-weight: 400;
            letter-spacing: -0.01em;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .category-link-hint {
            font-size: 12px;
            color: var(--text-secondary);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            opacity: 0;
            transform: translateY(6px);
            transition: all 0.3s ease;
        }

        .category-card:hover .category-link-hint {
            opacity: 1;
            transform: translateY(0);
        }

        /* =============================================
           MARQUEE STRIP
           ============================================= */
        .marquee-strip {
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            overflow: hidden;
            padding: 16px 0;
            background: var(--surface-color);
        }

        .marquee-track {
            display: flex;
            gap: 0;
            white-space: nowrap;
            animation: marqueeScroll 30s linear infinite;
            width: max-content;
        }

        .marquee-item {
            display: inline-flex;
            align-items: center;
            gap: 20px;
            padding: 0 40px;
            font-size: 12px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--text-secondary);
        }

        .marquee-dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: var(--accent-clay);
            display: inline-block;
            flex-shrink: 0;
        }

        @keyframes marqueeScroll {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }

        /* =============================================
           TRUST SECTION — upgraded
           ============================================= */
        .trust-section {
            padding: 80px var(--gutter);
            max-width: var(--container-width);
            margin: 0 auto;
        }

        .trust-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            background: var(--border-color);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            overflow: hidden;
        }

        .trust-item {
            background: var(--surface-color);
            padding: 40px 36px;
            display: flex;
            align-items: flex-start;
            gap: 20px;
            transition: background 0.25s ease;
        }

        .trust-item:hover {
            background: #fafaf8;
        }

        .trust-icon-box {
            flex-shrink: 0;
            width: 44px;
            height: 44px;
            border: 1px solid var(--border-color);
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color 0.25s ease;
        }

        .trust-item:hover .trust-icon-box {
            border-color: var(--accent-clay);
        }

        .sketch-icon {
            width: 24px;
            height: 24px;
        }

        .trust-text h3 {
            font-size: 15px;
            font-weight: 500;
            letter-spacing: -0.01em;
            margin-bottom: 6px;
            color: var(--text-main);
        }

        .trust-text p {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* =============================================
           TESTIMONIAL — upgraded
           ============================================= */
        .testimonial-section {
            padding: 100px var(--gutter);
            text-align: center;
            background: var(--text-main);
            position: relative;
            overflow: hidden;
        }

        .testimonial-section::before {
            content: '\201C';
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 280px;
            line-height: 1;
            color: rgba(255,255,255,0.04);
            font-family: Georgia, serif;
            pointer-events: none;
        }

        .testimonial-quote {
            font-size: clamp(22px, 3.5vw, 36px);
            font-weight: 300;
            line-height: 1.4;
            letter-spacing: -0.02em;
            color: rgba(255,255,255,0.88);
            max-width: 640px;
            margin: 0 auto 24px;
            font-style: normal;
        }

        .testimonial-stars {
            display: flex;
            justify-content: center;
            gap: 4px;
            margin-bottom: 20px;
        }

        .testimonial-stars span {
            color: #D4A853;
            font-size: 16px;
        }

        .testimonial-author {
            font-size: 12px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
        }

        /* =============================================
           NEWSLETTER — upgraded
           ============================================= */
        .newsletter-section {
            padding: 100px var(--gutter);
            max-width: var(--container-width);
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .newsletter-section .newsletter-text h2 {
            font-size: clamp(28px, 3vw, 40px);
            font-weight: 300;
            letter-spacing: -0.02em;
            margin-bottom: 12px;
        }

        .newsletter-section .newsletter-text p {
            font-size: 15px;
            color: var(--text-secondary);
        }

        .newsletter-form-large {
            display: flex;
            gap: 0;
        }

        .newsletter-form-large input {
            flex: 1;
            padding: 14px 18px;
            border: 1px solid var(--border-color);
            border-right: none;
            border-radius: 2px 0 0 2px;
            background: transparent;
            font-size: 14px;
            color: var(--text-main);
            font-family: inherit;
            font-weight: 300;
            transition: border-color 0.2s ease;
        }

        .newsletter-form-large input:focus {
            outline: none;
            border-color: var(--text-secondary);
        }

        .newsletter-form-large .btn-filled {
            border-radius: 0 2px 2px 0;
            padding: 14px 24px;
            white-space: nowrap;
        }

        /* =============================================
           RESPONSIVE
           ============================================= */
        @media (max-width: 900px) {
            .categories-grid { grid-template-columns: repeat(2, 1fr); }
            .trust-grid { grid-template-columns: 1fr; }
            .newsletter-section { grid-template-columns: 1fr; gap: 32px; }
        }

        @media (max-width: 600px) {
            .hero h1 { font-size: 44px; }
            .categories-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .hero-cta-group { flex-direction: column; align-items: flex-start; }
        }
    </style>
@endpush

@section('content')

    {{-- ========== HERO SECTION ========== --}}
    <section class="hero">

        {{-- Atmospheric layers --}}
        <div class="light-rays"></div>
        <div class="hero-shimmer"></div>

        {{-- Floating particles (generated by JS) --}}
        <div class="sea-particles" id="seaParticles"></div>

        {{-- Swimming fish --}}
        <div class="fish-silhouette" style="top: 45%; left: -100px;">
            <svg width="140" height="60" viewBox="0 0 140 60" fill="white">
                <path d="M100,30 C80,10 40,5 10,30 C40,55 80,55 100,30 Z"/>
                <path d="M100,30 L130,10 L120,30 L130,50 Z"/>
                <ellipse cx="25" cy="28" rx="3" ry="3" fill="rgba(0,0,0,0.3)"/>
            </svg>
        </div>
        <div class="fish-silhouette" style="top: 62%; left: -100px; animation-delay: -14s; animation-duration: 38s;">
            <svg width="80" height="35" viewBox="0 0 80 35" fill="white" style="opacity:0.6">
                <path d="M55,17 C45,5 25,3 5,17 C25,31 45,31 55,17 Z"/>
                <path d="M55,17 L75,5 L68,17 L75,30 Z"/>
                <ellipse cx="15" cy="16" rx="2" ry="2" fill="rgba(0,0,0,0.3)"/>
            </svg>
        </div>

        {{-- Hero content --}}
        <div class="hero-content">
            <div class="hero-eyebrow">Premium catch, since 1984</div>
            <h1>Curated <em>catch</em>,<br>from the deep</h1>
            <p class="hero-sub">Premium canned tuna — sourced from the world's finest fishing grounds and packed with care.</p>
            <div class="hero-cta-group">
                <a href="{{ route('shop.catalog') }}" class="btn-hero btn-hero-solid">Explore the collection</a>
                <a href="#" class="btn-hero">Our story &rarr;</a>
            </div>
        </div>

        {{-- Animated wave layers --}}
        <div class="waves-container">
            <svg class="wave-svg wave-layer-3" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="height:120px;">
                <path d="M0,110 C240,70 480,150 720,110 C960,70 1200,140 1440,100 L1440,180 L0,180 Z" fill="rgba(245,244,240,0.15)"/>
            </svg>
            <svg class="wave-svg wave-layer-2" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="height:130px; margin-top:-60px;">
                <path d="M0,90 C200,50 400,130 600,90 C800,50 1000,130 1200,90 C1320,70 1380,100 1440,80 L1440,180 L0,180 Z" fill="rgba(245,244,240,0.35)"/>
            </svg>
            <svg class="wave-svg wave-layer-1" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="height:160px; margin-top:-80px;">
                <path d="M0,60 C150,100 350,20 500,60 C650,100 850,20 1000,60 C1150,100 1350,20 1440,60 L1440,180 L0,180 Z" fill="#F5F4F0"/>
            </svg>
        </div>

        {{-- Scroll hint --}}
        <div class="hero-scroll-hint">
            <span>Scroll</span>
            <div class="scroll-line"></div>
        </div>
    </section>

    {{-- ========== MARQUEE STRIP ========== --}}
    <div class="marquee-strip">
        <div class="marquee-track" id="marqueeTrack">
            <span class="marquee-item">Hand-selected <span class="marquee-dot"></span></span>
            <span class="marquee-item">Wild-caught <span class="marquee-dot"></span></span>
            <span class="marquee-item">Sustainable fishing <span class="marquee-dot"></span></span>
            <span class="marquee-item">No additives <span class="marquee-dot"></span></span>
            <span class="marquee-item">Cold-packed <span class="marquee-dot"></span></span>
            <span class="marquee-item">Chef-approved <span class="marquee-dot"></span></span>
            <span class="marquee-item">Ocean to table <span class="marquee-dot"></span></span>
            <span class="marquee-item">Hand-selected <span class="marquee-dot"></span></span>
            <span class="marquee-item">Wild-caught <span class="marquee-dot"></span></span>
            <span class="marquee-item">Sustainable fishing <span class="marquee-dot"></span></span>
            <span class="marquee-item">No additives <span class="marquee-dot"></span></span>
            <span class="marquee-item">Cold-packed <span class="marquee-dot"></span></span>
            <span class="marquee-item">Chef-approved <span class="marquee-dot"></span></span>
            <span class="marquee-item">Ocean to table <span class="marquee-dot"></span></span>
        </div>
    </div>

    {{-- ========== FEATURED CATEGORIES ========== --}}
    <section class="categories-section">
        <div class="reveal">
            <div class="section-label">Shop by category</div>
            <h2 class="section-heading">Discover the collection</h2>
        </div>

        <div class="categories-grid">
            @php
                $categories = [
                    [
                        'name' => 'Ceramics',
                        'slug' => 'ceramics',
                        'bg_color' => '#F3EBE1',
                        'icon' => '<svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="600.000000pt" height="327.000000pt" viewBox="0 0 600.000000 327.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,327.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"><path d="M2498 2874 c-53 -28 -73 -105 -43 -163 8 -17 34 -38 59 -51 43 -20 46 -25 70 -101 14 -44 30 -107 36 -141 26 -143 -28 -265 -144 -325 -103 -53 -226 -182 -290 -303 -48 -92 -83 -211 -97 -333 -11 -92 -10 -120 4 -209 21 -126 46 -208 92 -300 51 -101 87 -150 182 -246 l84 -85 2 -56 c2 -56 22 -96 59 -120 9 -6 61 -20 115 -31 125 -28 482 -39 628 -21 96 13 204 39 243 60 32 17 52 64 52 120 0 50 1 51 88 138 185 186 274 396 276 653 1 180 -38 328 -126 478 -48 81 -189 220 -266 261 -67 35 -112 85 -133 148 -19 58 -7 205 25 305 27 85 29 88 71 107 90 40 103 162 23 211 -32 19 -51 20 -508 20 -401 -1 -479 -3 -502 -16z"/></g></svg>'
                    ],
                    [
                        'name' => 'Glassware',
                        'slug' => 'glassware',
                        'bg_color' => '#E2EAE3',
                        'icon' => '<svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="600.000000pt" height="327.000000pt" viewBox="0 0 600.000000 327.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,327.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"><path d="M2385 2866 c-83 -27 -132 -51 -137 -68 -3 -7 30 -47 71 -88 78 -78 124 -151 156 -248 13 -41 16 -78 13 -155 -3 -89 -8 -111 -35 -169 -20 -42 -56 -94 -97 -137 -175 -186 -266 -408 -266 -647 0 -260 81 -459 267 -653 74 -77 93 -102 93 -126 0 -76 71 -130 215 -167 82 -21 112 -23 340 -23 202 1 263 4 318 18 158 39 227 92 227 171 0 40 4 47 54 90 183 156 296 396 312 660 9 157 26 212 133 435 109 229 114 240 136 327 58 235 -61 465 -275 528 -108 32 -248 14 -348 -44 -19 -12 -36 -19 -38 -18 -2 2 3 22 11 43 23 65 19 103 -14 136 -33 33 -50 34 -136 14 -135 -33 -362 -4 -536 68 -204 84 -326 98 -464 53z"/></g></svg>'
                    ],
                    [
                        'name' => 'Soft Goods',
                        'slug' => 'soft-goods',
                        'bg_color' => '#F0E2D0',
                        'icon' => '<svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="600.000000pt" height="327.000000pt" viewBox="0 0 600.000000 327.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,327.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"><path d="M2185 2881 c-16 -10 -125 -115 -241 -232 -178 -180 -214 -221 -223 -256 -8 -30 -11 -244 -9 -735 3 -662 4 -694 22 -725 11 -17 36 -41 57 -52 35 -20 49 -21 251 -19 l213 3 0 25 0 25 -220 5 c-121 4 -221 7 -223 8 -1 1 -11 17 -22 34 -19 32 -20 53 -20 716 0 612 2 685 16 707 l16 25 649 0 649 0 2 -227 3 -228 25 0 25 0 3 236 2 236 93 81 c50 44 150 130 222 191 125 106 130 110 141 89 9 -17 11 -135 9 -444 -3 -408 -3 -423 16 -440 18 -17 20 -17 34 2 12 16 14 91 15 439 0 417 0 421 -22 465 -13 25 -38 55 -57 67 l-34 23 -681 0 c-649 0 -682 -1 -711 -19z"/></g></svg>'
                    ],
                    [
                        'name' => 'Provisions',
                        'slug' => 'provisions',
                        'bg_color' => '#E8E4DC',
                        'icon' => '<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><ellipse cx="50" cy="55" rx="32" ry="22" fill="none" stroke="#1A1A18" stroke-width="2"/><rect x="18" y="33" width="64" height="10" rx="3" fill="none" stroke="#1A1A18" stroke-width="2"/><line x1="50" y1="20" x2="50" y2="33" stroke="#1A1A18" stroke-width="2"/><ellipse cx="50" cy="55" rx="20" ry="12" fill="none" stroke="#1A1A18" stroke-width="1" stroke-dasharray="3,3"/></svg>'
                    ],
                ];
            @endphp

            @foreach($categories as $index => $category)
                <a href="{{ route('shop.catalog', ['category' => $category['slug']]) }}"
                   class="category-card reveal reveal-delay-{{ $index + 1 }}">
                    <div class="category-card-inner" style="background-color: {{ $category['bg_color'] }};">
                        <div class="category-icon-wrap">
                            {!! $category['icon'] !!}
                        </div>
                        <div class="category-name">{{ $category['name'] }}</div>
                        <div class="category-link-hint">Shop &rarr;</div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ========== TRUST SECTION ========== --}}
    <section class="trust-section reveal">
        <div class="trust-grid">
            <div class="trust-item">
                <div class="trust-icon-box">
                    <svg class="sketch-icon" viewBox="0 0 48 48" stroke="var(--text-main)" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M24 6 C24 6 10 14 10 26 C10 33.7 16.3 40 24 40 C31.7 40 38 33.7 38 26 C38 14 24 6 24 6Z"/>
                        <path d="M18 26 L22 30 L30 22"/>
                    </svg>
                </div>
                <div class="trust-text">
                    <h3>Sustainably sourced</h3>
                    <p>Every catch is certified sustainable, with full traceability from ocean to can.</p>
                </div>
            </div>

            <div class="trust-item">
                <div class="trust-icon-box">
                    <svg class="sketch-icon" viewBox="0 0 48 48" stroke="var(--text-main)" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="8" y="16" width="32" height="22" rx="2"/>
                        <path d="M14 22 C14 12, 16 6, 24 6 C32 6, 34 12, 34 22"/>
                        <circle cx="24" cy="27" r="3"/>
                        <path d="M24 30 L24 34"/>
                    </svg>
                </div>
                <div class="trust-text">
                    <h3>Secure transaction</h3>
                    <p>Encrypted payment gateways keeping your personal data safe at every step.</p>
                </div>
            </div>

            <div class="trust-item">
                <div class="trust-icon-box">
                    <svg class="sketch-icon" viewBox="0 0 48 48" stroke="var(--text-main)" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="24" cy="24" r="16"/>
                        <path d="M36 24c0-6.6-5.4-12-12-12s-12 5.4-12 12 5.4 12 12 12c3.3 0 6.3-1.3 8.5-3.5"/>
                        <polyline points="26 38 32.5 31.5 26 25"/>
                    </svg>
                </div>
                <div class="trust-text">
                    <h3>Mindful returns</h3>
                    <p>30-day returns, no questions asked — because the fit matters as much as the taste.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ========== TESTIMONIAL ========== --}}
    <section class="testimonial-section">
        <div class="reveal">
            <div class="testimonial-stars">
                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
            </div>
            <blockquote class="testimonial-quote">
                "A rich, flavorful addition to my daily meals. Nothing quite compares to the quality."
            </blockquote>
            <div class="testimonial-author">&mdash; Elena M., verified buyer</div>
        </div>
    </section>

    {{-- ========== NEWSLETTER ========== --}}
    <section class="newsletter-section reveal">
        <div class="newsletter-text">
            <h2>Aura Journal</h2>
            <p>Irregular dispatches on design, craft, and slow living — delivered to your inbox when it matters.</p>
        </div>
        <form class="newsletter-form-large" onsubmit="event.preventDefault();">
            <input type="email" placeholder="Your email address" required>
            <button type="submit" class="btn-filled">Subscribe</button>
        </form>
    </section>

@endsection

@push('scripts')
<script>
(function () {
    // ── Sea particles ──
    const container = document.getElementById('seaParticles');
    if (container) {
        const count = 28;
        for (let i = 0; i < count; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            const size = Math.random() * 4 + 1.5;
            const left = Math.random() * 100;
            const bottom = Math.random() * 60;
            const duration = Math.random() * 8 + 6;
            const delay = Math.random() * -14;
            p.style.cssText = `
                width: ${size}px;
                height: ${size}px;
                left: ${left}%;
                bottom: ${bottom}%;
                animation-duration: ${duration}s;
                animation-delay: ${delay}s;
            `;
            container.appendChild(p);
        }
    }

    // ── Scroll reveal ──
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // ── Wave path animation fallback (CSS @keyframes with path() not universal) ──
    // Animate waves via JS for maximum compatibility
    const waveDefs = [
        {
            el: document.querySelector('.wave-layer-1 path'),
            paths: [
                "M0,60 C150,100 350,20 500,60 C650,100 850,20 1000,60 C1150,100 1350,20 1440,60 L1440,180 L0,180 Z",
                "M0,80 C180,40 380,110 540,70 C700,30 900,100 1060,60 C1220,20 1380,80 1440,50 L1440,180 L0,180 Z"
            ],
            duration: 9000
        },
        {
            el: document.querySelector('.wave-layer-2 path'),
            paths: [
                "M0,90 C200,50 400,130 600,90 C800,50 1000,130 1200,90 C1320,70 1380,100 1440,80 L1440,180 L0,180 Z",
                "M0,60 C220,100 420,30 620,80 C820,120 1020,40 1220,80 C1340,100 1400,60 1440,90 L1440,180 L0,180 Z"
            ],
            duration: 12000
        },
        {
            el: document.querySelector('.wave-layer-3 path'),
            paths: [
                "M0,110 C240,70 480,150 720,110 C960,70 1200,140 1440,100 L1440,180 L0,180 Z",
                "M0,130 C260,90 520,160 760,120 C1000,80 1240,150 1440,110 L1440,180 L0,180 Z"
            ],
            duration: 7000
        }
    ];

    waveDefs.forEach(({ el, paths, duration }) => {
        if (!el) return;
        let start = null;
        let forward = true;

        function lerp(a, b, t) { return a + (b - a) * t; }

        // Simple interpolation between two path strings (same structure)
        function interpPath(p1, p2, t) {
            const nums1 = p1.match(/-?\d+\.?\d*/g).map(Number);
            const nums2 = p2.match(/-?\d+\.?\d*/g).map(Number);
            let i = 0;
            return p1.replace(/-?\d+\.?\d*/g, () => {
                const v = lerp(nums1[i], nums2[i], t);
                i++;
                return Math.round(v * 10) / 10;
            });
        }

        function animate(ts) {
            if (!start) start = ts;
            const elapsed = ts - start;
            const raw = (elapsed % duration) / duration;
            const t = raw < 0.5 ? raw * 2 : (1 - raw) * 2;
            const eased = t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
            el.setAttribute('d', interpPath(paths[0], paths[1], eased));
            requestAnimationFrame(animate);
        }

        requestAnimationFrame(animate);
    });
})();
</script>
@endpush