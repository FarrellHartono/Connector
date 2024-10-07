@extends('layout.master')

@section('title')
    Business Details
@endsection

@section('content')

@extends('layout.navbar')

<h1>{{ $business->title }}</h1>
  <p>{{ $business->description }}</p>

  <!-- Business Image -->
  @if($business->image_path)
    <img src="{{ asset('storage/' . $business->image_path) }}" alt="Business Image">
  @endif

  <!-- Buy/Invest Button -->
  <form action="{{ route('business.buy', $business->id) }}" method="POST">
    @csrf
    <label for="amount">Investment Amount:</label>
    <input type="number" name="amount" step="0.01" required>
    <button type="submit">Buy/Invest</button>
  </form>

  <!-- List of Investors -->
  <h2>Investors</h2>
  <ul>
    @foreach($business->investors as $investment)
      <li>{{ $investment->user->name }} - Invested: {{ $investment->total_investment > 0 ? $investment->total_investment : $investment->amount }}</li>
    @endforeach
  </ul>

@endsection