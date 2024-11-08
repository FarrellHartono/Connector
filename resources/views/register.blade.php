@extends('layout.master')

@section('title')
  Register
@endsection

@section('content')

@extends('layout.navbar')

  <div class="justify-self-center bg-gray-300 w-[400px] h-[700px] p-6 rounded-lg">
    <h2 class="text-2xl font-bold text-center mb-6">Sign Up</h2>
    <form action="{{ route('registerProcess') }}" method="Post" class="max-w-sm mx-auto">
      @csrf
      <div  class="grid">
        <div class="mb-5">
          <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
          <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Username" required />
        </div>

        <div class="mb-5">
          <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
          <input type="email" name = "email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="connector@gmail.com" required />
          <span id="email-error" class="text-red-500 mt-1 hidden">Email is already exists</span>
        </div>
        
        <div class="mb-5">
          <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
          <input type="password" name = "password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="password" required />
        </div>

        <div class="mb-5">
          <label for="confirmationPW" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirmation Password</label>
          <input type="password" name = "confirmationPW" id="confirmationPW" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Confirmation Password" required />
          <span id="pw-error" class="text-red-500 mt-1 hidden">Password is not the same</span>
        </div>

        <div class="mb-5">
          <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
          <input type="tel" name="phone" id="phone" title="Please enter a valid Indonesian mobile number, starting with +62 or 08." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" pattern="^(\+62|0)8\d{7,10}$" placeholder="e.g. +628123456789" required />
        </div>

        <div class="mb-5">
          <label for="birthDate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date of Birth</label>
          <input type="date" name="birthDate" id="birthDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
        </div>

        <button type="submit" class="justify-self-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-3">Submit</button>
      </div>
    </form>
  </div>


@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("Page is ready!");
    });

    // var emailInput = document.getElementById("email");
    // emailInput.addEventListener('blur', function() { // saat input email kehilangan fokus
        
    // });
    $("#confirmationPW").on("change", function(){
      console.log("tes: ", $("#password").val());
      if ($("#password").val() == $("#confirmationPW").val())
      {
        $("#pw-error").addClass('hidden');
      } else {
        $("#pw-error").removeClass('hidden');
      }
    });

    $("#email").on("change", function(){// saat input email isinya berubah
        var email = $("#email").val();
        console.log("asdasdasdasd: ", email);
        $.ajax({
            url: "{{ route('checkEmail') }}",
            method: "GET",
            data: { email: email },
            success: function(response) {
                if (response.exists) {
                  $('#email-error').removeClass('hidden');
                } else {
                  $('#email-error').addClass('hidden');
                }
            }
        });
    });
</script>
@endsection