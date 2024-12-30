<style>

.fc-event {
    cursor: pointer; /* Add pointer cursor to all events */
}
</style>
<div id="modal" class="fixed w-screen h-full bg-black opacity-50 z-50 hidden">
</div>
<nav class="bg-white dark:bg-gray-900 w-full px-1 z-20 top-0 border-b border-gray-200 dark:border-gray-600 flex justify-evenly">
    <div class="text-lg font-bold self-center">
        Connector<span class="text-blue-500">App</span>
    </div>
    <div class="flex flex-wrap items-center justify-between p-4 w-full">


        <div class="relative z-0">
            <!-- Icon Tanggal -->
            <button id="calendar-button"
                class="group relative flex items-center justify-center w-12 h-12 bg-gray-200 rounded-md hover:bg-[#0370A3]">
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


        <div class="hidden lg:flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            @if (Auth::check())
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
                <a href="{{ route('login') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded flex items-center justify-center">
                    Login
                </a>
            @endif
        </div>


        <div class="items-center justify-center lg:flex" id="navbar-sticky">
            <ul class="hidden lg:flex flex-col p-4 lg:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 lg:space-x-12 rtl:space-x-reverse lg:flex-row md:mt-0 lg:border-0 lg:bg-white dark:bg-gray-800 lg:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="{{ route('home') }}"
                       class="group relative block py-2 px-3 {{ request()->routeIs('home') ? 'text-blue-700 font-bold' : 'text-gray-900' }} rounded hover:bg-gray-100 md:hover:bg-transparent md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                       aria-current="page">
                        Home
                        <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-blue-700 transform -translate-x-1/2 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </li>
                @if (auth()->id() !== 1)
                <li>
                    <a href="{{ route('listBusiness') }}"
                       class="group relative block py-2 px-3 {{ request()->routeIs('listBusiness') ? 'text-blue-700 font-bold' : 'text-gray-900' }} rounded hover:bg-gray-100 md:hover:bg-transparent md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                        My Business
                        <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-blue-700 transform -translate-x-1/2 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile') }}"
                       class="group relative block py-2 px-3 {{ request()->routeIs('profile') ? 'text-blue-700 font-bold' : 'text-gray-900' }} rounded hover:bg-gray-100 md:hover:bg-transparent md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                        Profile
                        <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-blue-700 transform -translate-x-1/2 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </li>
                @else
                <li>
                    <a href="{{ route('admin.businesses') }}"
                       class="group relative block py-2 px-3 {{ request()->routeIs('admin.businesses') ? 'text-blue-700 font-bold' : 'text-gray-900' }} rounded hover:bg-gray-100 md:hover:bg-transparent md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                        Business Approval
                        <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-blue-700 transform -translate-x-1/2 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </li>
                @endif
            </ul>

            {{-- hamburger menu --}}
            <div class="relative lg:hidden">
                <!-- Burger Button -->
                <button class="peer space-y-1">
                    <div class="w-6 h-1 bg-black rounded"></div>
                    <div class="w-6 h-1 bg-black rounded"></div>
                    <div class="w-6 h-1 bg-black rounded"></div>
                </button>

                <!-- Dropdown Menu -->
                <ul class="dropdown-menu bg-[#252525] w-screen fixed top-0 left-0 -translate-y-full peer-focus:translate-y-0 transition-transform duration-150 z-50 flex flex-col pb-6">
                    <!-- Close Button -->
                    <button class="absolute top-4 right-8 px-4 py-4 bg-[#202020] rounded-md">
                        <x-svg-icon name="close-navbar" />
                    </button>
                    @if (Auth::check())
                <p class="flex flex-col text-center items-center m-0 mt-5 sm:flex-row">
                <div class="relative w-full text-center">
                    <span id="typewriter2" class="text-white"></span>
                    <span class="text-white">, {{ Auth::user()->name }}!</span>
                </div>
                </p>
                    @endif

                    <!-- Links -->
                    <li class="flex justify-center w-full py-3 hover:bg-[#202020] mt-20">
                        <a href="{{ route('home') }}" class="text-white" aria-current="page">
                            Home
                        </a>
                    </li>
                    @if (auth()->id() !== 1)
                    <li class="flex justify-center w-full py-3 hover:bg-[#202020]">
                        <a href="{{ route('listBusiness') }}" class="text-white">
                            My Business
                        </a>
                    </li>
                    <li class="flex justify-center w-full py-3 hover:bg-[#202020]">
                        <a href="{{ route('profile') }}" class="text-white">
                            Profile
                        </a>
                    </li>
                    @else
                    <li class="flex justify-center w-full py-3 hover:bg-[#202020]">
                        <a href="{{ route('admin.businesses') }}" class="text-white">
                            Business Approval
                        </a>
                    </li>
                    @endif
                    @if (Auth::check())
                    <li class="flex justify-center w-full py-3 hover:bg-[#202020]">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
                                Logout
                            </button>
                        </form>
                    </li>
                    @else
                    <li class="flex justify-center w-full py-3 hover:bg-[#202020]">
                        <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                            Login
                        </a>
                    </li>
                    @endif
                </ul>
            </div>

          </div>
    </div>

</nav>

<div id="calendarContainer" class="fixed left-[15%] top-8 w-8/12  hidden z-50">
    <div id="navCalendar" class="flex justify-end bg-[#0370A3] w-full rounded-t-md pt-4 pr-4">
        <button type="button" id="closeCalendar"
            class="flex items-center justify-center w-6 h-6 rounded-full bg-red-500 hover:bg-red-600 hover:text-white transition-colors">
            <span class="text-3xl pl-[0.05rem] pb-[0.35rem] text-black leading-none hover:text-white">&times;</span>
        </button>
    </div>
  
  <div class="flex w-full">
    <div id="calendarContent"  class="justify-self-center w-3/4 bg-gradient-to-b from-[#0370A3] to-[#A1F3CD] p-4 rounded-b-md shadow-lg" >
    </div>
    
    <div id="calendarDescription"  class="flex-col content-around w-1/4 bg-[#0370A3] h-auto rounded-md rounded-t-none shadow-lg p-3">
        <div id="title" class="justify-self-center font-bold text-2xl"></div>
        <div id="business" class="text-center font-semibold text-lg mb-10" ></div>
        <div id="description" class="justify-self-center "></div>
    </div>
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
            $("#calendarContainer").css("display", "block");
            $("#modal").css("display", "block");
            var calendarEl = document.getElementById('calendarContent');

            var meetings = null;
            $.ajax({
                url: "{{ route('getRegisteredMeetings') }}",
                method: "GET",
                success: function(response) {
                  console.log(response.registered);
                  var calendar = new FullCalendar.Calendar(calendarEl, {
                      initialView: 'dayGridMonth',
                      events: response.registered,
                      fixedWeekCount: false,
                      eventClick: function(info) {
                          $("#title").html(info.event.title);
                          $("#business").html(info.event.extendedProps.business.title);
                          $("#description").html(info.event.extendedProps.description);
                      }
                  });
                  calendar.render();
                  console.log("meetings: ", meetings);
                }
            });
        });

        // Menutup pop-up jika klik di luar
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#calendar-popup, #calendar-button').length) {
                $('#calendar-popup').addClass('hidden');
            }
        });
    });

    $('#closeCalendar').on('click', function(e) {
        $("#calendarContainer").css("display", "none");
        $("#modal").css("display", "none");
    });

    $('#modal').on('click', function(e) {
        $("#calendarContainer").css("display", "none");
        $("#modal").css("display", "none");
    });

    document.addEventListener('DOMContentLoaded', function() {

    });

    var typed = new Typed('#typewriter', {
        strings: ['Welcome', 'Selamat Datang', '환영', '歓迎', '欢迎', 'Bonjour'],
        typeSpeed: 120,
        loop: true
    });
    var typed = new Typed('#typewriter2', {
        strings: ['Welcome', 'Selamat Datang', '환영', '歓迎', '欢迎', 'Bonjour'],
        typeSpeed: 120,
        loop: true
    });
</script>
