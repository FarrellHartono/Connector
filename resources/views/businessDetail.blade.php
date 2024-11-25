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
        {{-- <p class="mt-3 text-gray-600">{{ $business->description }}</p> --}}

        <div class="flex flex-col md:flex-row items-start mt-6">
            <!-- Carousel occupying half the screen -->
            <div id="default-carousel" class="relative w-full md:w-1/2" data-carousel="static">
                <!-- Carousel wrapper -->
                <div class="relative h-[28rem] overflow-hidden rounded-lg">
                    
                    @foreach ($imageFiles as $file)
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ Storage::url(ltrim($business->image_path, '/') .'/'. $file->getFilename()) }}"
                        class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" 
                        alt="Business Image">
                    </div>
                    @endforeach
                    
                    {{-- <!-- Item 1 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        @if ($business->image_path)
                            <img class="rounded-lg w-full h-full object-cover"
                                src="{{ asset('storage/assets/business/tes1234567890/1.jpg' ) }}" alt="Business Image">
                        @endif
                    </div> --}}
                </div>
                <!-- Slider indicators -->
                <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
                        data-carousel-slide-to="0"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                        data-carousel-slide-to="1"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                        data-carousel-slide-to="2"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"
                        data-carousel-slide-to="3"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5"
                        data-carousel-slide-to="4"></button>
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

            <!-- Investor List and Sorting Section (other half of the screen) -->
            <div class="w-full md:w-1/2 pl-4">

                {{-- <<!-- Sorting Form --> --}}
                <label for="sort" class="block text-sm font-medium text-gray-700">Sort Investors:</label>
                <form id="sortForm" method="GET" action="{{ route('business.show', $business->id) }}" class="mb-4">
                    <select name="sort" id="sort"
                        class="rounded-lg border border-gray-300 px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300 w-full"
                        onchange="submitSortForm()">
                        <option value="asc_name"
                            {{ request('sort') === 'name' && request('order') === 'asc' ? 'selected' : '' }}>Ascending
                            Name
                        </option>
                        <option value="desc_name"
                            {{ request('sort') === 'name' && request('order') === 'desc' ? 'selected' : '' }}>Descending
                            Name
                        </option>
                        <option value="asc_amount"
                            {{ request('sort') === 'amount' && request('order') === 'asc' ? 'selected' : '' }}>Ascending
                            Amount
                        </option>
                        <option value="desc_amount"
                            {{ request('sort') === 'amount' && request('order') === 'desc' ? 'selected' : '' }}>
                            Descending
                            Amount</option>
                    </select>
                </form>

                <!-- Investor List -->
                <h2 class="text-xl font-semibold text-gray-700 mt-4">Investors</h2>
                <div class="overflow-y-scroll max-h-48 rounded-lg shadow border border-gray-200">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100 sticky top-0">
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
                                        {{ $investment->investor_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($investment->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <!-- Investment Amount -->
                <form action="{{ route('business.buy', $business->id) }}" method="POST" class="mt-6">
                    @csrf
                    <label for="amount" class="block text-sm font-medium text-gray-700">Investment Amount:</label>
                    <input type="number" name="amount" step="1" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">

                    <button type="submit"
                        class="mt-4 bg-blue-600 text-white font-bold py-2 px-4 rounded-md shadow-md hover:bg-blue-700">
                        Buy/Invest
                    </button>
                </form>
            </div>
        </div>


        <div class="container mx-auto my-8 p-6 rounded-lg">
            <div class="border-4 border-black border-opacity-50 bg-gray-100 p-3 rounded-xl shadow-lg mb-4">
                <div class="flex justify-between space-x-4">
                    <button id="description-btn"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-2xl transition-all duration-300 hover:shadow-xl">
                        Description
                    </button>
                    <button id="meeting-btn"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-2xl transition-all duration-300 hover:shadow-xl">
                        Meeting
                    </button>
                    <button id="forum-btn"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-2xl transition-all duration-300 hover:shadow-xl">
                        Forum
                    </button>
                </div>
            </div>

            <!-- Box Sections -->
            <div id="description-box" style="display: none;">
                <p>{{ $business->description }}</p>
            </div>

            {{-- Calendar --}}
            <div id="meeting-box" style="display: none;">
                <div class="calendar-container">
                    <div id="calendar"></div>
                    <ul>
                        @foreach ($business->meetings as $meeting)
                            <li>{{ $meeting->title }} on {{ $meeting->date }} - {{ $meeting->description }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Forum --}}
            <div class="flex justify-center" id="forum-box" style="display: none;">
                <div class="block max-w-lg p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <div class="flex items-center space-x-4">
                        <img class="w-16 h-16 rounded-full" src="https://via.placeholder.com/40" alt="User avatar">
                        <div>
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Noteworthy
                                technology
                                acquisitions 2021</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise
                                technology
                                acquisitions of 2021 so far, in reverse chronological order.</p>
                        </div>
                    </div>
                    
                    {{-- Create Comment --}}
                    <div class="mt-6 border-t pt-4">
                        <form action="{{ route('business.storeComment', $business->id) }}" method="POST">
                            @csrf
                            <div class="flex items-center space-x-4 mb-6">
                                <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/40" alt="User avatar">
                                <input
                                    name="content"
                                    type="text"
                                    placeholder="Write a comment (min 5 words)"
                                    class="flex-grow p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-200"
                                />
                                <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
                                    <x-svg-icon name="comment" />
                                </button>
                            </div>
                        </form>

                        {{-- Comment List --}}
                        @foreach ($business->comments as $comment)
                            <div class="flex items-start space-x-3 mb-4 border-t">
                                <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/40" alt="User avatar">
                                <div class="flex flex-col">
                                    <h6 class="text-gray-900 dark:text-white font-semibold">{{ $comment->user->name }}</h6>
                                    <div class="flex flex-col items-start">
                                        <p class="text-gray-700 dark:text-gray-400 text-sm">
                                            {{ $comment->content }}
                                        </p>
                                        <!-- Reply Form -->
                                        <div class="flex flex-col w-full">
                                        <form action="{{ route('business.reply', ['business' => $business->id, 'comment' => $comment->id]) }}" method="POST" class="mt-2">
                                            @csrf
                                            <div class="flex items-start space-x-4">
                                                <input type="text" name="content" class="w-full p-2 border rounded" placeholder="Write a reply..." required>
                                                <button type="submit" class="bg-gray-500 text-white px-2 py-1 rounded">
                                                    <x-svg-icon name="reply" />
                                                </button>
                                            </div>
                                        </form>
                                        <!-- Display Replies Using the Partial View -->
                                            @include('partials.comment', ['comments' => $comment->replies])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <a href="{{ route('manageBusiness', ['id' => $business->id]) }}" class="btn btn-primary">Manage Business</a>

            <script>
                // ini biar nge split awalnya yg disubmit asc_name, kan gabisa, jadi split asc & name
                function submitSortForm() {
                    // Buat nge get dari dropdown
                    const sortOption = document.getElementById('sort').value;

                    // Ini nge splitnya 
                    const [order, sort] = sortOption.split('_');

                    // Buat nge set URLnya
                    const url = new URL(window.location.href);

                    // Baru di set urlnya jadi sort dan order
                    url.searchParams.set('sort', sort);
                    url.searchParams.set('order', order);

                    // Buat nge redirect urlnya jadi misah
                    window.location.href = url.toString();
                }

                document.addEventListener('DOMContentLoaded', function() {
                    // Tab elements
                    const descriptionBtn = document.getElementById('description-btn');
                    const meetingBtn = document.getElementById('meeting-btn');
                    const forumBtn = document.getElementById('forum-btn');
                    const descriptionBox = document.getElementById('description-box');
                    const meetingBox = document.getElementById('meeting-box');
                    const forumBox = document.getElementById('forum-box');

                    // Retrieve the last active tab from localStorage
                    const lastActiveTab = localStorage.getItem('activeTab') || 'description';

                    // Show the last active tab content
                    function showTab(tab) {
                        descriptionBox.style.display = 'none';
                        meetingBox.style.display = 'none';
                        forumBox.style.display = 'none';

                        if (tab === 'description') {
                            descriptionBox.style.display = 'block';
                        } else if (tab === 'meeting') {
                            meetingBox.style.display = 'block';
                            var calendarEl = document.getElementById('calendar');

                            // Create the event data directly in Blade
                            var meetings = @json($business->meetings->map(function($meeting) {
                                return [
                                        'title' => $meeting->title,
                                        'start' => $meeting->date,
                                        'description' => $meeting->description
                                    ];
                                }));

                            var calendar = new FullCalendar.Calendar(calendarEl, {
                                    initialView: 'dayGridMonth',
                                    events: meetings,
                                    eventClick: function(info) {
                                        alert('Meeting: ' + info.event.title + '\nDescription: ' + info.event.extendedProps.description);
                                    }
                                }); 

                            calendar.render();

                        } else if (tab === 'forum') {
                            forumBox.style.display = '';
                        }
                    }
                    showTab(lastActiveTab);

                    // Update active tab in localStorage and display content
                    function setActiveTab(tab) {
                        localStorage.setItem('activeTab', tab);
                        showTab(tab);
                    }

                    // Add event listeners to the tab buttons
                    descriptionBtn.addEventListener('click', function() {
                        setActiveTab('description');
                    });
                    meetingBtn.addEventListener('click', function() {
                        setActiveTab('meeting');
                    });
                    forumBtn.addEventListener('click', function() {
                        setActiveTab('forum');
                    });
                });
            </script>
        @endsection
