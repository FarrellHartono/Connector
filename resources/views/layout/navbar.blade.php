
<div id="modal" class="fixed w-screen h-full bg-black opacity-50 z-50 hidden">
</div>
<nav class="bg-white dark:bg-gray-900 w-full z-20 top-0 border-b border-gray-200 dark:border-gray-600 flex justify-evenly">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between p-4 w-full">
    <!-- <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo">
        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
    </a> -->



    <div class="relative ">
      <!-- Icon Tanggal -->
      <button id="calendar-button" class="group relative flex items-center justify-center w-12 h-12 bg-gray-200 rounded-md hover:bg-[#0370A3] ">
          <div class="group absolute inset-0 text-center w-full h-full z-30 rounded-md ">
              <div class="text-xs font-semibold bg-[#aa5f5f] rounded-t-md text-white " id="month"></div>
              <div class="text-lg font-bold group-hover:text-white" id="day"></div>
          </div>

          <div class="absolute top-0.5 left-12 z-20 transform -translate-x-6 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-300 ease-in-out">
              <span id="day-name" class=" block bg-transparent text-black rounded-md px-4 py-2 text-sm font-medium whitespace-nowrap"></span>
          </div>
      </button>

      <!-- Pop-up Kalender -->
      <div id="calendar-popup" class="hidden absolute top-20 left-20 z-10 bg-white rounded-md shadow-lg">
          <!-- <iframe src="{{ route('home') }}" class="absolute w-60 h-60"></iframe> -->
      </div>


      <!-- Day name sliding from calendar button to right -->

    </div>


    <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
    @if(Auth::check())
      Welcome, {{ Auth::user()->name }}!
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="ml-4 bg-red-500 text-white px-4 py-2 rounded">Logout</button>
      </form>

    @else
      <a href="{{ route('profile') }}" class=" bg-black text-white w-10 h-10 rounded-full mr-5"></a>

      <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded    ">Login</a>
    @endif
    </div>
    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
      <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
        <li>
          <a href="{{ route('home') }}" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500" aria-current="page">Home</a>
        </li>
        <li>
          <a href="{{ route('listBusiness') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">My Business</a>
        </li>
        <li>
          <a href="{{ route('profile') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Profile</a>
        </li>
        <li>
          <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Approval</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div id="calendar" class="fixed left-1/3 top-32 w-4/12 h-5/12 hidden z-50">
  <div id="navCalendar" class="flex justify-end justify-self-center bg-[#0370A3] w-full rounded-t-md pt-4 pr-4">
    <!-- <button type="button" id="closeCalendar" class="flex justify-center items-center w-5 h-5 bg-red-800 rounded-full">
      <span class="left-1 bottom-1 text-white text-sm leading-none">&#x2715;</span>
    </button> -->
    <button type="button" id="closeCalendar" class="flex items-center justify-center w-6 h-6 rounded-full bg-red-500 hover:bg-red-600 hover:text-white transition-colors">
        <span class="text-3xl pl-[0.05rem] pb-[0.35rem] text-black leading-none hover:text-white">&times;</span>
    </button>
  </div>
  <div id="calendarContent" class="justify-self-center bg-gradient-to-b from-[#0370A3] to-[#A1F3CD] w-full h-full p-4 rounded-b-md shadow-lg" ></div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        console.log("tes");
        // Mengatur Tanggal dan Bulan
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]

        const today = new Date();
        console.log("month: ", monthNames[today.getMonth()]);
        $('#month').text(monthNames[today.getMonth()]);
        $('#day').text(today.getDate());
        $('#day-name').text(dayNames[today.getDay()]);

        // Tampilkan dan sembunyikan pop-up kalender
        $('#calendar-button').on('click', function(e) {
            // e.stopPropagation(); // Mencegah klik pada tombol menutup popup
            $("#calendar").css("display", "block");
            $("#modal").css("display", "block");
            var calendarEl = document.getElementById('calendarContent');
            var calendar = new FullCalendar.Calendar(calendarEl, {
              initialView: 'dayGridMonth',
              fixedWeekCount: false
            });
            calendar.render();

        });

        // Menutup pop-up jika klik di luar
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#calendar-popup, #calendar-button').length) {
                $('#calendar-popup').addClass('hidden');
            }
        });
      });

      $('#closeCalendar').on('click', function(e) {
          $("#calendar").css("display", "none");
          $("#modal").css("display", "none");
      });

      document.addEventListener('DOMContentLoaded', function() {

      });
</script>




