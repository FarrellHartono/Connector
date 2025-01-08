@extends('layout.master')

@section('title')
    Business Details
@endsection

@section('content')
    @extends('layout.navbar')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Checkout</h1>

        <p class="mb-2">You are about to process a transaction for:</p>
        <p class="font-semibold text-lg">{{ $business->name }}</p>
        <p class="mb-4">Amount: <span class="text-green-600 font-bold">{{ number_format($amount, 2) }}</span></p>

        <form action="{{ route('business.transaction', $business->id) }}" method="POST">
            @csrf

            <input type="hidden" name="amount" value="{{ $amount }}">

            <label for="action">Choose Transaction Type:</label>
            <select name="action" id="action" required>
                <option value="invest">Invest</option>
                <option value="withdraw">Withdraw</option>
            </select>

            <label for="payment_method_id">Payment Method:</label>
            <select name="payment_method_id" id="payment_method_id" required>
                @foreach ($business->paymentMethods as $method)
                    <option value="{{ $method->id }}">{{ $method->type }} ({{ $method->details }})</option>
                @endforeach
            </select>

            <button type="submit">Confirm Transaction</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
        console.log('{{ session('error') }}')
        @if (session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection
