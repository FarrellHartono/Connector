// document.addEventListener('DOMContentLoaded', function () {
//     const currentDate = new Date();
//     let selectedDate = new Date();

//     const monthNameElement = document.querySelector('.month-name');
//     const calendarDaysElement = document.querySelector('.datepicker-calendar');
//     const prevButton = document.querySelector('.prev-month');
//     const nextButton = document.querySelector('.next-month');

//     const renderCalendar = (date) => {
//         const year = date.getFullYear();
//         const month = date.getMonth();
        
//         monthNameElement.textContent = date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

//         calendarDaysElement.innerHTML = '';

//         const firstDayOfMonth = new Date(year, month, 1).getDay();
//         const lastDateOfMonth = new Date(year, month + 1, 0).getDate();
//         const lastDayOfPrevMonth = new Date(year, month, 0).getDate();

//         // Display previous month's last days
//         for (let i = firstDayOfMonth - 1; i >= 0; i--) {
//             const dateElement = document.createElement('button');
//             dateElement.classList.add('date', 'faded');
//             dateElement.textContent = lastDayOfPrevMonth - i;
//             calendarDaysElement.appendChild(dateElement);
//         }

//         // Display current month's days
//         for (let i = 1; i <= lastDateOfMonth; i++) {
//             const dateElement = document.createElement('button');
//             dateElement.classList.add('date');
//             if (i === currentDate.getDate() && month === currentDate.getMonth() && year === currentDate.getFullYear()) {
//                 dateElement.classList.add('current-day');
//             }
//             dateElement.textContent = i;
//             calendarDaysElement.appendChild(dateElement);
//         }
//     };

//     // Event listeners for previous/next buttons
//     prevButton.addEventListener('click', () => {
//         selectedDate.setMonth(selectedDate.getMonth() - 1);
//         renderCalendar(selectedDate);
//     });

//     nextButton.addEventListener('click', () => {
//         selectedDate.setMonth(selectedDate.getMonth() + 1);
//         renderCalendar(selectedDate);
//     });

//     // Initial render
//     renderCalendar(currentDate);
// });
