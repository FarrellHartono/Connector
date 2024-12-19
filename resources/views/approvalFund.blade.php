@extends('layout.master')

@section('title')
    Approval Fund
@endsection

@section('content')

    @extends('layout.navbar')

    <div class="container mx-auto p-6">
        <h1>Pending Transactions for {{ $business->title }}</h1>

        @if ($pendingTransactions->isEmpty())
            <p>No pending transactions to approve or decline.</p>
        @else
            <div class="p-4 mb-4 bg-white shadow rounded-lg">
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
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>

@endsection
