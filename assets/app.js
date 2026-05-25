/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import 'bootstrap';

$("#new_edit_utilisateur").on('submit', function(){
    if($("#utilisateur_password").val() != $("#verifpass").val()) {
        alert("Les deux mots de passe saisies sont différents");
        alert("Merci de renouveler l'opération");
        return false;
    }
})











function lectureStatus() {
    fetch('/admin/pico/status', {
    method: 'POST',
    credentials: 'same-origin'
})
.then(async response => {
    const text = await response.text();

    if (!response.ok) {
        console.log(text);
        throw new Error('Erreur HTTP ' + response.status);
    }

    return JSON.parse(text);
})
.then(data => console.log(data));
}

document.addEventListener('DOMContentLoaded', () => {
    document
        .getElementById('btn-lectureStatus')
        .addEventListener('click', lectureStatus);

});















function envoyerVanne2() {
    fetch('/admin/pico/vanne2/on', {
        method: 'POST',
    credentials: 'same-origin'
})
.then(async response => {
    const text = await response.text();

    if (!response.ok) {
        console.log(text);
        throw new Error('Erreur HTTP ' + response.status);
    }

    return JSON.parse(text);
})
.then(data => console.log(data));
}

document.addEventListener('DOMContentLoaded', () => {
    document
        .getElementById('btn-envoyerVanne2')
        .addEventListener('click', envoyerVanne2);

});
















function envoyerPWM() {

fetch('/admin/pico/pwm', {
    method: 'POST',
    credentials: 'same-origin',
    headers: {
        'X-PWM': '2'
    },
    credentials: 'same-origin'
})
.then(async response => {
    const text = await response.text();

    if (!response.ok) {
        console.log(text);
        throw new Error('Erreur HTTP ' + response.status);
    }

    return JSON.parse(text);
})
.then(data => console.log(data));
}

document.addEventListener('DOMContentLoaded', () => {

    document
        .getElementById('btn-envoyerPWM')
        .addEventListener('click', envoyerPWM);

});