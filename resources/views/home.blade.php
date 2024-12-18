@extends('layout.master')

@section('title')
  Home
@endsection

@section('content')

@extends('layout.navbar')

<div class="flex flex-col items-end px-9">
    <form action="{{ route('home') }}" method="GET">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search businesses..." class="border p-2 rounded">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
    </form>

    <form action="{{ route('home') }}" method="GET">
        <select name="sort_by" onchange="this.form.submit()">
            <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Sort by Name</option>
            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Sort by Date</option>
        </select>
        <select name="order" onchange="this.form.submit()">
            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
            <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
        </select>
    </form>
</div>


<div class="grid grid-cols-4 gap-3">
    @foreach($businesses as $business)
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
        <div class="flex-1 min-w-[300px] max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <img src="{{ asset('storage/' . str_replace('public/', '', $filePath)) }}" />

            <a href="{{ route('business.show', $business->id) }}">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $business->title }}</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $business->description }}</p>
            <a href="{{ route('business.show', $business->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Read more
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
        </div>
    @endforeach
</div>


@endsection

@section('scripts')
  @if(session('successRegister'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
          Swal.fire({
              title: 'Success!',
              text: 'Registration successful!',
              icon: 'success',
              confirmButtonText: 'OK'
          });
      </script>
  @endif
@endsection
