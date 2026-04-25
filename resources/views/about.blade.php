@extends('layouts.app')

@section('title', 'About — Aura Studio')

@push('styles')
    @vite(['resources/css/about.css'])
@endpush

@section('content')
<main>
    
    <section class="intro-section container">
        <h1>Building a mindful e‑commerce experience</h1>
        <p>This platform was created as part of our final year internship project. It reflects our commitment to clean design, robust architecture, and a seamless user journey — from product discovery to order fulfillment.</p>
        
 
        <svg class="organic-svg intro-illustration" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 480 480"><g fill="#FB593B"><path d="M0 0v120a360 360 0 0 1 360 360h120A480 480 0 0 0 0 0Z"></path><path d="M0 240v120a120 120 0 0 1 120 120h120A240 240 0 0 0 0 240Z"></path></g></svg>
    </section>

    <section class="section-padding border-top">
        <div class="container story-grid">
            <div class="story-title">
                <h2>Our project</h2>
            </div>
            <div class="story-content">
                <p>Aura Studio began as an internship assignment at ISTA. The goal was to design and develop a fully functional e‑commerce application using modern web technologies while applying software engineering best practices.</p>
                <p>Over the course of several months, we moved from requirements analysis and UML modeling to database design, backend implementation with Laravel, and frontend integration with Blade templates. Every feature — from the catalog to the admin panel — was built with the intent to create a real‑world, production‑ready platform.</p>
            </div>
        </div>
    </section>

    <section class="section-padding border-top">
        <div class="container">
            <h2 style="margin-bottom: 64px;">Our core principles</h2>
            
            <div class="values-grid">
                <div class="value-item">
                    <div class="icon-wrapper">
                  

                        <svg class="organic-svg" xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="0 0 512 512"><path fill="#E4431B" fill-opacity=".5" d="M133.5 332c0 85 .1 119.7.2 77.3.2-42.5.2-112.1 0-154.5-.1-42.5-.2-7.8-.2 77.2m64 13c0 77.8.1 109.7.2 70.7.2-38.9.2-102.5 0-141.5-.1-38.9-.2-7-.2 70.8m90 0c0 77.8.1 109.7.2 70.7.2-38.9.2-102.5 0-141.5-.1-38.9-.2-7-.2 70.8"/><path fill="#E4431B" d="M125 .6C99.2 2.5 77.8 12.2 59.9 29.9 46.3 43.6 37 61.4 32.9 81.5c-1.7 8.6-1.5 26.7.5 34.8 5.9 25 23.4 45.9 46.7 55.8 7.6 3.3 20.8 6.9 25.2 6.9h2.7v308h-8c-12.3 0-17 3.5-17 12.4 0 3.8.5 5.1 3.4 7.9 2.2 2.2 4.7 3.6 7.2 4 5.1.9 318.7.9 323.7 0 4.7-.7 9.4-5.2 10.2-9.6.4-2.1 0-4.9-1-7.4-2.2-5.5-6-7.3-15.9-7.3H403V179h3.3c4.7 0 17.6-3.5 25.6-6.9 23.3-9.9 40.8-30.8 46.7-55.8 2-8.1 2.2-26.2.5-34.8-4.1-20.1-13.4-37.9-27-51.6C437.6 15.5 421.5 6.8 401 2.2 394.2.7 380.6.6 261.5.4c-72.6 0-134 .1-136.5.2m275.7 26.7c14.6 3.9 27.3 12.1 37.6 24.1 18 21.2 22.6 49.8 11.5 72.3-6.7 13.8-22.8 26.3-37.5 29.3-9.3 2-22.7.9-29.8-2.3-8.1-3.7-17.5-13.1-21.2-21.1-2.5-5.5-2.8-7.1-2.8-17.1 0-12.7 1.2-16 8.7-23.2 6-5.8 12.6-8.6 20.9-8.7 5.7 0 7.4.4 11.5 3 6.5 4 10.2 9.5 11.4 16.9 1.5 9.3 2.6 11.2 7.6 13.1 5.8 2.2 11.3.8 14.6-3.9 6.1-8.6-.8-31-12.9-41.6-10.4-9.2-20-12.5-34.2-11.9-15.6.8-27.8 6.3-38.6 17.6-4.9 5.1-12 18.4-13.1 24.4l-.6 3.8H178.2l-.6-3.8c-1.1-6-8.2-19.3-13.1-24.4-6.2-6.4-15-12.2-22.6-14.9-8.6-3-23.5-3.7-31.1-1.5-19.5 5.6-33.6 23.3-34.1 42.8-.2 7.9 2.3 12.1 8.3 13.9 3.3 1 4.7.9 8.4-.5 5-1.9 6.1-3.8 7.6-13.1 1.2-7.4 4.9-12.9 11.4-16.9 12.1-7.5 31-.7 38.9 13.9 1.9 3.4 2.2 5.6 2.2 15 0 10-.3 11.6-2.8 17.1-3.7 8-13.1 17.4-21.2 21.1-7.1 3.2-20.5 4.3-29.8 2.3-14.7-3-30.8-15.5-37.5-29.3-11.1-22.5-6.5-51.1 11.5-72.3C86.5 36.5 101.5 28.2 120 26c3.6-.4 66.8-.7 140.5-.6 122.1.2 134.6.3 140.2 1.9m-65.3 103c.9 5 7.8 18.1 12.7 24 5.9 7.2 14.6 14 23 18l6.9 3.2V487h-65l-.2-143.3c-.2-116-.5-143.6-1.6-145.5-1.8-3.1-7-6.2-10.5-6.2-1.6 0-4.3.7-6.1 1.5-6.6 3.1-6.1-8.4-6.4 149.7L288 487h-65l-.1-141.8c0-107-.3-142.5-1.2-145.2-1.4-4.1-6.8-8-10.9-8-1.7 0-4.4.7-6.2 1.5-6.6 3.1-6.1-8.4-6.4 149.8L198 487h-65V176.1l7.4-3.5c9-4.3 17.6-11 23.5-18.3 4.9-5.9 11.8-19 12.7-24l.6-3.3h157.6z"/><path fill="#E4431B" fill-opacity=".74" d="M192.3 25.7c35 .2 92.4.2 127.5 0 35-.1 6.3-.2-63.8-.2s-98.8.1-63.7.2M377 332v154l-32.2.3-32.3.2 32.8.3 32.7.2V332.5c0-85-.2-154.5-.5-154.5s-.5 69.3-.5 154M97.7 486.7c1.8.2 5 .2 7 0 2.1-.2.7-.4-3.2-.4-3.8 0-5.5.2-3.8.4m51.6 0c9.3.2 24.1.2 33 0 8.9-.1 1.4-.3-16.8-.3-18.1 0-25.4.2-16.2.3m90 0c9.3.2 24.1.2 33 0 8.9-.1 1.4-.3-16.8-.3-18.1 0-25.4.2-16.2.3m166.4 0c1.8.2 5 .2 7 0 2.1-.2.7-.4-3.2-.4-3.8 0-5.5.2-3.8.4"/><path fill="#E4431B" fill-opacity=".25" d="M107.5 333c0 84.4.1 119 .2 76.8.2-42.3.2-111.3 0-153.5-.1-42.3-.2-7.7-.2 76.7m116 12c0 77.8.1 109.7.2 70.7.2-38.9.2-102.5 0-141.5-.1-38.9-.2-7-.2 70.8"/><path fill="#E4431B" fill-opacity=".62" d="M217.3 101.7c21.3.2 56.1.2 77.5 0 21.3-.1 3.8-.2-38.8-.2s-60.1.1-38.7.2"/><path fill="#E4430D" fill-opacity=".03" d="M216.8 127.7c21.5.2 56.9.2 78.5 0 21.5-.1 3.9-.2-39.3-.2s-60.8.1-39.2.2"/></svg>
                    </div>
                    <h4>Clean architecture</h4>
                    <p>We structured the codebase using MVC, services, and policies to ensure maintainability and scalability.</p>
                </div>

                <div class="value-item">
                    <div class="icon-wrapper">
                  

                        <svg class="organic-svg"   xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="0 0 512 512"><path fill="#E4431B" fill-opacity=".74" d="m216.4 243.2-1.9 2.3 2.3-1.9c2.1-1.8 2.7-2.6 1.9-2.6-.2 0-1.2 1-2.3 2.2"/><path fill="#E4431B" fill-opacity=".33" d="M275.5 248c3.3 3.3 6.2 6 6.4 6 .3 0-2.1-2.7-5.4-6s-6.2-6-6.4-6c-.3 0 2.1 2.7 5.4 6m-96.6 189.7c-1.3 1.6-1.2 1.7.4.4s2.1-2.1 1.3-2.1c-.2 0-1 .8-1.7 1.7"/><path fill="#E4431B" fill-opacity=".5" d="m273.9 321.7-2.4 2.8 2.8-2.4c2.5-2.3 3.2-3.1 2.4-3.1-.2 0-1.4 1.2-2.8 2.7"/><g fill="#E4431B" stroke-width="0"><path d="M416.5 39.9c-5.3 3.3-12.1 10.8-80.9 89.4-11 12.5-20.2 22.7-20.5 22.7-.4 0-3.5-3.9-7.1-8.6-21.5-28.5-58.1-50.2-97.5-57.6-10.1-1.9-15.4-2.2-34-2.3-20.7 0-22.2.2-26.1 2.2-4.1 2.2-4.8 3.1-6.5 8.8-1.1 3.7 2 10.6 5.6 12.5 1.9 1 8.5 1.4 26.3 1.5 20.9 0 24.9.3 34.2 2.4 35.8 7.9 64.9 26.7 83.4 53.9l4.9 7.1-8.5 9.8c-4.7 5.4-15.8 18.1-24.6 28.2l-16 18.4-7.4 1.9c-14 3.5-23.4 9.8-30.7 20.7-4.9 7.2-7.9 15-13.6 34.5-6.9 23.9-10.6 31.7-20.2 42.8-2.2 2.5-4.3 5.8-4.7 7.3-1 3.8 1 9 4.5 12 2.9 2.4 3.7 2.5 14.7 2.5 27.5 0 53.1-7.2 71.8-20.1 17.1-11.9 26.4-27.1 31.8-52.1.5-2.1 13-13.6 49.4-45.5 117.9-103.4 135.7-119.3 140.9-126C492.8 97.4 496 87.8 496 76c.1-19.5-10.6-38-22-38-6.9 0-12 5.3-12 12.3 0 2.4 1.2 5.2 3.7 8.8 7.1 10.3 8.1 18 3.6 27-3.4 6.5-4.6 7.7-91.3 84.2L312.5 228l-8.2-8.2-8.2-8.2 5.8-6.5c3.2-3.6 31.6-35.9 63.1-71.6 31.5-35.8 57.7-65.1 58.1-65.3s1.5.9 2.5 2.3c1.9 2.9 8.2 6.5 11.4 6.5 3.4 0 9.5-3.7 10.8-6.5 2.1-4.6 1.5-9.8-1.7-14.1-3.2-4.4-13.3-14.2-17.1-16.8-3.3-2.1-8.8-2-12.5.3M287 237.5l6.4 6.4-2 2.2c-1 1.2-3.6 3.5-5.7 5.2l-3.9 3-5.9-5.9c-3.2-3.2-5.9-6.1-5.9-6.4 0-.9 9.1-11 9.9-11 .3 0 3.5 2.9 7.1 6.5M269.5 281c-2 12-14.2 26.6-28.1 33.8-7.7 3.9-26.7 9.7-29.8 9-1.2-.2-1-1.3.9-5.9 1.4-3.1 4.9-13.9 8-24 3.1-10 6.7-20.8 8.1-24 3.1-6.8 8.5-12.3 13.9-14.3l4-1.4 11.8 11.7c11.4 11.2 11.8 11.7 11.2 15.1m-159-184.1c-5.7 2.6-7.7 5.3-8.3 10.9-.4 4.4-.1 5.2 2.8 8.5 5.1 5.8 12.9 6 20 .5 5.2-4.1 6.5-11 3.1-16.2-3.8-5.8-10.2-7.1-17.6-3.7"/><path d="M77.5 119.4c-5.9 2.7-20.9 20-30.1 34.8-16.1 26.1-26.9 59.8-30.5 95.3-1.4 14.5-1.1 47.6.6 61.5 6.1 48.8 23.4 90.9 50.9 123.8 11.1 13.2 26.8 25.3 41.1 31.5 14.7 6.5 18.4 7.2 35.5 7.2 17.6-.1 23.4-1.3 36.5-7.4 18.1-8.5 28.8-23.9 34-48.7 2.3-11 3.9-38.7 2.5-43-2.5-7.5-10.9-10.6-17.7-6.4-5 3-6 6.1-6.6 21-1.1 25.2-4.8 39-12.6 47.3-9.3 9.9-19.1 13.1-38.6 12.5-13.7-.5-19.4-2.1-30.9-9-8.6-5.1-24.3-20.1-32.1-30.6-17.4-23.6-30-54.6-35.9-88.7-2.9-16.7-4.1-42.7-2.8-60.1 2.7-33.7 9.1-58.6 21.5-82.8 5.2-10.3 16.9-26.8 22.7-32.1 1.8-1.7 4.5-4.8 6.1-6.9 5.6-7.6 2.7-17.2-5.9-19.6-4.5-1.2-4-1.2-7.7.4m135.1 17c-13.8 5.8-21.6 14.3-25.7 27.9-3.2 10.5-2.3 19.5 3.1 30.3 4.6 9.5 9.3 14.1 18.6 18.5 12.5 6 24.2 6 36.8.1 17.1-8 26.9-28.8 22.2-47.2-3.3-12.8-11.4-22.5-23.6-28.4-5.6-2.7-7.8-3.1-16-3.4-8.2-.2-10.3.1-15.4 2.2m19.3 22.6c3.9 1.1 8.6 5.1 10.7 9.2.8 1.5 1.4 5.1 1.4 8.1 0 10.2-8.1 17.4-18.6 16.5-3.7-.3-6.3-1.2-8.8-3.2-5.3-4-6.9-7.7-6.4-15.3.4-5.7.7-6.7 4.3-10.3 5.3-5.5 10.6-7 17.4-5"/><path d="M116.4 150c-2.3.5-6.9 2.2-10.2 3.9-21 10.6-28.9 37.2-17.3 58.1 8.7 15.6 29.8 24.4 46.6 19.5 13.8-4 21.6-10.4 27.4-22.5 3.4-7.1 3.6-8 3.6-18 0-9.7-.2-11-3.2-17.2-8.6-18.2-27.3-27.7-46.9-23.8m16.5 25.4c11 5.8 13 19.4 4.1 28.1-3.8 3.7-4.5 4-10.8 4.3-5.7.3-7.2 0-10.2-2-4.1-2.7-8-9.8-8-14.5 0-5.4 2.9-11.3 7.3-14.4 3.2-2.3 5-2.9 9.4-2.9 3 0 6.7.7 8.2 1.4m-50.6 73.1c-14.4 4-25 14-29.6 27.9-2.1 6.2-2.2 18.1-.2 25.1 1.7 5.8 8.3 15.9 13 19.7 7.9 6.6 19.8 10.3 30.3 9.5 24.3-1.8 42.2-24.4 38.2-48.1-3.2-19.5-19.1-33.9-38.5-35.1-5.4-.3-9.7 0-13.2 1m20.4 26.4c4.4 3.1 7.3 9 7.3 14.4 0 4.7-3.9 11.8-8 14.5-3 2-4.5 2.3-10.2 2-6.3-.3-7-.6-10.8-4.3-11.7-11.4-4.3-29.5 12.1-29.5 4.6 0 6.3.5 9.6 2.9m22.3 73.9c-12.4 4.7-20.4 11.5-25.1 21.7-8.7 18.6-3.4 40.7 12.6 52 20 14.3 47.1 9.3 60-11 5.2-8.1 6.7-14.2 6.3-24.9-.3-8.1-.7-10-3.7-15.9-5.5-10.9-13.9-18.1-25.7-22.1-6.2-2.1-18.4-2-24.4.2m21 25c9.3 4.5 11.8 17.8 4.8 25.8-4.1 4.6-7.7 6.4-13.3 6.4-10.7 0-19.1-9.9-17.1-20.3 2.3-12 13.9-17.4 25.6-11.9"/></g><path fill="#E4431B" fill-opacity=".83" d="M212 185.4c0 .2.8 1 1.8 1.7 1.5 1.3 1.6 1.2.3-.4s-2.1-2.1-2.1-1.3m45.5 80.6c6.6 6.6 12.2 12 12.5 12 .2 0-4.9-5.4-11.5-12s-12.2-12-12.5-12c-.2 0 4.9 5.4 11.5 12m-154.6 36.7c-1.3 1.6-1.2 1.7.4.4.9-.7 1.7-1.5 1.7-1.7 0-.8-.8-.3-2.1 1.3"/><path fill="#F2431B" fill-opacity=".16" d="M445.9 73.7c-1.3 1.6-1.2 1.7.4.4s2.1-2.1 1.3-2.1c-.2 0-1 .8-1.7 1.7M257 266.5c6.3 6.3 11.7 11.5 12 11.5.2 0-4.7-5.2-11-11.5S246.3 255 246 255c-.2 0 4.7 5.2 11 11.5"/><path fill="#E4431B" fill-opacity=".66" d="M214 368.4c0 .2.8 1 1.8 1.7 1.5 1.3 1.6 1.2.3-.4s-2.1-2.1-2.1-1.3"/><path fill="#E4431B" fill-opacity=".25" d="M155.8 109.7c.7.3 1.6.2 1.9-.1.4-.3-.2-.6-1.3-.5-1.1 0-1.4.3-.6.6"/></svg>
                    </div>
                    <h4>User‑centric design</h4>
                    <p>From the minimalist UI to the intuitive checkout flow, every detail was crafted with the end‑user in mind.</p>
                </div>

                <div class="value-item">
                    <div class="icon-wrapper">
              

                        <svg class="organic-svg"  xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="0 0 512 512"><path fill="#E4431B" d="M352 272v208h128V64H352zm-160 64v144h128V192H192zM32 384v96h128V288H32z"/></svg>
                    </div>
                    <h4>Industry best practices</h4>
                    <p>We implemented role‑based access, product approval workflows, session/cookie management, and database optimization — all aligned with real‑world standards.</p>
                </div>
            </div>
        </div>
    </section>



    <section class="section-padding border-top">
        <div class="container">
            <h2>The developers</h2>
            
            <div class="team-grid">
               <div class="team-card card">
                    <img src="/assets/aarab-abderrahmane.png" alt="Team Member 1" style="width: 100%; aspect-ratio: 4/5; object-fit: cover; border-radius: 8px; margin-bottom: 24px; border: 1px solid var(--border-color);">
                    
                    <h4>َAarab Abderrahmane</h4>
                    <span class="role">Project Architect & System Designer</span>
                    <p>Defined the project foundation, organized task distribution, designed the database structure, and established the overall design system.</p>
                    <div class="team-socials">
                        <a href="#"><i class="iconoir-github"></i></a>
                        <a href="#"><i class="iconoir-linkedin"></i></a>
                    </div>
                </div>

                 <div class="team-card card">
                    <img src="/assets/d.png" alt="Your Name" style="width: 100%; aspect-ratio: 4/5; object-fit: cover; border-radius: 8px; margin-bottom: 24px; border: 1px solid var(--border-color);">
                    
                    <h4>Oussama</h4>
                    <span class="role">Quality Assurance & Debugging</span>
                    <p>Tested system functionality, identified issues, and ensured stability by fixing bugs and validating features.</p>
                    <div class="team-socials">
                        <a href="#"><i class="iconoir-github"></i></a>
                        <a href="#"><i class="iconoir-linkedin"></i></a>
                    </div>
                </div>

                 <div class="team-card card">
                    <img src="/assets/mouad.png" alt="Your Name" style="width: 100%; aspect-ratio: 4/5; object-fit: cover; border-radius: 8px; margin-bottom: 24px; border: 1px solid var(--border-color);">
                    
                    <h4>Mouad</h4>
                        <span class="role">System Analyst & UML Designer</span>
                        <p>Created system diagrams including UML, use case, class, and activity diagrams to model the application structure and workflows.</p>
                        <div class="team-socials">
                            <a href="#"><i class="iconoir-github"></i></a>
                            <a href="#"><i class="iconoir-linkedin"></i></a>
                    </div>
                </div>

                 <div class="team-card card">
                    <img src="" alt="Your Name" style="width: 100%; aspect-ratio: 4/5; object-fit: cover; border-radius: 8px; margin-bottom: 24px; border: 1px solid var(--border-color);">
                    
                     <h4>Hajar</h4>
                        <span class="role">Presentation & Communication</span>
                        <p>Prepared and delivered the project presentation, ensuring clear communication of concepts, features, and system design.</p>
                        <div class="team-socials">
                            <a href="#"><i class="iconoir-github"></i></a>
                            <a href="#"><i class="iconoir-linkedin"></i></a>
                    </div>

                </div>

                <div class="team-card card">
                    <img src="/assets/member-5.png" alt="Team Member 5" style="width: 100%; aspect-ratio: 4/5; object-fit: cover; border-radius: 8px; margin-bottom: 24px; border: 1px solid var(--border-color);">
                    
                    <h4>Zeinb</h4>
                    <span class="role">Documentation & Internship Report</span>
                    <p>Responsible for writing and organizing the internship report, documenting the project development process and outcomes.</p>
                    <div class="team-socials">
                        <a href="#"><i class="iconoir-github"></i></a>
                        <a href="#"><i class="iconoir-linkedin"></i></a>
                    </div>
                </div>
            </div>

            
        </div>
    </section>

    <section class="section-padding border-top">
        <div class="container story-grid">
            <div class="story-title">
                <h2>Technologies used</h2>
            </div>
            <div>
                <p>The following tools and frameworks were used to bring this project to life, ensuring performance, security, and maintainability.</p>
                
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
            <h2>How the system works</h2>
            
            <div class="process-grid">
                <div class="process-step">
                    <span class="step-number">01 — Back‑office</span>
                    <h4>Employees add & manage content</h4>
                    <p>Authorized staff members can create, edit, and request deletion of products. All changes are submitted for admin approval to ensure quality control.</p>
                </div>
                
                <div class="process-step">
                    <span class="step-number">02 — Admin review</span>
                    <h4>Approval workflow</h4>
                    <p>Administrators review pending product changes, compare modifications, and either approve or reject them. Only approved products become visible to customers.</p>
                </div>
                
                <div class="process-step">
                    <span class="step-number">03 — Storefront</span>
                    <h4>Customers browse & purchase</h4>
                    <p>Visitors can explore the curated catalog, add items to their cart, place orders with a simulated payment method, and manage their profile and wishlist.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section border-top">
        <div class="container">
            <h2>Explore the full platform</h2>
            <a href="{{ route('shop.catalog') }}" class="btn btn-primary">Visit the store</a>
        </div>
    </section>

</main>
@endsection