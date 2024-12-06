@extends('layout.master')

@section('title')
    Approval Fund
@endsection

@section('content')

    @extends('layout.navbar')

    <h1>Pending Transactions for {{ $business->title }}</h1>

    {{-- Flash Messages --}}
    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($pendingTransactions->isEmpty())
        <p>No pending transactions to approve or decline.</p>
    @else
        <table class="table">
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
    @endif

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
