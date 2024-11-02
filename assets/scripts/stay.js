import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { French } from "flatpickr/dist/l10n/fr.js";  // Import de la localisation française

document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.querySelector('#stay_startDate');
    const endDateInput = document.querySelector('#stay_endDate');
    const doctorSelect = document.querySelector('.doctor-selector');
    const specialtySelect = document.querySelector('.specialty-selector');

    // Désactiver le select des docteurs par défaut et afficher un message
    doctorSelect.innerHTML = '<option value="">Choisissez une spécialité d\'abord</option>';
    doctorSelect.disabled = true;

    // Initialiser le sélecteur de date de début
    const startDatePicker = flatpickr(startDateInput, {
        dateFormat: "d-m-Y",  // Format jour-mois-année
        altInput: true,
        altFormat: "d F Y",  // Format jour Nom-du-mois Année pour le champ alternatif
        allowInput: true,
        locale: French,  // Utilisation de la localisation française
        minDate: 'today',  // Date minimale = date actuelle
        onChange: function(selectedDates, dateStr) {
            // Activer le champ de la date de fin et mettre à jour la date minimale
            endDateInput.disabled = false;
            endDatePicker.set('minDate', dateStr);  // Mettre à jour la date minimale pour la date de fin
        }
    });

    // Initialiser le sélecteur de date de fin
    const endDatePicker = flatpickr(endDateInput, {
        dateFormat: "d-m-Y",  // Format jour-mois-année
        altInput: true,
        altFormat: "d F Y",  // Format jour Nom-du-mois Année pour le champ alternatif
        allowInput: true,
        locale: French,  // Utilisation de la localisation française
        minDate: 'today',  // Date minimale est aujourd'hui par défaut
    });

    // Gestion de la spécialité et du choix du docteur
    specialtySelect.addEventListener('change', function() {
        const selectedSpecialtyId = this.value;

        if (selectedSpecialtyId) {
            // Réactiver le select des docteurs
            doctorSelect.disabled = false;

            // Faire une requête fetch pour obtenir les docteurs par spécialité
            fetch(`/doctors/by-specialty/${selectedSpecialtyId}`)
                .then(response => response.json())
                .then(data => {
                    // Vider les options actuelles du select de docteur
                    doctorSelect.innerHTML = '';

                    // Ajouter une option placeholder par défaut
                    const placeholderOption = document.createElement('option');
                    placeholderOption.value = '';
                    placeholderOption.textContent = 'Choisissez un docteur';
                    doctorSelect.appendChild(placeholderOption);

                    // Ajouter les nouvelles options pour les docteurs
                    data.doctors.forEach(doctor => {
                        const option = document.createElement('option');
                        option.value = doctor.id;
                        option.textContent = `${doctor.firstname} ${doctor.lastname}`;
                        doctorSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des docteurs :', error);
                });
        } else {
            // Désactiver le select et remettre le message si aucune spécialité n'est sélectionnée
            doctorSelect.innerHTML = '<option value="">Choisissez une spécialité d\'abord</option>';
            doctorSelect.disabled = true;
        }
    });
});
