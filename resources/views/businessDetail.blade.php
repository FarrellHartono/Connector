@extends('layout.master')

@section('title')
    Business Details
@endsection

@section('content')
    @extends('layout.navbar')
    <link rel="stylesheet" href="{{ asset('css/calender.css') }}">

    <div class="container mx-auto mt-6 p-6 rounded-lg">
        <!-- Business Title and Description -->
        <div class="flex justify-center">
            <h1 class="text-3xl font-semibold text-gray-800">{{ $business->title }}</h1>
        </div>
        <p class="mt-3 text-gray-600">{{ $business->description }}</p>

        <div class="flex flex-col md:flex-row items-start mt-6">
            <!-- Carousel occupying half the screen -->
            <div class="w-full md:w-1/2 pr-4">
                <div id="indicators-carousel" class="relative w-full" data-carousel="static">
                    <!-- Carousel wrapper -->
                    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                        <!-- Item 1 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                            @if ($business->image_path)
                                <img class="rounded-lg w-full" src="{{ asset('storage/' . $business->image_path) }}"
                                    alt="Business Image">
                            @endif
                        </div>
                        <!-- Additional Items -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="/docs/images/carousel/carousel-2.svg"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                    </div>
                    <!-- Slider indicators -->
                    <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
                            data-carousel-slide-to="0"></button>
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                            data-carousel-slide-to="1"></button>
                        <!-- Add additional buttons as needed here -->
                    </div>
                    <!-- Slider controls -->
                    <button type="button"
                        class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-prev>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 1 1 5l4 4" />
                            </svg>
                            <span class="sr-only">Previous</span>
                        </span>
                    </button>
                    <button type="button"
                        class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-next>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="sr-only">Next</span>
                        </span>
                    </button>
                </div>
            </div>

            <!-- Buy/Invest Button -->
            <div class="my-6">
                <h2 class="text-xl font-semibold text-gray-700">Invest in this Business</h2>
                <form action="{{ route('business.buy', $business->id) }}" method="POST"
                    class="mt-4 flex flex-col items-start space-y-4">
                    @csrf
                    <label for="amount" class="block text-sm font-medium text-gray-700">Investment Amount:</label>
                    <input type="number" name="amount" step="0.01" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">

                    <button type="submit"
                        class="bg-blue-600 text-white font-bold py-2 px-4 rounded-md shadow-md hover:bg-blue-700">
                        Buy/Invest
                    </button>
                </form>
            </div>

            {{-- <<!-- Sorting Form -->
                <form method="GET" action="{{ route('business.show', $business->id) }}">
                    <label for="sort_by">Sort by:</label>
                    <select name="sort_by" id="sort_by">
                        <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Business Title</option>
                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Investor Name</option>
                        <option value="total_amount" {{ request('sort_by') == 'total_amount' ? 'selected' : '' }}>Total
                            Amount</option>
                    </select>

                    <label for="order">Order:</label>
                    <select name="order" id="order">
                        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>

                    <button type="submit">Sort</button>
                </form> --}}
            <form id="sortForm" method="GET" action="{{ route('business.show', $business->id) }}">
                <label for="sort_by">Sort by:</label>
                <select name="sort_by" id="sort_by" onchange="submitSortForm()">
                    <option value="name" {{ $sortBy === 'name' ? 'selected' : '' }}>Investor Name</option>
                    <option value="amount" {{ $sortBy === 'amount' ? 'selected' : '' }}>Amount</option>
                </select>

                <label for="order">Order:</label>
                <select name="order" id="order" onchange="submitSortForm()">
                    <option value="asc" {{ $sortOrder === 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ $sortOrder === 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </form>
            <!-- List of Investors -->
            <div class="my-6">
                <h2 class="text-xl font-semibold text-gray-700">Investors</h2>
                <table class="min-w-full bg-white border-collapse">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Investor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount Invested
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($investments as $investment)
                            <tr class="bg-white border-b">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $investment->investor_name }} <!-- Use the aliased name -->
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $investment->total_investment > 0 ? $investment->total_investment : $investment->amount }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- List Meeting for this business --}}
        <div class="container mx-auto my-8 p-6 rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700">Meetings</h2>
            <div class="calendar-container">
                @include('components.calendar')
            </div>
        </div>

        <a href="{{ route('manageBusiness', ['id' => $business->id]) }}" class="btn btn-primary">Manage Business</a>
        
        <script>
            function submitSortForm() {
                document.getElementById('sortForm').submit();
            }
        </script>
        
    @endsection
