function calculerPrixLocation() {
    const dateDébut = document.getElementById('date_debut');
    const dateFin = document.getElementById('date_fin');
    
    if (dateDébut && dateFin) {
        const prixJourElement = document.getElementById('prix_jour');
        
        const prixJour = prixJourElement ? parseFloat(prixJourElement.value) : 0;
        
        function mettreAJourPrix() {
            const ancienPrixElement = document.getElementById('prix-total');
            if (ancienPrixElement) {
                ancienPrixElement.remove();
            }
            
            if (dateDébut.value && dateFin.value) {
                const debut = new Date(dateDébut.value);
                const fin = new Date(dateFin.value);
                
                if (fin >= debut) {
                    const diffTemps = fin.getTime() - debut.getTime();
                    const diffJours = Math.ceil(diffTemps / (1000 * 3600 * 24)) + 1;
                    const prixTotal = diffJours * prixJour;
                    
                    const prixElement = document.createElement('p');
                    prixElement.id = 'prix-total';
                    prixElement.textContent = `Prix total estimé: ${prixTotal} € (${diffJours} jours)`;
                    
                    document.querySelector('.vehicle-details').appendChild(prixElement);
                }
            }
        }
        
        dateDébut.addEventListener('change', mettreAJourPrix);
        dateFin.addEventListener('change', mettreAJourPrix);
    }
}

function confirmerSuppression(id) {
    return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?');
}

function validerFormulaire() {
    const modele = document.getElementById('modele');
    const marque = document.getElementById('marque');
    const immatriculation = document.getElementById('immatriculation');
    const prix = document.getElementById('prix');
    
    let isValid = true;
    
    if (!modele.value) {
        alert('Le modèle est obligatoire');
        isValid = false;
    }
    
    if (!marque.value) {
        alert('La marque est obligatoire');
        isValid = false;
    }
    
    if (!immatriculation.value) {
        alert('L\'immatriculation est obligatoire');
        isValid = false;
    }
    
    if (!prix.value || isNaN(prix.value) || prix.value <= 0) {
        alert('Le prix doit être un nombre positif');
        isValid = false;
    }
    
    return isValid;
}

function validerDates() {
    const dateDébut = document.getElementById('date_debut');
    const dateFin = document.getElementById('date_fin');
    
    if (dateDébut && dateFin && dateDébut.value && dateFin.value) {
        const debut = new Date(dateDébut.value);
        const fin = new Date(dateFin.value);
        
        if (fin < debut) {
            alert('La date de fin doit être après la date de début');
            return false;
        }
    }
    
    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    calculerPrixLocation();
    
    const formLocation = document.querySelector('form[action*="louer_vehicule.php"]');
    if (formLocation) {
        formLocation.addEventListener('submit', function(e) {
            if (!validerDates()) {
                e.preventDefault();
            }
        });
    }
    
    const formVehicule = document.querySelector('form[action*="vehicule_action.php"]');
    if (formVehicule) {
        formVehicule.addEventListener('submit', function(e) {
            if (!validerFormulaire()) {
                e.preventDefault();
            }
        });
    }
    
    const liensSupprimer = document.querySelectorAll('a[href*="action=supprimer"]');
    liensSupprimer.forEach(function(lien) {
        lien.addEventListener('click', function(e) {
            if (!confirmerSuppression()) {
                e.preventDefault();
            }
        });
    });
});