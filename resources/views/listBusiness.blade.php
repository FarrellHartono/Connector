@extends('layout.master')

@section('title')
    List Business
@endsection

@section('content')

@extends('layout.navbar')

<div class="flex flex-col gap-5 flex-grow justify-center items-center w-full">
    @if ($tot === 0)
    <p class="text-3xl font-bold px-4 whitespace-nowrap">You Currently Have No Business To Manage</p>
    <p class="text-xl font-bold px-4 whitespace-nowrap">Try Creating A Business</p>
    @else
    @if ($acc > 0)
    <div class="flex items-center w-full">
        <div class="flex-grow h-px bg-black"></div>
        <p class="text-3xl font-bold px-4 whitespace-nowrap">Accepted Business ({{ $acc }})</p>
        <div class="flex-grow h-px bg-black"></div>
    </div>
    @endif

    @foreach($businesses as $business)
    @if ($business->status === 1)
    @php
        $folderPath = $business->image_path;
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
        <div class="w-full max-w-7xl p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex">
                <img src="{{ asset('storage/' . str_replace('public/', '', $filePath)) }}" class="max-h-40 object-cover rounded mb-4 mr-4" />
                <div>
                    <a href="{{ route('manageBusiness', $business->id) }}">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $business->title }}</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Nominal : {{ $business->nominal }}</p>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $business->description }}</p>
                    <a href="{{ route('manageBusiness', $business->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Manage Business
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endif
    @endforeach
    @if ($pend > 0)
    <div class="flex items-center w-full mt-7">
        <div class="flex-grow h-px bg-black"></div>
        <p class="text-3xl font-bold px-4 whitespace-nowrap">Pending Business ({{ $pend }})</p>
        <div class="flex-grow h-px bg-black"></div>
    </div>
    @endif
    @foreach($businesses as $business)
    @if ($business->status === 0)
    @php
        $folderPath = $business->image_path;
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
        <div class="w-full max-w-7xl p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex">
                <img src="{{ asset('storage/' . str_replace('public/', '', $filePath)) }}" class="max-h-40 object-cover rounded mb-4 mr-4 brightness-50" />
                <div>
                    <a href="{{ route('manageBusiness', $business->id) }}">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $business->title }}</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Nominal : {{ $business->nominal }}</p>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $business->description }}</p>
                    <a href="{{ route('manageBusiness', $business->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Manage Business
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endif
    @endforeach
    @if ($rej > 0)
    <div class="flex items-center w-full mt-7">
        <div class="flex-grow h-px bg-black"></div>
        <p class="text-3xl font-bold px-4 whitespace-nowrap">Rejected Business ({{ $rej }})</p>
        <div class="flex-grow h-px bg-black"></div>
    </div>
    @endif
    @foreach($businesses as $business)
    @if ($business->status === 2)
    @php
        $folderPath = $business->image_path;
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
        <div class="w-full max-w-7xl p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex">
                    <img src="{{ asset('storage/' . str_replace('public/', '', $filePath)) }}" class="max-h-40 object-cover rounded mb-4 mr-4 brightness-50" />
                <div>
                    <a href="{{ route('manageBusiness', $business->id) }}">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $business->title }}</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Nominal : {{ $business->nominal }}</p>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $business->description }}</p>
                    <a href="{{ route('manageBusiness', $business->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Manage Business
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endif
    @endforeach
    @endif


    <div class="text-center my-8 w-full">
        <a href="{{ route('uploadpage') }}"
            class="inline-flex items-center justify-center w-full max-w-md px-6 py-3 text-lg font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Create Business
        </a>
    </div>
</div>

@endsection
