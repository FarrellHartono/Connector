@extends('layout.master')

@section('title')
    Approval Fund
@endsection

@section('content')
    @extends('layout.navbar')

    <div class="container mx-auto p-6">

        @if ($pendingTransactions->isEmpty())
            <h1 class="text-2xl font-bold mb-4">No pending transactions to approve or decline.</h1>
        @else
            <h1 class="text-2xl font-bold mb-4">Pending Transactions for {{ $business->title }}</h1>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="text-xl px-6 py-3">
                                User
                            </th>
                            <th scope="col" class="text-xl px-6 py-3">
                                Amount
                            </th>
                            <th scope="col" class="text-xl px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            @foreach ($pendingTransactions as $transaction)
                                <th scope="row"
                                    class="text-lg px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $transaction->user->name }}
                                </th>
                                <td class="text-lg px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $transaction->amount }}
                                </td>
                                <td class="text-lg px-6 py-4">
                                    <form action="{{ route('transaction.approve', $transaction->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit"
                                            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Approve</button>
                                    </form>

                                    <form action="{{ route('transaction.decline', $transaction->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Decline</button>
                                    </form>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- <div class="p-4 mb-4 bg-white shadow rounded-lg">
                <table class="table-auto">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingTransactions as $transaction)
                            <tr>
                                <td>{{ $transaction->user->name }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>
                                    <form action="{{ route('transaction.approve', $transaction->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </form>

                                    <form action="{{ route('transaction.decline', $transaction->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Decline</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> --}}
        @endif
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
