@extends('layout.master')

@section('title')
    Upload Business Image
@endsection

@section('content')

@extends('layout.navbar')

<div class="relative flex items-center">
    <button class="absolute left-4 flex items-center bg-white border rounded-full p-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24" class="">
            <rect width="24" height="24" fill="none" />
            <path fill="currentColor" d="M19 11H7.83l4.88-4.88c.39-.39.39-1.03 0-1.42a.996.996 0 0 0-1.41 0l-6.59 6.59a.996.996 0 0 0 0 1.41l6.59 6.59a.996.996 0 1 0 1.41-1.41L7.83 13H19c.55 0 1-.45 1-1s-.45-1-1-1" />
        </svg>
    </button>
    <h1 class="mx-auto text-5xl font-bold">Create Business</h1>
</div>



<div class="flex justify-center mt-10">
    <div class="w-full">
        <form action="{{ route('business.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('title')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="file">
                    Business Image
                </label>
                <div class="appearance-none border border-dashed border-black rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="256" height="256" viewBox="0 0 512 512" class="">
                        <rect width="512" height="512" fill="none" />
                        <rect width="416" height="352" x="48" y="80" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="23" rx="48" ry="48" />
                        <circle cx="336" cy="176" r="32" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="23" />
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="23" d="m304 335.79l-90.66-90.49a32 32 0 0 0-43.87-1.3L48 352m176 80l123.34-123.34a32 32 0 0 1 43.11-2L464 368" />
                    </svg>
                    <input type="file" name="file" id="file" class="text-center" required>
                </div>
                @error('file')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div> --}}


            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6">
                <p class="block text-gray-700 text-sm font-bold mb-2">Business Image</p>
                <label for="file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="file" type="file" class="hidden" name="file[]" multiple/>
                </label>
                @error('file')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
                @foreach ($errors->get('file.*') as $messages)
                    @foreach ($messages as $message)
                    <div style="color: red;">{{ $message }}</div>
                    @endforeach
                @endforeach
            </div>


            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea name="description" id="description" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex-grow">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="startDate">
                        Start Date
                    </label>
                    <input type="date" name="startDate" id="startDate" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('startDate')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex-grow">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="endDate">
                        End Date
                    </label>
                    <input type="date" name="endDate" id="endDate" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('endDate')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nominal">
                    Nominal
                </label>
                <input type="number" name="nominal" id="nominal" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('nominal')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-center">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Create Business
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
