@extends('layout.master')

@section('title')
  Home
@endsection

@section('content')

@extends('layout.navbar')

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Pending Businesses</h1>
    @foreach ($businesses as $business)
        <div class="p-4 mb-4 bg-white shadow rounded-lg">
            <h2 class="text-xl font-semibold">{{ $business->title }}</h2>
            <div class="flex items-center justify-between">
                <p>{{ $business->description }}</p>
                <div class="flex gap-2">
                    <form action="{{ route('admin.businesses.approve', $business->id) }}" method="POST" class="inline">
                        @csrf
                        <button class="bg-green-500 text-white px-4 py-2 rounded">Approve</button>
                    </form>
                    <form action="{{ route('admin.businesses.decline', $business->id) }}" method="POST" class="inline">
                        @csrf
                        <button class="bg-red-500 text-white px-4 py-2 rounded">Decline</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Declined Businesses</h1>
    @foreach ($declinedBusinesses as $business)
        <div class="p-4 mb-4 bg-white shadow rounded-lg">
            <h2 class="text-xl font-semibold">{{ $business->title }}</h2>
            <div class="flex items-center justify-between">
                <p>{{ $business->description }}</p>
                <div class="flex gap-2">
                    <form action="{{ route('admin.businesses.approve', $business->id) }}" method="POST" class="inline">
                        @csrf
                        <button class="bg-green-500 text-white px-4 py-2 rounded">Approve</button>
                    </form>
                    <form action="{{ route('admin.businesses.delete', $business->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>


@endsection