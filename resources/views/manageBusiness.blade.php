@extends('layout.master')

@section('title')
    Manage Business
@endsection

@section('content')
@extends('layout.navbar')

<main class="p-4">
    <h1 class="text-xl font-bold mb-4">Manage Business</h1>

    <!-- Business Details Form -->
    <form>
        <div class="space-y-4">
            <input type="text" class="w-full p-2 border rounded" placeholder="Business Name" value="{{ $business->title }}" readonly />
            <input type="text" class="w-full p-2 border rounded" placeholder="Business Address" value="{{ $business->address }}" readonly />
            <div class="flex space-x-2">
                <input type="text" class="w-1/2 p-2 border rounded" placeholder="City" value="{{ $business->city }}" readonly />
                <input type="text" class="w-1/2 p-2 border rounded" placeholder="State" value="{{ $business->state }}" readonly />
            </div>
            <textarea class="w-full p-2 border rounded h-24" placeholder="Business Description" readonly>{{ $business->description }}</textarea>

            <div class="flex justify-between items-center">
                <button type="button" class="px-4 py-2 bg-teal-500 text-white rounded" id="addMeetingBtn">Add Meeting</button>
            </div>
        </div>
    </form>

{{-- Hidden add Meeting Form --}}
    <div id="addMeetingModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-gray-300 w-[400px] h-auto p-6 rounded-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Add Meeting</h2>
        <form action="{{ route('addMeeting') }}" method="POST" class="max-w-sm mx-auto">
            @csrf
            <div class="grid">
                <div class="mb-5">
                    <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
                    <input type="date" name="date" id="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required />
                </div>
                <div class="mb-5">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                    <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required />
                </div>
                <div class="mb-5">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea name="description" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required></textarea>
                </div>
                <input type="hidden" name="business_id" value="{{ $business->id }}" />
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5">Submit</button>
            </div>
        </form>
        <div class="flex justify-center">
            <button type="button" id="closeModalBtn" class="mt-4 text-red-500">Close</button>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const addMeetingBtn = document.getElementById('addMeetingBtn');
        const addMeetingModal = document.getElementById('addMeetingModal');
        const closeModalBtn = document.getElementById('closeModalBtn');

        // Buat nge show pop up add meeting
        addMeetingBtn.addEventListener('click', function(){
            addMeetingModal.classList.remove('hidden');
        });

        // Buat nge close pop up add meeting
        closeModalBtn.addEventListener('click', function(){
            addMeetingModal.classList.add('hidden');
        })

        // Misal kalau user gk click close, click diluar pop up
        window.addEventListener('click', function(event){
            if(event.target === addMeetingModal){
                addMeetingModal.classList.add('hidden');
            }
        });
    });

</script>
@endsection
