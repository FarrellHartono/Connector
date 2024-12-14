<div id="modal" class="fixed w-screen h-full bg-black opacity-50 z-50 hidden">
</div>
<nav
    class="bg-white dark:bg-gray-900 w-full z-20 top-0 border-b border-gray-200 dark:border-gray-600 flex justify-evenly">
    <div class="flex flex-wrap items-center justify-between p-4 w-full">
        <!-- <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo">
        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
    </a> -->



        <div class="relative ">
            <!-- Icon Tanggal -->
            <button id="calendar-button"
                class="group relative flex items-center justify-center w-12 h-12 bg-gray-200 rounded-md hover:bg-[#0370A3] ">
                <div class="group absolute inset-0 text-center w-full h-full z-30 rounded-md ">
                    <div class="text-xs font-semibold bg-[#aa5f5f] rounded-t-md text-white " id="month"></div>
                    <div class="text-lg font-bold group-hover:text-white" id="day"></div>
                </div>

                <div
                    class="absolute top-0.5 left-12 z-20 transform -translate-x-6 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-300 ease-in-out">
                    <span id="day-name"
                        class=" block bg-transparent text-black rounded-md px-4 py-2 text-sm font-medium whitespace-nowrap"></span>
                </div>
            </button>

            <!-- Pop-up Kalender -->
            <div id="calendar-popup" class="hidden absolute top-20 left-20 z-10 bg-white rounded-md shadow-lg">
                <!-- <iframe src="{{ route('home') }}" class="absolute w-60 h-60"></iframe> -->
            </div>


            <!-- Day name sliding from calendar button to right -->

        </div>


    <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
        @if(Auth::check())
        <p class="flex flex-col text-right items-center m-0 sm:flex-row">
            <div class="relative w-32 text-right">
                <span id="typewriter" class=""></span>
            </div>
            <span>, {{ Auth::user()->name }}!</span>
        </p>

        <form action="{{ route('logout') }}" method="POST" class="flex items-center m-0">
            @csrf
            <button type="submit" class="ml-4 bg-red-500 text-white px-4 py-2 rounded">
                Logout
            </button>
        </form>
        @else
        <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded flex items-center justify-center">
            Login
        </a>
        @endif
    </div>


        <div class="items-center justify-center flex-grow hidden md:flex" id="navbar-sticky">
            <ul
                class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-12 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="{{ route('home') }}"
                        class="group relative block py-2 px-3 {{ request()->routeIs('home') ? 'text-blue-700 font-bold' : 'text-gray-900' }} rounded hover:bg-gray-100 md:hover:bg-transparent md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                        aria-current="page">
                        Home
                        <span
                            class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-blue-700 transform -translate-x-1/2 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('listBusiness') }}"
                        class="group relative block py-2 px-3 {{ request()->routeIs('listBusiness') ? 'text-blue-700 font-bold' : 'text-gray-900' }} rounded hover:bg-gray-100 md:hover:bg-transparent md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                        My Business
                        <span
                            class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-blue-700 transform -translate-x-1/2 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile') }}"
                        class="group relative block py-2 px-3 {{ request()->routeIs('profile') ? 'text-blue-700 font-bold' : 'text-gray-900' }} rounded hover:bg-gray-100 md:hover:bg-transparent md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                        Profile
                        <span
                            class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-blue-700 transform -translate-x-1/2 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </li>
                <li>
                    @admin
                        <a href="{{ route('admin.businesses') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Approval</a>
                    @endadmin
                    </a>
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
        <button type="button" id="closeCalendar"
            class="flex items-center justify-center w-6 h-6 rounded-full bg-red-500 hover:bg-red-600 hover:text-white transition-colors">
            <span class="text-3xl pl-[0.05rem] pb-[0.35rem] text-black leading-none hover:text-white">&times;</span>
        </button>
    </div>
    <div id="calendarContent"
        class="justify-self-center bg-gradient-to-b from-[#0370A3] to-[#A1F3CD] w-full h-full p-4 rounded-b-md shadow-lg">
    </div>
</div>


<style>
   /* .typing-animation {
    display: inline-block;
  overflow: hidden;
  border-right: .15em solid black;
  white-space: nowrap;
  margin: 0 auto;
  animation:
    typing 2s steps(40, end) infinite, blink 0.5s step-end infinite,
    blink-caret .75s step-end infinite;
}

@keyframes typing {
  from { width: 0 }
  to { width: 100% }
}

@keyframes blink-caret {
  from, to { border-color: transparent }
  50% { border-color: black; }
} */
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>

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

      var typed = new Typed('#typewriter', {
      strings: ['Welcome','Selamat Datang','환영','歓迎','欢迎'],
      typeSpeed: 120,
      loop: true
    });
</script>
