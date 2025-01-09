@extends('layout.master')

@section('title')
Verify Email
@endsection

@section('content')
@extends('layout.navbar')
    <div class="bg-white rounded border-2 border-black p-4 shadow flex-col justify-items-center">
        <x-svg-icon name="verify-acc"/>
        <h1 class="text-3xl font-bold">Email Verification Required</h1>
        <p class="mt-3">Please check your email for a verification link.</p>
        <p>If you didn’t receive the email, you can request a new verification link below:</p>

        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary bg-blue-700 rounded-lg hover:bg-blue-800 text-white p-2 mt-3">Resend Verification Email</button>
        </form>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('message'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'success',
                title: "{{ session('message') }}",
                showConfirmButton: false,
                timer: 3000,
            });
        });
    </script>
@endif
@endsection
