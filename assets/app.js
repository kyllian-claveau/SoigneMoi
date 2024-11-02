import './styles/app.css';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    if (calendarEl) {
        var doctorId = calendarEl.dataset.doctorId;
        var isAdmin = doctorId !== undefined; // Si l'ID est défini, il s'agit d'un admin

        // Définir l'URL des événements en fonction du rôle
        var eventsUrl = isAdmin
            ? '/admin/doctor/' + doctorId + '/events'
            : '/doctor/events'; // Route pour le docteur connecté

        var calendar = new Calendar(calendarEl, {
            plugins: [ dayGridPlugin ],
            locale: 'fr', // Spécifiez la langue française ici
            events: eventsUrl,
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