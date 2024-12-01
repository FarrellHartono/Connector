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

    <div>

    </div>
    <!-- Hero Section -->
    <div class="relative h-screen bg-cover bg-center" style="background-image: url('https://cdn.pixabay.com/photo/2024/03/07/22/56/handshake-8619508_1280.jpg');">
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
    </div>
    <!-- Highlight Section -->
        <div class="container mx-auto px-4 h-100 py-16 text-center h-full">
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


        {{-- FAQ --}}
        <div class="py-16 text-left">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold mb-6 text-center">FAQs</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white rounded p-8 drop-shadow" data-aos="fade-right">
                        <h3 class="font-bold mb-2">What is Connector?</h3>
                        <p class="text-gray-600">Connector is a platform that connects businesses with potential investors to help ideas flourish.</p>
                    </div>
                    <div class="bg-white rounded p-8 drop-shadow" data-aos="fade-right">
                        <h3 class="font-bold mb-2">How do I find investors?</h3>
                        <p class="text-gray-600">Create a detailed business profile, participate in forums, and schedule meetings with interested parties.</p>
                    </div>
                    <div class="bg-white rounded p-8 drop-shadow" data-aos="fade-left">
                        <h3 class="font-bold mb-2">Is there a fee to use Connector?</h3>
                        <p class="text-gray-600">No, We don't charge anything small commission on successful funding deals. Creating an account is free.</p>
                    </div>
                    <div class="bg-white rounded p-8 drop-shadow" data-aos="fade-left">
                        <h3 class="font-bold mb-2">How do I start funding my business?</h3>
                        <p class="text-gray-600">Sign up, create your business page, and start connecting with potential backers!</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tampilin 3 bisnis --}}
        <div class="py-16 text-center">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold mb-6">Featured Businesses</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 grid-rows-3 gap-8">

                @if(isset($businesses[0]))
                @php
                $folderPath = $businesses[0]->image_path;
                $extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                $filePath = null;
                foreach ($extensions as $extension) {
                $fullFilePath = $folderPath . '/' . 'main' . '.' . $extension;

                if (Storage::disk('public')->exists(str_replace('public/','',$fullFilePath))) {
                    $filePath = $fullFilePath;
                    break;
                }
                }
                @endphp
                <div class="bg-white shadow-lg rounded-lg p-6 col-start-1 row-start-1" data-aos="fade-right">
                    <div class="flex">
                        <img src="{{ asset('storage/' . str_replace('public/', '', $filePath)) }}" class="max-h-44 mr-2" />
                        <div>
                            <h2 class="text-xl font-bold mb-4 text-left">{{ $businesses[0]->title }}</h2>
                            <p class="text-gray-600 mb-4 text-justify">{{ $businesses[0]->description }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Middle Right -->
                @if(isset($businesses[1]))
                @php
                $folderPath = $businesses[1]->image_path;
                $extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                $filePath = null;
                foreach ($extensions as $extension) {
                $fullFilePath = $folderPath . '/' . 'main' . '.' . $extension;

                if (Storage::disk('public')->exists(str_replace('public/','',$fullFilePath))) {
                    $filePath = $fullFilePath;
                    break;
                }
                }
                @endphp
                    <div class="bg-white shadow-lg rounded-lg p-6 col-start-2 row-start-2" data-aos="fade-left">
                        <div class="flex">
                            <img src="{{ asset('storage/' . str_replace('public/', '', $filePath)) }}" class="max-h-44 mr-2" />
                            <div>
                                <h2 class="text-xl font-bold mb-4 text-left">{{ $businesses[1]->title }}</h2>
                                <p class="text-gray-600 mb-4 text-justify">{{ $businesses[1]->description }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Bottom Left -->
                @if(isset($businesses[2]))
                @php
                $folderPath = $businesses[2]->image_path;
                $extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                $filePath = null;
                foreach ($extensions as $extension) {
                $fullFilePath = $folderPath . '/' . 'main' . '.' . $extension;

                if (Storage::disk('public')->exists(str_replace('public/','',$fullFilePath))) {
                    $filePath = $fullFilePath;
                    break;
                }
                }
                @endphp
                    <div class="bg-white shadow-lg rounded-lg p-6 col-start-1 row-start-3" data-aos="fade-right">
                        <div class="flex">
                            <img src="{{ asset('storage/' . str_replace('public/', '', $filePath)) }}" class="max-h-44 mr-2" />
                            <div>
                                <h2 class="text-xl font-bold mb-4 text-left">{{ $businesses[2]->title }}</h2>
                                <p class="text-gray-600 mb-4 text-justify">{{ $businesses[2]->description }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </div>
    @include('layout.footer')
@endsection

@section('scripts')
<script>
    AOS.init();
  </script>
@endsection
