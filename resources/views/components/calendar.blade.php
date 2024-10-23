<div id='calendar'></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        // Create the event data directly in Blade
        var meetings = @json($business->meetings->map(function($meeting) {
            return [
                'title' => $meeting->title,
                'start' => $meeting->date,
                'description' => $meeting->description
            ];
        }));

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: meetings,
            eventClick: function(info) {
                alert('Meeting: ' + info.event.title + '\nDescription: ' + info.event.extendedProps.description);
            }
        });

    calendar.render();
    });
</script>

{{-- In case mau nampilin event-event dibawah calender --}}
{{-- <ul>
    @foreach($business->meetings as $meeting)
        <li>{{ $meeting->title }} on {{ $meeting->date }} - {{ $meeting->description }}</li>
    @endforeach
</ul> --}}
