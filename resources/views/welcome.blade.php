@extends('layout.master')

@section('title')
Welcome Page
@endsection

@section('content')
<style>
    #container {
        padding: 0;
    }

</style>
    {{-- navbar --}}
    <div class="fixed z-10 p-5 w-full">
        <nav class="flex justify-between">
            <p class="text-white text-center text-2xl font-bold">Connector</p>
            <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Login</a>
        </nav>
    </div>
    <!-- Hero Section -->
    <section class="relative h-screen bg-cover bg-center" style="background-image: url('https://cdn.pixabay.com/photo/2024/03/07/22/56/handshake-8619508_1280.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white px-4">
            <h1 class="text-5xl md:text-6xl font-bold mb-4">Fund Your Business</h1>
            <p class="text-lg md:text-xl max-w-2xl">
                Connecting Innovators with the Community that Believes in Them.
            </p>
            <a href="{{ route('home') }}" class="mt-8 bg-white text-black py-3 px-6 rounded-full font-semibold hover:bg-gray-200 transition">
                Explore Businesses
            </a>
        </div>
    </section>

    <!-- Highlight Section -->
    <section class="py-16 bg-gradient-to-b from-[#0370A3] to-[#A1F3CD] text-center h-full">
        <div class="container mx-auto px-4 h-100">
            <h2 class="text-3xl font-bold mb-6">Why Choose Us?</h2>
            <p class="text-gray-700 max-w-xl mx-auto mb-12">
                Connect with investors and business owners through various ways
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 h-100">
                <div class="bg-white shadow-lg p-6 rounded-lg h-30" data-aos="fade-up" data-aos-duration="1000">
                    <h3 class="text-xl font-bold mb-4">Scheduled Meeting</h3>
                    <p class="text-gray-600">Start a discussion between investors and business owners through scheduled meeting.</p>
                </div>
                <div class="bg-white shadow-lg p-6 rounded-lg h-30" data-aos="fade-up" data-aos-duration="1500">
                    <h3 class="text-xl font-bold mb-4">Forum</h3>
                    <p class="text-gray-600">Discuss concern and ideas regarding businesses through forums on the business page.</p>
                </div>
                <div class="bg-white shadow-lg p-6 rounded-lg h-30" data-aos="fade-up" data-aos-duration="2000">
                    <h3 class="text-xl font-bold mb-4">Detailed Information</h3>
                    <p class="text-gray-600">Display detailed information regarding the business.</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    AOS.init();
  </script>
@endsection
