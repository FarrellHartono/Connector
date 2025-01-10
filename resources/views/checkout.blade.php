@extends('layout.master')

@section('title')
    Business Details
@endsection

@section('content')
    @extends('layout.navbar')
    <div class="container mx-auto p-5">
        <h2 class="text-3xl font-extrabold text-gray-800 text-center lg:text-5xl">Checkout</h2>

        <!-- Responsive Layout -->
        <div class="flex flex-col lg:flex-row-reverse lg:space-x-reverse lg:space-x-10 bg-gray-200 mt-7 p-6 rounded-lg">
            <!-- Transaction Summary -->
            <div class="bg-white p-6 rounded-lg mb-5 lg:mb-0 lg:w-1/3">
                <h3 class="text-lg font-bold text-gray-800 lg:text-2xl">Transaction Summary</h3>
                <p class="font-semibold text-lg mt-3 lg:text-xl">{{ $business->title }}</p>
                <p class="mt-2 lg:text-l">Amount: <span class="text-green-600 font-bold">{{ number_format($amount, 2) }}</span></p>
                <p class="mt-2 text-sm font-thin text-teal-600">*notes please select the payment method type that you want, then transfer to the account that has been provided by the Business Owner</p>
            </div>

            <!-- Transaction Form -->
            <div class="bg-white p-6 rounded-lg flex-grow lg:w-2/3">
                <form action="{{ route('business.transaction', $business->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="amount" value="{{ $amount }}">

                    <!-- Choose Transaction Type -->
                    <div class="mb-5">
                        <label for="action" class="text-lg font-bold text-gray-800">Choose Transaction Type:</label>
                        <div
                            class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4 mt-2">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="action" value="invest" required
                                    class="text-blue-500 focus:ring focus:ring-blue-300">
                                <span class="text-gray-700">Invest</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="action" value="withdraw" required
                                    class="text-blue-500 focus:ring focus:ring-blue-300">
                                <span class="text-gray-700">Withdraw</span>
                            </label>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-5">
                        <label for="payment_method_id" class="text-lg font-bold text-gray-800">Payment Method:</label>
                        <div id="payment_method_id" class="space-y-2 mt-2">
                            @foreach ($business->paymentMethods as $method)
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="payment_method_id" value="{{ $method->id }}" required
                                        class="text-blue-500 focus:ring focus:ring-blue-300">
                                    <span class="text-gray-700">{{ $method->type }} ({{ $method->details }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                        type="submit">Confirm Transaction</button>
                </form>
            </div>
        </div>
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
