function caricaDatiProfilo() {
    const datiProfilo = ottieniDatiProfiloDalDatabase(); /*TODO*/

    document.getElementById('nomeUtente').innerText = datiProfilo.nomeUtente;
    document.getElementById('dataCreazione').innerText = "Member since: " + datiProfilo.dataCreazione;
    document.getElementById('immagineProfilo').src = datiProfilo.urlImmagineProfilo;
}

function ottieniDatiProfiloDalDatabase() {
    
}

document.addEventListener('DOMContentLoaded', function () {
    caricaDatiProfilo();
});
