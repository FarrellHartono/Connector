@extends('layout.master')

@section('title')
  Register
@endsection

@section('content')

@extends('layout.navbar')

  <div class="justify-self-center bg-gray-300 w-[400px]  p-6 rounded-lg h-auto">
    <h2 class="text-2xl font-bold text-center mb-6">Sign Up</h2>
    <form action="{{ route('registerProcess') }}" method="Post" class="max-w-sm mx-auto" id="registerForm">
      @csrf
      <div  class="flex flex-col">
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
          <label for="confirmation_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirmation Password</label>
          <input type="password" name = "confirmation_password" id="confirmation_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Confirmation Password" required />
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

        <button type="submit" class="justify-self-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-3">Register</button>
      </div>
    </form>
  </div>


@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>
    $.validator.addMethod(
        "adult",
        function (value, element) {
            const today = new Date();
            const birthDate = new Date(value);
            const age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            return (
                age > 18 || (age === 18 && m >= 0 && today.getDate() >= birthDate.getDate())
            );
        },
        "You must be at least 18 years old."
    );

    $.validator.addMethod(
         "validPhone",
         function (value, element) {
             const phoneRegex = /^(08\d{8,10}|\+62\d{9,11})$/;
             return this.optional(element) || phoneRegex.test(value);
         },
         "Please enter a valid phone number starting with 08 or +62 and having 10-12 digits (excluding +)."
    );

        $("#registerForm").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255,
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 255,
                    remote: {
                        url: "/checkEmail",
                        type: "GET",
                        data: {
                            email: function () {
                                return $("#email").val();
                            },
                        },
                    },
                },
                password: {
                    required: true,
                    minlength: 6,
                },
                confirmation_password: {
                    required: true,
                    equalTo: "#password",
                },
                phone: {
                    required: true,
                    validPhone: true,
                },
                birthDate: {
                    required: true,
                    date: true,
                    adult: true,
                },
            },
            messages: {
                name: {
                    required: "Name is required.",
                    maxlength: "Name cannot exceed 255 characters.",
                },
                email: {
                    required: "Email is required.",
                    email: "Please enter a valid email address.",
                    maxlength: "Email cannot exceed 255 characters.",
                    remote: "This email is already registered.",
                },
                password: {
                    required: "Password is required.",
                    minlength: "Password must be at least 6 characters long.",
                },
                confirmation_password: {
                    required: "Password confirmation is required.",
                    equalTo: "Passwords do not match.",
                },
                phone: {
                    required: "Phone Number is required.",
                    validPhone: "Phone number must start with 08 or +62 and have 10-12 digits (excluding +).",
                },
                birthDate: {
                    required: "Birth date is required.",
                    date: "Please enter a valid date.",
                    adult: "You must be at least 18 years old.",
                },
            },
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            errorPlacement: function (error, element) {
                Swal.fire({
                    icon: "error",
                    title: "Validation Error",
                    text: error.text(),
                });
            },
            submitHandler: function (form) {
                form.submit();
            },
        });
</script>
@endsection
