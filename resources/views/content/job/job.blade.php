<!DOCTYPE html>
<html>
<head>
    <title>Timeline Pekerjaan</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.css' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.js'></script>
</head>
<body>
    <div id='calendar'></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridDay',
                events: [
                    @foreach ($dummyData as $data)
                    {
                        title: '{{ $data['team_name'] }}',
                        start: '{{ $data['start_time'] }}',
                        end: '{{ $data['end_time'] }}'
                    },
                    @endforeach
                ]
            });
            calendar.render();
        });
    </script>
</body>
</html>