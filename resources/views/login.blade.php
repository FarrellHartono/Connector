@extends('layout.master')

@section('title')
  Login
@endsection

@section('content')

@extends('layout.navbar')


  <div class="justify-self-center bg-gray-300 w-[400px] h-[400px] p-6 rounded-lg">
    <h2 class="text-2xl font-bold text-center mb-6">Sign In</h2>
    <form action="{{ route('loginProcess') }}" method="Post" class="max-w-sm mx-auto">
      @csrf
      <div  class="grid">
        <div class="mb-5">
          <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
          <input type="email" name = "email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="connector@gmail.com" required />
        </div>
        <div class="mb-5">
          <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
          <input type="password" name = "password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="password" required />
        </div>
        <button type="submit" class="justify-self-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        <div class="flex mt-3 justify-self-center">
          <p>Don't have an account&nbsp;</p>
          <a href="{{ route('register') }}" class="text-red-500">Register Now</a>
        </div>
      </div>
    </form>
  </div>


@endsection

@section('scripts')
  <script>
      document.addEventListener("DOMContentLoaded", function() {
        console.log("Page is ready!");
      });
  </script>

  @if(session('show_register_confirmation'))
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
          var email = "{{ session('email')}}";
          console.log(email);

          Swal.fire({
              title: 'Account Not Found',
              text: "Email for: "+email+" is not registered yet. Would you like to register?",
              icon: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes!',
              cancelButtonText: 'Cancel'
          }).then((result) => {
              if (result.isConfirmed) {
                  // Redirect to the registration page if confirmed
                  window.location.href = "{{ route('register') }}";
              }
          })
      </script>
  @endif
@endsection

