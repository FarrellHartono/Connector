@extends('layout.master')

@section('title')
    Business Details
@endsection

@section('content')

@extends('layout.navbar')
<link rel="stylesheet" href="{{ asset('css/calender.css') }}">

<div class="container mx-auto mt-6 p-6 rounded-lg">
<!-- Business Title and Description -->
<div class="flex justify-between items-center">
  <h1 class="text-3xl font-semibold text-gray-800">{{ $business->title }}</h1>
</div>
<p class="mt-3 text-gray-600">{{ $business->description }}</p>

  <!-- Business Image -->
  <div class="my-4">
    @if($business->image_path)
        <img class="rounded-lg w-full max-w-sm" src="{{ asset('storage/' . $business->image_path) }}" alt="Business Image">
    @endif
</div>

  <!-- Buy/Invest Button -->
  <div class="my-6">
    <h2 class="text-xl font-semibold text-gray-700">Invest in this Business</h2>
    <form action="{{ route('business.buy', $business->id) }}" method="POST" class="mt-4 flex flex-col items-start space-y-4">
        @csrf
        <label for="amount" class="block text-sm font-medium text-gray-700">Investment Amount:</label>
        <input type="number" name="amount" step="0.01" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">

        <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-md shadow-md hover:bg-blue-700">
            Buy/Invest
        </button>
    </form>
</div>

 <!-- List of Investors -->
 <div class="my-6">
  <h2 class="text-xl font-semibold text-gray-700">Investors</h2>
  <table class="min-w-full bg-white border-collapse">
      <thead class="bg-gray-50">
          <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Investor</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Invested</th>
          </tr>
      </thead>
      <tbody>
          @foreach($business->investors as $investment)
          <tr class="bg-white border-b">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $investment->user->name }}</td>
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

</div>
@endsection