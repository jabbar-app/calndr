@extends('layouts.page')

@section('title', 'Simplify Your Scheduling with Calndr')
@section('meta_description',
  'Calndr makes it easy to schedule meetings without the back-and-forth emails. Plan your
  time effortlessly and professionally.')
@section('meta_keywords', 'Calndr, Scheduling App, Appointment, Meetings, Bookings, Calendar, Productivity')
@section('meta_image', asset('assets/img/landing/hero-start.jpg'))

@section('content')
  <div class="content-grid full p-0">

    <!-- Hero Section -->
    <section
      class="min-h-screen flex flex-col items-center justify-center text-center bg-gradient-to-br from-blue-600 to-indigo-500 text-white">
      <div class="container">
        <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-up">Scheduling Made Effortless with Calndr</h1>
        <p class="text-lg md:text-xl mb-8 animate-fade-up delay-1">Eliminate the hassle of back-and-forth emails. Let
          people book time with you in a few clicks.</p>
        <a href="#start-journey"
          class="px-6 py-3 bg-white text-blue-700 font-semibold rounded-lg animate-fade-up delay-2 hover:bg-gray-100 smooth-scroll">
          Get Started Free
        </a>

        <!-- Animated Counters -->
        <div class="flex flex-wrap justify-center gap-8 mt-10">
          <div class="text-center animate-fade-up delay-2">
            <h2 class="text-3xl font-bold"><span class="counter" data-target="{{ $appointmentCount }}">0</span>+</h2>
            <p>Appointments Scheduled</p>
          </div>
          <div class="text-center animate-fade-up delay-3">
            <h2 class="text-3xl font-bold"><span class="counter" data-target="{{ $userCount }}">0</span>+</h2>
            <p>Users Trust Calndr</p>
          </div>
          <div class="text-center animate-fade-up delay-4">
            <h2 class="text-3xl font-bold"><span class="counter" data-target="{{ $teamCount }}">0</span>+</h2>
            <p>Teams Organized</p>
          </div>
        </div>
      </div>
    </section>

    <!-- What is Calndr -->
    <section id="start-journey" class="py-16 bg-white">
      <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold mb-6 animate-fade-up">Why Calndr?</h2>
        <p class="text-gray-600 max-w-2xl mx-auto animate-fade-up delay-1">
          Calndr helps you take control of your schedule. Book meetings, appointments, and events faster — saving time and
          improving productivity for individuals and teams.
        </p>

        <!-- Features -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-10">
          <div class="animate-fade-up">
            <img src="{{ asset('assets/img/icons/booking.svg') }}" alt="Booking" class="mx-auto w-16 mb-4">
            <h5 class="font-bold mb-2">Easy Scheduling</h5>
            <p class="text-gray-600">Share your availability, let others book instantly.</p>
          </div>
          <div class="animate-fade-up delay-1">
            <img src="{{ asset('assets/img/icons/integration.svg') }}" alt="Integration" class="mx-auto w-16 mb-4">
            <h5 class="font-bold mb-2">Calendar Integration</h5>
            <p class="text-gray-600">Sync with Google Calendar, Outlook, and more.</p>
          </div>
          <div class="animate-fade-up delay-2">
            <img src="{{ asset('assets/img/icons/team.svg') }}" alt="Team" class="mx-auto w-16 mb-4">
            <h5 class="font-bold mb-2">Team Collaboration</h5>
            <p class="text-gray-600">Coordinate schedules effortlessly across teams.</p>
          </div>
        </div>
      </div>
    </section>

    <div class="container mx-auto text-center my-2">
      <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2050040983829954"
        crossorigin="anonymous"></script>
      <!-- responsive -->
      <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2050040983829954" data-ad-slot="3786022839"
        data-ad-format="auto" data-full-width-responsive="true"></ins>
      <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
    </div>

    <!-- How It Works -->
    <section class="py-16 bg-gray-100">
      <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold mb-10 animate-fade-up">How Calndr Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="animate-fade-up">
            <div class="text-4xl font-bold text-blue-600 mb-2">1</div>
            <h5 class="font-bold mb-2">Set Your Availability</h5>
            <p class="text-gray-600">Define when you're free to meet or book appointments.</p>
          </div>
          <div class="animate-fade-up delay-1">
            <div class="text-4xl font-bold text-blue-600 mb-2">2</div>
            <h5 class="font-bold mb-2">Share Your Link</h5>
            <p class="text-gray-600">Send your unique booking link to clients, teams, or friends.</p>
          </div>
          <div class="animate-fade-up delay-2">
            <div class="text-4xl font-bold text-blue-600 mb-2">3</div>
            <h5 class="font-bold mb-2">Get Booked</h5>
            <p class="text-gray-600">Receive confirmed appointments directly to your calendar.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Final CTA -->
    <section class="py-16 bg-gradient-to-br from-indigo-500 to-blue-600 text-white text-center">
      <div class="container mx-auto">
        <h2 class="text-4xl font-bold mb-4 animate-fade-up">Ready to Take Control of Your Time?</h2>
        <p class="text-lg mb-6 animate-fade-up delay-1">Sign up now and simplify your scheduling with Calndr.</p>
        <a href="{{ route('register') }}"
          class="px-6 py-3 bg-white text-indigo-700 font-semibold rounded-lg animate-fade-up delay-2 hover:bg-gray-100">
          Get Started — It’s Free
        </a>
      </div>
    </section>

  </div>

  @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
  @endpush

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
          const target = +counter.getAttribute('data-target');
          let current = 0;
          const increment = target / 200;

          const updateCounter = () => {
            if (current < target) {
              current += increment;
              counter.innerText = Math.ceil(current);
              setTimeout(updateCounter, 10);
            } else {
              counter.innerText = target;
            }
          };
          updateCounter();
        });
      });
    </script>
  @endpush
@endsection
