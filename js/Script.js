/*  ------  Gestion affichage progressif bandeaux main  ------  */

window.addEventListener('scroll', function() {
    let bandeaux = document.querySelectorAll('.BandeauxMain');
    let screenHeight = window.innerHeight;

    bandeaux.forEach(function(bandeau) {
        let positionTop = bandeau.getBoundingClientRect().top;
        let positionBottom = bandeau.getBoundingClientRect().bottom;

        // Ajouter la classe si l'élément est visible
        if(positionTop < screenHeight && positionBottom > 0) {
            bandeau.classList.add('appear');
        } else {
            // Retirer la classe si l'élément quitte l'écran
            bandeau.classList.remove('appear');
        }
    });
});


/*  ------  Affichage du menu burger  ------  */

const menuBurgerIcone = document.querySelector('.menuBurgerIcone')
const menuBurgerImage = document.querySelector('.menuBurgerIcone  i')
const menuBurger = document.querySelector('.menuBurger')

menuBurgerIcone.onclick = function() {
    menuBurger.classList.toggle('open')
    const isOpen = menuBurger.classList.contains('open')
    menuBurgerImage.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
}


/*  ------  Passage à la carte ( changement de la classe du body et du "main.activé")  ------  */

const body = document.querySelector('body')
const mainDefaut = document.querySelector('.MainDefaut')
const mainCarte = document.querySelector('.MainCarte')
const imageCarte = document.querySelector('.ImgCarte')
const retourDebut = document.querySelector('#RetourDebut');

imageCarte.onclick = function() {
    const CarteisOpen = mainCarte.classList.contains('Active')

    if (CarteisOpen) {
        mainCarte.classList.remove('Active')
        mainDefaut.classList.toggle('Active')
        body.classList.toggle('BodyDefaut')
        body.classList.remove('BodyCarte')
        imageCarte.classList.toggle('open')
    } else {
        mainDefaut.classList.remove('Active')
        mainCarte.classList.toggle('Active')
        body.classList.toggle('BodyCarte')
        body.classList.remove('BodyDefaut')
        imageCarte.classList.remove('open')
    }

    setTimeout(() => {
        retourDebut.scrollIntoView({ behavior: 'smooth' });
    }, 100);
}


/*  ------  Renvoi vers le pied de page des réseaux  ------  */

const retourPiedPage = document.querySelector('#RetourFooter');
const boutonsTel= document.querySelector('.BoutonTelephone');
const boutonsFacebook = document.querySelector('.BoutonFacebook');
const boutonsTripadvisor = document.querySelector('.BoutonTripadvisor');

function AllerFooterBoutons(event) {
    setTimeout(() => {
        retourPiedPage.scrollIntoView({ behavior: 'smooth' });
    }, 100);
}

[boutonsTel, boutonsFacebook, boutonsTripadvisor].forEach(bouton => {
    bouton.onclick = AllerFooterBoutons;
}); 