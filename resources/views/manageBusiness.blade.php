@extends('layout.master')

@section('title')
  Manage Business
@endsection

@section('content')

@extends('layout.navbar')

<div class="container mx-auto mt-5" x-data="{ showCalendar: false }">

    <!-- Business Form -->
    <form>
       <div class="space-y-4">
          <input type="text" class="w-full p-2 border rounded" placeholder="Business Name" />
          <input type="text" class="w-full p-2 border rounded" placeholder="Business Address" />
          <div class="flex space-x-2">
             <input type="text" class="w-1/2 p-2 border rounded" placeholder="City" />
             <input type="text" class="w-1/2 p-2 border rounded" placeholder="State" />
          </div>
          <textarea class="w-full p-2 border rounded h-24" placeholder="Business Description"></textarea>

          <!-- Add Meeting Button -->
          <div class="flex justify-between items-center">
             <button type="button" @click="showCalendar = !showCalendar" class="px-4 py-2 bg-teal-500 text-white rounded">Add Meeting</button>
             <div class="space-x-2">
                <button type="button" class="px-3 py-1 border rounded">Edit</button>
                <button type="button" class="px-3 py-1 border rounded">Delete</button>
             </div>
          </div>
       </div>

       <!-- Hidden Input to Store Selected Date -->
       <input type="hidden" name="meeting_date" x-model="selectedDate">
    </form>

  <footer class="bg-gray-100 p-4 flex justify-between">
    <button class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
    <button class="px-4 py-2 bg-blue-500 text-white rounded">Save</button>
  </footer>

{{-- Script for using calender --}}
<script defer src="https://unpkg.com/alpinejs@3.2.1/dist/cdn.min.js"></script>

<!-- Calendar Component -->
<div x-show="showCalendar" class="w-full p-2 m-2 bg-gray-100 rounded-lg shadow">
    <div class="flex flex-wrap justify-center" x-data="genCalendar()" x-init="initializeCurrentDate()" x-cloak>
       <!-- Year Navigation -->
       <div class="flex flex-wrap w-full h-12 p-1 m-1 text-xl font-bold bg-white rounded-lg shadow-lg">
          <p class="w-1/3 p-1 text-center text-green-900 shadow-md cursor-pointer hover:text-green-600 hover:shadow-inner bg-gray-50 rounded-l-md" @click="year -= 1">
             <svg xmlns="http://www.w3.org/2000/svg" class="block w-6 h-8 m-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
             </svg>
          </p>
          <p class="w-1/3 p-1 text-center text-green-900 shadow-md cursor-pointer hover:text-green-600 hover:shadow-inner bg-gray-50" x-text="year"></p>
          <p class="w-1/3 p-1 text-center text-green-900 shadow-md cursor-pointer hover:text-green-600 hover:shadow-inner bg-gray-50 rounded-r-md" @click="year += 1">
             <svg xmlns="http://www.w3.org/2000/svg" class="block w-6 h-8 m-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
             </svg>
          </p>
       </div>

       <!-- Month Navigation and Days -->
       <template x-for="(month, index) in month_names">
          <div class="p-1 m-1 font-sans bg-white rounded shadow-md lg:w-72 w-80 bg-blend-luminosity bg-gradient-to-b from-green-50 via-white to-green-50">
             <p class="p-1 text-xl font-semibold text-center text-indigo-800" x-text="month"></p>
             <div class="p-1 m-1">
                <!-- Day Names -->
                <div class="grid grid-cols-7 font-semibold text-green-800 border-b-2">
                   <template x-for="day in day_names">
                      <div class="grid place-items-center" :class="{'text-red-600': day == 'Sun'}">
                         <p x-text="day"></p>
                      </div>
                   </template>
                </div>

                <!-- Days of the Month -->
                <div class="grid grid-cols-7 gap-1 font-semibold text-center text-gray-800">
                   <template x-for="day in generateDaysForMonth(index)">
                      <div @click="selectDate(day, index)" :class="{' ring-green-400 ring-4 rounded-full': isToday(day, index), 'text-red-600': isSunday(day, index), ' hover:bg-green-100': !isToday(day, index)}">
                         <p x-text="day"></p>
                      </div>
                   </template>
                </div>
             </div>
          </div>
       </template>
    </div>
 </div>
</div>

<script>
    function genCalendar() {
       return {
          month_names: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          day_names: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
          year: '',
          selectedDate: '',
          days_in_month: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],

          // Initialize the current date
          initializeCurrentDate() {
             let today = new Date();
             this.year = today.getFullYear();
          },

          // Check if a day is today
          isToday(day, month) {
             let today = new Date();
             let checkDate = new Date(this.year, month, day);
             return today.toDateString() === checkDate.toDateString();
          },

          // Check if a day is Sunday
          isSunday(day, month) {
             let checkDate = new Date(this.year, month, day);
             return checkDate.getDay() === 0;
          },

          // Select a date and store it in the selectedDate variable
          selectDate(day, month) {
             this.selectedDate = new Date(this.year, month, day).toLocaleDateString();
          },

          // Generate the days for each month
          generateDaysForMonth(month) {
             let days = [];
             let totalDays = this.days_in_month[month];

             // Adjust for leap year
             if (month === 1 && ((this.year % 4 === 0 && this.year % 100 !== 0) || (this.year % 400 === 0))) {
                totalDays = 29;
             }

             for (let day = 1; day <= totalDays; day++) {
                days.push(day);
             }

             return days;
          }
       };
    }
 </script>



@endsection