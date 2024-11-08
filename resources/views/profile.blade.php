@extends('layout.master')

@section('title')
  profile
@endsection

@section('content')

@extends('layout.navbar')

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