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

const menuBurgerCarte = document.querySelector('.menuBurgerCarte')

const menuBurgerIcone = document.querySelector('.menuBurgerIcone')
const menuBurgerImage = document.querySelector('.menuBurgerIcone  i')
const menuBurger = document.querySelector('.menuBurger')

menuBurgerIcone.onclick = function() {
    menuBurger.classList.toggle('open')
    const isOpen = menuBurger.classList.contains('open')
    menuBurgerImage.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
    if (isOpen) {
        menuBurgerCarte.classList.remove('open')
        imageCarte.src = ImageCarteOriginale;
    }
}


/*  ------  Passage à la carte ( changement de la classe du body et du "main.activé")  ------  */
/*  ------   et gestion de l'ouverture du menu burger de la carte   ------   */

const body = document.querySelector('body')
const mainDefaut = document.querySelector('.MainDefaut')
const mainCarte = document.querySelector('.MainCarte')
const retourDebut = document.querySelector('#RetourDebut')

const imageCarte = document.querySelector('.ImgCarte')
const ImageCarteOriginale = "./Images/IconeMenuRestaurant.png"
const ImageCarteCroix = "./Images/CroixMenuBlanche.png"


imageCarte.onclick = function() {
    const CarteisOpen = mainCarte.classList.contains('Active')
    const MenuBurgerCarteisOpen = menuBurgerCarte.classList.contains('open')


    if (CarteisOpen) {
        menuBurgerCarte.classList.toggle('open')


    } else {
        mainCarte.classList.add('Active')
        mainDefaut.classList.remove('Active')
        body.classList.add('BodyCarte')
        body.classList.remove('BodyDefaut')
        setTimeout(() => {
            retourDebut.scrollIntoView({ behavior: 'smooth' });
            menuBurgerCarte.classList.add('open')
        }, 200);
    }

    if (imageCarte.src.endsWith(ImageCarteOriginale.split('/').pop())) {
        imageCarte.src = ImageCarteCroix;
        menuBurger.classList.remove('open')
        menuBurgerImage.classList = 'fa-solid fa-bars'


    } else {
        imageCarte.src = ImageCarteOriginale;
    }
}


/*  ------  Fonction de fermeture de la carte  ------  */

const BouttonQuitterCarte = document.querySelector('.QuitterCarte')

BouttonQuitterCarte.onclick = function() {
    
    mainDefaut.classList.add('Active')
    mainCarte.classList.remove('Active')
    body.classList.add('BodyDefaut')
    body.classList.remove('BodyCarte')

    menuBurgerCarte.classList.remove('open')

    setTimeout(() => {
        retourDebut.scrollIntoView({ behavior: 'smooth' });
    }, 300);
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


