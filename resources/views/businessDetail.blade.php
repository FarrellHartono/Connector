@extends('layout.master')

@section('title')
    Business Details
@endsection

@section('content')
    @extends('layout.navbar')
    <link rel="stylesheet" href="{{ asset('css/calender.css') }}">

    <div class="relative flex justify-center">
        <a href="{{ route('home') }}" class="absolute left-4 flex items-center bg-white border rounded-full p-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24" class="">
                <rect width="24" height="24" fill="none" />
                <path fill="currentColor"
                    d="M19 11H7.83l4.88-4.88c.39-.39.39-1.03 0-1.42a.996.996 0 0 0-1.41 0l-6.59 6.59a.996.996 0 0 0 0 1.41l6.59 6.59a.996.996 0 1 0 1.41-1.41L7.83 13H19c.55 0 1-.45 1-1s-.45-1-1-1" />
            </svg>
        </a>
        <h1 class="text-5xl font-bold text-gray-800">{{ $business->title }}</h1>
    </div>
    <div class="container mx-auto mt-6 p-6 rounded-lg">
        <!-- Business Title and Description -->

        <div class="flex flex-col md:flex-row items-start mt-6">
            <!-- Carousel occupying half the screen -->
            <div id="default-carousel" class="bg-white relative w-full md:w-1/2 rounded-xl" data-carousel="static">
                <!-- Carousel wrapper -->
                <div class="relative h-[28rem] overflow-hidden rounded-lg">

                    @foreach ($imageFiles as $file)
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ Storage::url(ltrim($business->image_path, '/') . '/' . $file->getFilename()) }}"
                                class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 rounded-xl"
                                alt="Business Image">
                        </div>
                    @endforeach
                </div>
                <!-- Slider indicators -->
                <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                    @foreach ($imageFiles as $index => $file)
                        <button type="button" class="w-3 h-3 rounded-full"
                            aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"
                            data-carousel-slide-to="{{ $index }}"></button>
                    @endforeach
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

                <div class="flex justify-between mb-1">
                    @php
                        // Calculate the progress percentage
                        $progressPercentage = ($business->current_investment / $business->nominal) * 100;
                    @endphp

                    <span class="text-base font-medium text-black">Current Investment</span>
                    <span class="text-sm font-medium text-black">{{ number_format($progressPercentage, 2) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                    <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                </div>
                <div class="flex justify-center">
                    <span class="text-sm text-black">
                        {{ $business->nominal - $business->current_investment }} needed to reach the goal
                    </span>
                </div>

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

                @if (Auth::user()->isAdmin === 0)
                    <!-- Investment Amount -->
                    {{-- <form action="{{ route('business.transaction', $business->id) }}" method="POST" class="mt-6">
                        @csrf
                        <label for="amount" class="block text-sm font-medium text-gray-700">Investment Amount:</label>
                        <div class="flex flex-col">
                            <input type="number" name="amount" id="amount" step="1" required
                                class="flex-grow px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300
                                @error('amount') @enderror">

                            <div class="flex justify-between">
                                <button type="submit" name="action" value="invest"
                                    class="bg-blue-600 text-white font-bold py-2 px-4 rounded-md shadow-md hover:bg-blue-700">
                                    Buy/Invest
                                </button>

                                <button type="submit" name="action" value="withdraw"
                                    class="bg-red-600 text-white font-bold py-2 px-4 rounded-md shadow-md hover:bg-red-700">
                                    Withdraw
                                </button>
                            </div>
                        </div>
                        @error('amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </form> --}}

                    <form action="{{ route('business.checkout', $business->id) }}" method="GET" class="mt-6">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Investment Amount:</label>
                        <div class="flex flex-col">
                            <input type="number" name="amount" id="amount" step="1" required
                                class="flex-grow px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300
                                @error('amount') @enderror">

                            <button type="submit"
                                class="bg-blue-600 text-white font-bold py-2 px-4 rounded-md shadow-md hover:bg-blue-700">
                                Checkout
                            </button>
                        </div>
                        @error('amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </form>
                @endif
            </div>
        </div>

        <div class="container my-8 rounded-lg">
            <div class="border-4 border-black border-opacity-50 bg-gray-100 p-3 rounded-xl mb-4">
                <div class="flex flex-wrap items-center justify-between space-x-4">
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
                <div class="border-4 border-black bg-white p-3 rounded-xl mb-4">

                    <div class="flex justify-between mb-4">
                        <div class="w-2/5 p-4 rounded-lg">
                            <div class="text-2xl font-bold mb-2 text-center">Address</div>
                            <p class="text-sm md:text-lg lg:text-2xl text-center"> {{ $business->address }}</p>
                        </div>
                        <div class="w-2/5 p-4 rounded-lg">
                            <div class="text-2xl font-bold mb-2 text-center">Phone Number</div>
                            <p class="text-sm md:text-lg lg:text-2xl text-center"> {{ $business->phone_number }}</p>
                        </div>
                    </div>
                    <div class="w-full p-4 rounded-lg">
                        <div class="text-2xl font-bold mb-2 text-center">Description</div>
                        <p class="text-sm md:text-lg lg:text-xl text-center"> {{ $business->description }}</p>
                    </div>

                </div>
            </div>

            {{-- Calendar --}}
            <div id="meeting-box" style="display: none;">
                <div class="w-full border-4 bg-white  border-black p-4 rounded-xl">
                    <div id="calendar"></div>
                    <div id="calendarDescription"
                        class="flex-col content-around w-full bg-[#0370A3] h-auto rounded-md rounded-t-none shadow-lg p-4 ">
                        <div id="idMeeting" class="hidden"></div>
                        <div id="titleMeeting" class="justify-self-center font-bold text-xl "></div>
                        <div id="dateMeeting" class="justify-self-center mb-6"></div>
                        <div id="dateMeetingHidden" class="hidden"></div>
                        <div id="linkMeetingTitle" class="flex hidden">
                            <h2 class="font-bold text-xl mr-2">Meeting Link</h2>
                            <h2 class="font-semibold text-md self-center">(Click to Open)</h2>
                        </div>
                        <div id="linkMeeting" class="mb-2 hidden"></div>
                        <input type="hidden" id="linkMeetingHidden"/>
                        <h2 id="descriptionMeetingTitle" class="font-bold text-xl hidden">Description</h2>
                        <div id="descriptionMeeting"></div>
                        <div id="buttonMeetings" class="flex justify-end pr-2 pb-2 hidden">
                            <button id="registerMeeting"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded mx-2">Register</button>
                            <button id="editMeeting"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded mx-2">Edit</button>
                            <button id="deleteMeeting"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded mx-2">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Forum --}}
            <div class="flex justify-center w-full" id="forum-box" style="display: none;">
                <div class="block max-w-full p-6 border-4 border-black bg-white rounded-xl mb-4">
                    <div class="flex items-center space-x-4">
                        <div>
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">This is a Forum
                                for {{ $business->title }}</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">This tab is designed as a space for
                                users to engage in discussions, share information, or seek answers to general questions.
                                Whether you're looking to provide insights or learn more about additional topics, this is
                                the place to connect and collaborate with others.</p>
                        </div>
                    </div>

                    {{-- Create Comment --}}
                    <div class="mt-6 border-t pt-4">
                        <form action="{{ route('business.storeComment', $business->id) }}" method="POST">
                            @csrf
                            <div class="flex items-center space-x-4 mb-6">
                                <input name="content" type="text" placeholder="Write a comment (min 5 words)"
                                    class="flex-grow p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-200" />
                                <button type="submit"
                                    class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
                                    <x-svg-icon name="comment" />
                                </button>
                            </div>
                        </form>

                        {{-- Comment List --}}
                        @foreach ($business->comments as $comment)
                            <div class="flex items-start space-x-3 mb-4 pt-3 border-t">
                                <div class="flex flex-col">
                                    <h6 class="text-gray-900 dark:text-white font-semibold">{{ $comment->user->name }}
                                    </h6>
                                    <div class="flex justify-between items-start">
                                        <p id="comment-content-{{ $comment->id }}"
                                            class="text-gray-700 dark:text-gray-400 text-sm pr-2">
                                            {{ $comment->content }}
                                        </p>

                                        {{-- Edit and Delete Options --}}
                                        @if (Auth::check())
                                            <div class="flex space-x-2 edit-delete-buttons">
                                                {{-- Show Delete Icon for Admins --}}
                                                @if (Auth::id() === $comment->user_id)
                                                    <!-- Edit Button -->
                                                    <button type="button"
                                                        onclick="toggleEdit({{ $comment->id }}, true)">
                                                        <x-svg-icon name="edit-comment" />
                                                    </button>
                                                @endif

                                                {{-- Show Edit and Delete Icons for Comment Owner --}}
                                                @if (Auth::id() === $comment->user_id || Auth::user()->isAdmin === 1)
                                                    <!-- Delete Button -->
                                                    <button type="button" onclick="confirmDelete({{ $comment->id }})">
                                                        <x-svg-icon name="delete-comment" />
                                                    </button>
                                                @endif
                                            </div>
                                        @endif


                                        {{-- Hidden edit --}}
                                        <form id="edit-form-{{ $comment->id }}"
                                            action="{{ route('business.updateComment', $comment->id) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="content" value="{{ $comment->content }}"
                                                required class="border p-2 rounded">
                                            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">
                                                Save
                                            </button>
                                            <button type="button" class="bg-gray-500 text-white px-2 py-1 rounded"
                                                onclick="toggleEdit({{ $comment->id }}, false)">Cancel</button>
                                        </form>

                                        <!-- Hidden Delete Form -->
                                        <form id="delete-form-{{ $comment->id }}"
                                            action="{{ route('business.deleteComment', $comment->id) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                    </div>


                                    <!-- Reply Form -->
                                    <div class="flex flex-col w-full">
                                        <form
                                            action="{{ route('business.reply', ['business' => $business->id, 'comment' => $comment->id]) }}"
                                            method="POST" class="mt-2">
                                            @csrf
                                            <div class="flex items-start space-x-4">
                                                <input type="text" name="content" class="p-2 border rounded"
                                                    placeholder="Write a reply..." required>
                                                <button type="submit" class="py-1 rounded">
                                                    <x-svg-icon name="reply" />
                                                </button>
                                            </div>
                                        </form>
                                        <div id="replies-{{ $comment->id }}" class="mt-3 hidden">
                                            @include('partials.comment', ['comments' => $comment->replies])
                                        </div>
                                        @if ($comment->replies->count())
                                            <button class="text-blue-500 hover:underline mt-2"
                                                onclick="toggleReplies({{ $comment->id }})">
                                                View more replies
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if (auth()->id() === $business->user_id)
                <a href="{{ route('manageBusiness', ['id' => $business->id]) }}"
                    class="inline-flex items-center justify-center px-3 py-3 text-l font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Manage Business
                </a>
            @endif

            {{-- Hidden add Meeting Form --}}
            <div id="editMeetingModal"
                class="fixed inset-0 z-10 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-gray-300 w-[400px] h-auto p-6 rounded-lg">
                    <h2 class="text-2xl font-bold text-center mb-6">Edit Meeting</h2>
                    <div class="grid">
                        <div class="mb-5">
                            <label for="editMeetingDate"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
                            <input type="datetime-local" name="editMeetingDate" id="editMeetingDate"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5"
                                required />
                        </div>
                        <div class="mb-5">
                            <label for="editMeetingTitle"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                            <input type="text" name="editMeetingTitle" id="editMeetingTitle"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5"
                                required />
                        </div>
                        <div class="mb-5">
                            <label for="editMeetingDescription"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <textarea name="editMeetingDescription" id="editMeetingDescription"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required></textarea>
                        </div>
                        <div class="mb-5">
                            <div class="flex justify-start w-11/12">
                                <label for="editMeetingLink"
                                    class="block mb-2 mr-2 text-sm font-medium text-gray-900 dark:text-white h-[fit-content] self-center">Meeting Link</label>
                                <button id="generateLinkBtn"
                                    class="text-white mb-1.5 bg-blue-700 hover:bg-blue-800 font-medium rounded-md text-sm w-full sm:w-auto px-2.5 py-1 content-center self-center">Generate Link</button>
                            </div>
                            <input type="hidden" id="editMeetingLinkData"/>
                            <div class="flex justify-start w-12/12">
                                <div name="editMeetingLink" id="editMeetingLink" class="bg-gray-50 mr-2 border border-gray-300 text-gray-900 text-sm rounded-lg w-11/12 h-8 px-2.5 content-center"></div>
                                <button id="copyLink" class="w-1/12 hover:shadow-lg rounded-md text-black filter brightness-0 content-center self-center">&#128279;</button>
                            </div>
                        </div>

                        <input type="hidden" name="business_id" value="{{ $business->id }}" />
                        <button id="editMeetingSubmit"
                            class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5">Submit</button>
                    </div>
                    <div class="flex justify-center">
                        <button type="button" id="closeModalBtn" class="mt-4 text-red-500">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $meetings = $business->meetings
            ->map(function ($meeting) {
                return [
                    'title' => $meeting->title,
                    'start' => $meeting->date,
                    'meeting_link' => $meeting->meeting_link,
                    'description' => $meeting->description,
                    'idMeeting' => $meeting->id,
                ];
            })
            ->toArray();
    @endphp
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var calendar;

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
            var bisnis = @json($business);

            // Tab elements
            const descriptionBtn = document.getElementById('description-btn');
            const meetingBtn = document.getElementById('meeting-btn');
            const forumBtn = document.getElementById('forum-btn');
            const descriptionBox = document.getElementById('description-box');
            const meetingBox = document.getElementById('meeting-box');
            const forumBox = document.getElementById('forum-box');

            // Meeting Elements
            const idMeeting = document.getElementById('idMeeting');
            const titleMeeting = document.getElementById('titleMeeting');
            const dateMeeting = document.getElementById('dateMeeting');
            const dateMeetingHidden = document.getElementById('dateMeetingHidden');
            const descriptionMeeting = document.getElementById('descriptionMeeting');
            const registerMeeting = document.getElementById('registerMeeting');
            const editMeeting = document.getElementById('editMeeting');
            const editMeetingSubmit = document.getElementById('editMeetingSubmit');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const deleteMeeting = document.getElementById('deleteMeeting');
            const linkMeeting = document.getElementById('linkMeeting');
            const linkMeetingTitle = document.getElementById('linkMeetingTitle');
            const descriptionMeetingTitle = document.getElementById('descriptionMeetingTitle');
            const linkMeetingHidden = document.getElementById('linkMeetingHidden');

            // Edit Meeting Elements
            const editMeetingDate = document.getElementById('editMeetingDate');
            const editMeetingTitle = document.getElementById('editMeetingTitle');
            const editMeetingDescription = document.getElementById('editMeetingDescription');
            const editMeetingLink = document.getElementById('editMeetingLink');
            const editMeetingLinkData = document.getElementById('editMeetingLinkData');
            const generateLinkBtn = document.getElementById('generateLinkBtn');
            const copyLink = document.getElementById('copyLink');

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
                    var meetings = @json($meetings);
                    console.log("meetings: ", meetings);
                    calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        events: meetings,
                        eventClick: function(info) {
                            console.log("masih masuk");
                            console.log(info.event.extendedProps.meeting_link);
                            idMeeting.textContent = info.event.extendedProps.idMeeting;
                            titleMeeting.textContent = info.event.title;
                            dateMeeting.textContent = new Date(info.event.start).toLocaleString([], {
                                year: "numeric",
                                month: "long",
                                day: "numeric",
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: true
                            });
                            dateMeetingHidden.textContent = info.event.start;
                            linkMeeting.innerHTML = `<a class="underline" href="`+info.event.extendedProps.meeting_link+`" target="_blank">`+info.event.extendedProps.meeting_link+`</a>`
                            if (info.event.extendedProps.meeting_link == null){
                                linkMeeting.innerHTML = '-';
                            }
                            linkMeetingHidden.value = info.event.extendedProps.meeting_link;
                            descriptionMeeting.textContent = info.event.extendedProps.description;
                            titleMeeting.classList.remove("hidden");
                            dateMeeting.classList.remove("hidden");
                            descriptionMeeting.classList.remove("hidden");
                            linkMeetingTitle.classList.remove('hidden');
                            linkMeeting.classList.remove('hidden');
                            descriptionMeetingTitle.classList.remove('hidden');
                            document.getElementById('buttonMeetings').classList.remove("hidden");
                            if (new Date(info.event.start) < Date.now()) {
                                document.getElementById('registerMeeting').classList.add("hidden");

                            }

                            if ({{ auth()->id() }} == {{ $business->user_id }}) {
                                document.getElementById('registerMeeting').classList.add("hidden");
                            } else {
                                document.getElementById('editMeeting').classList.add("hidden");
                                document.getElementById('deleteMeeting').classList.add("hidden");
                            }
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
            registerMeeting.addEventListener('click', function() {
                Swal.fire({
                    title: 'Register Meeting - ' + titleMeeting.textContent,
                    text: 'Do you want to register this meeting',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Yes',
                    cancelButtonText: "No",
                }).then((result) => {
                    titleMeeting.classList.add("hidden");
                    dateMeeting.classList.add("hidden");
                    descriptionMeeting.classList.add("hidden");
                    linkMeeting.classList.add("hidden");
                    linkMeetingTitle.classList.add("hidden");
                    descriptionMeetingTitle.classList.add("hidden");

                    document.getElementById('buttonMeetings').classList.add("hidden");
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('registerMeeting') }}",
                            method: "GET",
                            data: {
                                idMeeting: idMeeting.textContent,
                                idBusiness: {{ $business->id }}
                            },
                            success: function(response) {
                                if (response.exists) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Register Meeting successful!',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Failed!',
                                        text: 'Register Meeting failed!',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            }
                        });
                    }
                });
            });
            editMeeting.addEventListener('click', function() {

                editMeetingModal.classList.remove("hidden");
                editMeetingDate.value = formatDate(dateMeetingHidden.textContent);
                editMeetingTitle.value = titleMeeting.textContent;
                editMeetingDescription.value = descriptionMeeting.textContent;
                editMeetingLink.innerHTML = `<a href="`+linkMeetingHidden.value+`" target="_blank">`+linkMeetingHidden.value+`</a>`;
                editMeetingLinkData.value = linkMeetingHidden.value;
            });

            editMeetingDate.addEventListener('change', function(){
                editMeetingLink.innerHTML = null;
                editMeetingLinkData.value = null;
            });

            copyLink.addEventListener('click', function() {
                if (editMeetingLinkData.value == null || editMeetingLinkData.value == ""){
                    Swal.fire({
                        title: 'Link Not Found!',
                        icon: 'error',
                        timer: 5000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    return false;
                }

                navigator.clipboard.writeText(editMeetingLinkData.value)
                .then(() => {
                    Swal.fire({
                        title: 'Link Copied to Clipboard!',
                        icon: 'success',
                        timer: 5000, 
                        showConfirmButton: false, 
                        toast: true, 
                        position: 'top-end' 
                    });
                })
                .catch(err => {
                    Swal.fire({
                        title: 'Failed to Copy Link, '+err+'!',
                        icon: 'error',
                        timer: 5000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                });
            });

            generateLinkBtn.addEventListener('click', async () =>{
                if ( editMeetingDate.value == null || editMeetingDate.value == "" )
                {
                    Swal.fire({
                        title: 'Please Select Meeting date first!',
                        icon: 'error',
                        timer: 5000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    return false;
                }
                if ( editMeetingDate.value == formatDate(dateMeetingHidden.textContent))
                {
                    var formattedDate = new Date(dateMeetingHidden.textContent).toLocaleString();
                    Swal.fire({
                        title: 'Meeting for '+formattedDate+' is already created!',
                        icon: 'error',
                        timer: 5000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    return false;
                }

                var startDateMeeting = new Date(editMeetingDate.value);

                var year = startDateMeeting.getFullYear();
                var month = String(startDateMeeting.getMonth() + 1).padStart(2, "0"); 
                var day = String(startDateMeeting.getDate()).padStart(2, "0");
                var hours = String(startDateMeeting.getHours()).padStart(2, "0");
                var minutes = String(startDateMeeting.getMinutes()).padStart(2, "0");
                var seconds = String(startDateMeeting.getSeconds()).padStart(2, "0");

                var startMeeting = `${year}-${month}-${day}T${hours}:${minutes}:${seconds}`;

                var endDateMeeting = new Date(editMeetingDate.value);
                endDateMeeting.setMinutes(endDateMeeting.getMinutes() + 60);
                
                
                year = endDateMeeting.getFullYear();
                month = String(endDateMeeting.getMonth() + 1).padStart(2, "0"); 
                day = String(endDateMeeting.getDate()).padStart(2, "0");
                hours = String(endDateMeeting.getHours()).padStart(2, "0");
                minutes = String(endDateMeeting.getMinutes()).padStart(2, "0");
                seconds = String(endDateMeeting.getSeconds()).padStart(2, "0");
                
                var endMeeting = `${year}-${month}-${day}T${hours}:${minutes}:${seconds}`;

                var ACCESS_TOKEN = "ya29.a0ARW5m74DMZpLu2WP_p8k3QM_7MQH_WcrcQHDoZTO67uWsa3my-w1RurhC_RzZY7pLQiOVEf3FN4dRVTL0VZWGWOelNi4ioD6fCy5xPSTnfUJjykR2nl-s5lwjc6zrNKQlY4U-gO6ozzSijlGzicIHnmQEm2CjlSlo_-2J1O3aCgYKAawSARISFQHGX2Miu0EtaK4vfa9AzPIvGiKN6g0175";
                const refreshToken  = "1//04NB2muFhI-SWCgYIARAAGAQSNwF-L9IrGDNgrW6p56yt7HP8_gLWFw8hawnq-4TWCfHfOQysA4gVAjXtx7xF2MnzSpkTaoE4zhE";
                const clientId = "55274203711-r618icujj491fsutlvefk6n27puogqbi.apps.googleusercontent.com";
                const clientSecret = "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";

                const response = await fetch("https://oauth2.googleapis.com/token", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: new URLSearchParams({
                        client_id: clientId,
                        client_secret: clientSecret,
                        refresh_token: refreshToken,
                        grant_type: "refresh_token",
                    }),
                });

                const data = await response.json();
                console.log("DA: ", data);
                ACCESS_TOKEN = data.access_token;
                console.log("DATAAAA: ", data.access_token);
                // Define the event details
                const event = {
                    summary: "Google Meet Event",
                    description: "This is a test event with a Google Meet link.",
                    start: {
                    dateTime: startMeeting, // ISO 8601 format
                    timeZone: "UTC",
                    },
                    end: {
                    dateTime: endMeeting, // ISO 8601 format
                    timeZone: "UTC",
                    },
                    conferenceData: {
                        createRequest: {
                            requestId: `${Date.now()}-${Math.floor(Math.random() * 10000)}`,
                            conferenceSolutionKey: {
                                type: "hangoutsMeet",
                            },
                        },
                    },
                    anyoneCanAddSelf: true,
                    guestsCanModify: true, 
                    guestsCanInviteOthers: true, 
                    guestsCanSeeOtherGuests: true, 
                    visibility: "public", 
                };

                // Make the API request
                try {
                    const response = await fetch("https://www.googleapis.com/calendar/v3/calendars/primary/events?conferenceDataVersion=1", {
                    method: "POST",
                    headers: {
                        "Authorization": `Bearer ${ACCESS_TOKEN}`,
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(event),
                    });

                    const data = await response.json();
                    if (response.ok) {
                        
                        console.log("data: ", data);
                        editMeetingLink.innerHTML = `<a href="${data.hangoutLink}" target="_blank">${data.hangoutLink}</a>`;
                        editMeetingLinkData.value = `${data.hangoutLink}`;
                    } else {
                        editMeetingLink.textContent = `Error: ${data.error.message}`;
                    }
                } catch (error) {
                    editMeetingLink.textContent  = "Failed to create the event.";
                }
            });

            editMeetingSubmit.addEventListener('click', function() {
                if (!editMeetingDate.value) {
                    Swal.fire({
                        text: 'Meeting date must be filled!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                } else if (new Date(editMeetingDate.value) < Date.now()) {
                    Swal.fire({
                        text: 'Meeting date must be later than today or today!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                } else if (!editMeetingTitle.value) {
                    Swal.fire({
                        text: 'Meeting title must be filled!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                } else if (!editMeetingDescription.value) {
                    Swal.fire({
                        text: 'Meeting description must be filled!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }
                titleMeeting.classList.add("hidden");
                dateMeeting.classList.add("hidden");
                descriptionMeeting.classList.add("hidden");
                linkMeeting.classList.add("hidden");
                linkMeetingTitle.classList.add("hidden");
                descriptionMeetingTitle.classList.add("hidden");
                document.getElementById('buttonMeetings').classList.add("hidden");

                $.ajax({
                    url: "{{ route('editMeeting') }}",
                    method: "GET",
                    data: {
                        idMeeting: idMeeting.textContent,
                        idBusiness: {{ $business->id }},
                        dateMeeting: editMeetingDate.value,
                        titleMeeting: editMeetingTitle.value,
                        descriptionMeeting: editMeetingDescription.value,
                        meeting_link: editMeetingLinkData.value
                    },
                    success: function(response) {
                        if (response.success == '1') {
                            refreshCalendarData();
                            Swal.fire({
                                title: 'Success!',
                                text: 'Edit Meeting successful!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    editMeetingModal.classList.add("hidden");
                                }
                            });

                        } else {
                            Swal.fire({
                                title: 'Failed!',
                                text: 'Edit Meeting failed!',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });

            closeModalBtn.addEventListener('click', function() {
                editMeetingModal.classList.add("hidden");
            });

            deleteMeeting.addEventListener('click', function() {
                Swal.fire({
                    title: 'Delete Meeting - ' + titleMeeting.textContent,
                    text: 'Are you sure you want to delete this meeting',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Yes',
                    cancelButtonText: "No",
                }).then((result) => {
                    titleMeeting.classList.add("hidden");
                    dateMeeting.classList.add("hidden");
                    descriptionMeeting.classList.add("hidden");
                    linkMeeting.classList.add("hidden");
                    linkMeetingTitle.classList.add("hidden");
                    descriptionMeetingTitle.classList.add("hidden");
                    document.getElementById('buttonMeetings').classList.add("hidden");
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('deleteMeeting') }}",
                            method: "GET",
                            data: {
                                idMeeting: idMeeting.textContent,
                                idBusiness: {{ $business->id }}
                            },
                            success: function(response) {
                                if (response.success == '1') {
                                    refreshCalendarData();
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Delete Meeting successful!',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Failed!',
                                        text: 'Delete Meeting failed!',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            }
                        });
                    }
                });
            });
        });

        //  Ini buat confirmation di buy button dan withdraw button
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        // SweetAlert logic for error
        @if (session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif

        function toggleEdit(commentId, isEditing) {
            const contentElement = document.getElementById(`comment-content-${commentId}`);
            const formElement = document.getElementById(`edit-form-${commentId}`);
            const buttonElement = document.querySelector(`#comment-content-${commentId} + .edit-delete-buttons`);
            if (isEditing) {
                contentElement.style.display = 'none';
                formElement.style.display = 'block';
                buttonElement.style.display = 'none';
            } else {
                contentElement.style.display = 'block';
                formElement.style.display = 'none';
                buttonElement.style.display = 'flex';
            }
        }
        // Buat delete reply button
        function confirmDelete(commentId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to undo this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the corresponding delete form
                    document.getElementById(`delete-form-${commentId}`).submit();
                }
            });
        }


        function toggleReplies(commentId) {
            const repliesElement = document.getElementById(`replies-${commentId}`);
            const button = repliesElement.nextElementSibling;
            if (repliesElement.style.display === 'none' || !repliesElement.style.display) {
                repliesElement.style.display = 'block';
                button.textContent = 'Hide replies';
            } else {
                repliesElement.style.display = 'none';
                button.textContent = 'View more replies';
            }
        }

        function formatDate(inputDate) {
            const date = new Date(inputDate); // Convert the input to a Date object

            // Extract date components
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');

            // Format as YYYY-MM-DDTHH:MM
            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }

        function refreshCalendarData() {
            console.log("ASDASDASD");

            $.ajax({
                url: '{{ route('getMeetingData') }}', 
                type: 'GET',
                data: {
                    idBusiness: {{ $business->id }}
                },
                success: function(meetingsData) {
                    calendar.removeAllEvents();
                    calendar.addEventSource(meetingsData.meetings);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching meetings:', error);
                    alert('Failed to refresh calendar events.');
                }
            });
        }
    </script>
@endsection
