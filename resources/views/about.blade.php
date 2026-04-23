@extends('layouts.app')

@section('title', 'About — Aura Studio')

@push('styles')
    @vite(['resources/css/about.css'])
@endpush

@section('content')
<main>
    
    <section class="intro-section container">
        <h1>A quieter way to live with objects</h1>
        <p>We believe that the things you bring into your space should offer utility, beauty, and a sense of calm. Our curation reflects a desire for a slower, more intentional lifestyle.</p>
     

        <svg  class="organic-svg intro-illustration" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 480 480"><g fill="#FB593B"><path d="M0 0v120a360 360 0 0 1 360 360h120A480 480 0 0 0 0 0Z"></path><path d="M0 240v120a120 120 0 0 1 120 120h120A240 240 0 0 0 0 240Z"></path></g></svg>
    </section>

    <section class="section-padding border-top">
        <div class="container story-grid">
            <div class="story-title">
                <h2>Our story</h2>
            </div>
            <div class="story-content">
                <p>Aura Studio was born from a collective frustration with the ephemeral nature of modern consumption. We noticed a landscape cluttered with disposable goods and disconnected manufacturing processes.</p>
                <p>Our response was to build a platform that champions permanence. We seek out artisans and small studios who dedicate their lives to mastering a single craft. Every object in our collection has been selected not just for its aesthetic, but for the story of its making.</p>
            </div>
        </div>
    </section>

    <section class="section-padding border-top">
        <div class="container">
            <h2 style="margin-bottom: 64px;">Our philosophy</h2>
            
            <div class="values-grid">
                <div class="value-item">
                    <div class="icon-wrapper">
                        <svg class="organic-svg" viewBox="0 0 64 64">
                            <path class="organic-svg-wash" d="M16,24 C16,40 24,54 32,54 C40,54 48,40 48,24 Z"></path>
                            <path d="M20,12 C20,12 44,12 44,12 C46,12 48,14 48,18 C48,34 40,52 32,52 C24,52 16,34 16,18 C16,14 18,12 20,12 Z"></path>
                            <path d="M16,18 C16,18 48,18 48,18"></path>
                        </svg>
                    </div>
                    <h4>Material honesty</h4>
                    <p>We favor raw, untreated materials that age gracefully and tell the story of their origin without artificial concealment.</p>
                </div>

                <div class="value-item">
                    <div class="icon-wrapper">
                        <svg class="organic-svg" viewBox="0 0 64 64">
                            <path class="organic-svg-wash" d="M22,14 L42,14 C38,28 26,36 22,50 L42,50 C38,36 26,28 22,14 Z"></path>
                            <path d="M20,10 L44,10"></path>
                            <path d="M20,54 L44,54"></path>
                            <path d="M24,10 C24,24 38,32 32,32 C26,32 40,40 40,54"></path>
                            <path d="M40,10 C40,24 26,32 32,32 C38,32 24,40 24,54"></path>
                        </svg>
                    </div>
                    <h4>Slow production</h4>
                    <p>True craftsmanship cannot be rushed. We respect the time it takes to create pieces that are meant to last a lifetime.</p>
                </div>

                <div class="value-item">
                    <div class="icon-wrapper">
                        <svg class="organic-svg" viewBox="0 0 64 64">
                            <path class="organic-svg-wash" d="M32,16 L48,44 L16,44 Z"></path>
                            <path d="M32,12 L50,46 L14,46 Z"></path>
                            <path d="M32,12 L32,52"></path>
                            <path d="M22,34 L42,34"></path>
                            <circle cx="32" cy="12" r="2"></circle>
                        </svg>
                    </div>
                    <h4>Intentional design</h4>
                    <p>Every line, joint, and curve serves a purpose. We reject the superfluous in favor of clarity and functional beauty.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Team Section --}}
    <section class="section-padding border-top">
        <div class="container">
            <h2>The team</h2>
            
            <div class="team-grid">
                <div class="team-card card">
                    <img src="https://avatars.githubusercontent.com/u/185629273?s=400&u=abacc8aa5cbf77d2b4b3fdf42045251b2af8c081&v=4" alt="Your Name" style="width: 100%; aspect-ratio: 4/5; object-fit: cover; border-radius: 8px; margin-bottom: 24px; border: 1px solid var(--border-color);">
                    
                    <h4>Your Name</h4>
                    <span class="role">Full Stack Developer</span>
                    <p>Designed and developed the entire e‑commerce platform using Laravel, Blade, and vanilla CSS.</p>
                    <div class="team-socials">
                        <a href="#"><i class="iconoir-github"></i></a>
                        <a href="#"><i class="iconoir-linkedin"></i></a>
                    </div>
                </div>
                {{-- Add additional team members if needed --}}
            </div>
        </div>
    </section>

    <section class="section-padding border-top">
        <div class="container story-grid">
            <div class="story-title">
                <h2>Built with</h2>
            </div>
            <div>
                <p>The architecture behind Aura Studio favors reliability and performance, utilizing industry-standard tools to deliver a seamless editorial experience.</p>
                
                <div class="tech-grid">
                    <div class="tech-pill">
                        <i class="iconoir-server"></i> Laravel Framework
                    </div>
                    <div class="tech-pill">
                        <i class="iconoir-database"></i> MySQL
                    </div>
                    <div class="tech-pill">
                        <i class="iconoir-code"></i> Blade & Vanilla JS
                    </div>
                    <div class="tech-pill">
                        <i class="iconoir-design-pencil"></i> CSS Variables
                    </div>
                    <div class="tech-pill">
                        <i class="iconoir-git-commit"></i> Git Version Control
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding border-top">
        <div class="container">
            <h2>How it works</h2>
            
            <div class="process-grid">
                <div class="process-step">
                    <span class="step-number">01 — Curation</span>
                    <h4>Products added by employees</h4>
                    <p>Our internal team sources objects from independent studios, carefully documenting their materials, origin, and story in the system.</p>
                </div>
                
                <div class="process-step">
                    <span class="step-number">02 — Review</span>
                    <h4>Admin approval</h4>
                    <p>Each item undergoes a thorough editorial review by administrators to ensure it aligns with our catalog standards before publishing.</p>
                </div>
                
                <div class="process-step">
                    <span class="step-number">03 — Acquisition</span>
                    <h4>Customers browse & order</h4>
                    <p>The final curated selection is made available on the storefront, allowing users to discover and purchase objects for their space.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section border-top">
        <div class="container">
            <h2>Ready to curate your space?</h2>
            <a href="{{ route('shop.catalog') }}" class="btn btn-primary">Explore the collection</a>
        </div>
    </section>

</main>
@endsection