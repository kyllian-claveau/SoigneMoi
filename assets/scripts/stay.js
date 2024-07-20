import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { French } from "flatpickr/dist/l10n/fr.js";  // Import de la localisation française

document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.querySelector('#stay_startDate');
    const endDateInput = document.querySelector('#stay_endDate');

    const startDatePicker = flatpickr(startDateInput, {
        dateFormat: "d-m-Y",  // Format jour-mois-année
        altInput: true,
        altFormat: "d F Y",  // Format jour Nom-du-mois Année pour le champ alternatif
        allowInput: true,
        locale: French,  // Utilisation de la localisation française
        minDate: 'today', // Date minimale = date actuelle
        onChange: function(selectedDates, dateStr) {
            // Activer le champ de la date de fin et mettre à jour la date minimale
            endDateInput.disabled = false;
            endDatePicker.set('minDate', dateStr);
        }
    });

    const endDatePicker = flatpickr(endDateInput, {
        dateFormat: "d-m-Y",  // Format jour-mois-année
        altInput: true,
        altFormat: "d F Y",  // Format jour Nom-du-mois Année pour le champ alternatif
        allowInput: true,
        locale: French,  // Utilisation de la localisation française
        disable: [{ from: 'today' }] // Désactiver les dates antérieures à aujourd'hui
    });

    const specialtySelect = document.querySelector('.specialty-selector');
    const doctorSelect = document.querySelector('.doctor-selector');

    specialtySelect.addEventListener('change', function() {
        const selectedSpecialtyId = this.value;

        fetch(`https://soignemoiproject.online/doctors/by-specialty/${selectedSpecialtyId}`)
            .then(response => response.json())
            .then(data => {
                // Clear current doctor options
                doctorSelect.innerHTML = '';

                // Add default placeholder option
                const placeholderOption = document.createElement('option');
                placeholderOption.value = '';
                placeholderOption.textContent = 'Choisissez un docteur';
                doctorSelect.appendChild(placeholderOption);

                // Populate doctor options based on specialty
                data.doctors.forEach(doctor => {
                    const option = document.createElement('option');
                    option.value = doctor.id;
                    option.textContent = `${doctor.firstname} ${doctor.lastname}`;
                    doctorSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching doctors:', error);
            });
    });

});
