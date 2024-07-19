import './styles/app.css';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    if (calendarEl) {
        var doctorId = calendarEl.dataset.doctorId;

        var calendar = new Calendar(calendarEl, {
            plugins: [ dayGridPlugin ],
            locale: 'fr', // Spécifiez la langue française ici
            events: '/admin/doctor/' + doctorId + '/events',
            eventRender: function(info) {
                var tooltip = new Tooltip(info.el, {
                    title: info.event.extendedProps.reason,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body'
                });
            }
        });

        calendar.render();
    }
});