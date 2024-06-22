<?php /*session_start(); 

    $_SESSION['id'] = "id";
    $_SESSION['age'] = 18;*/



//if (password_verify($Mdp, $hashpass)) {}



/*// Affichage des données :

    $q = $db->query("SELECT * FROM utilisateur");
    while ($user = $q->fetch()) { ?>

        <li>
            <a href="profile.php?q=<?= $user['id']; ?>"><?= $user['Email']; $user['MDP']; ?></a>
        </li>
        <?php
}*/


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" type="text/css" href="Styles/Logs.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <title>O' Sole Meo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale:1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <main>
        <i class="CroixQuitter fa-solid fa-xmark"></i>

        <div class="DivGauche">
            <img src="Images/LogoSoleMeo.png" class="LogoSoleMeo" alt="LogoSoleMeo">

            <div class="Divformulaire">
                <h2 class="NomFormulaire">Inscription</h2>

                <form method="post" class="formulaire">
                    <div>
                        <div>
                            <input type="text" name="Nom" id="Nom" placeholder="Nom" required>
                            <input type="text" name="Prenom" id="Prenom" placeholder="Prenom" required>
                            <input type="text" name="Telephone" id="Telephone" placeholder="Téléphone" required>
                        </div>
                        <div>
                            <input type="text" name="Adresse" id="Adresse" placeholder="Adresse" required>
                            <input type="text" name="Ville" id="Ville" placeholder="Ville" required>
                            <input type="text" name="CodePostal" id="CodePostal" placeholder="Code Postal" required>
                        </div>
                    </div>

                    <div>
                        <div>
                            <span class="dividerForm"></span>

                            <input type="email" name="Email" id="Email" placeholder="Email" required> 
                        
                            <div>
                                <input type="password" name="Mdp" id="Mdp" placeholder="Mot de passe" required>
                                <input type="password" name="MdpConfirm" id="MdpConfirm" placeholder="Ressaisir mot de passe" required>
                            </div>

                            <input type="submit" name="Envoyer" id="Envoyer" value="S'inscrire">

                        </div>
                    </div>
                </form>
                
                <?php 
                    if(isset($_POST['Envoyer'])) {

                        extract($_POST);

                        if(!empty($Mdp) && !empty($MdpConfirm) && !empty($Email) && !empty($CodePostal) && !empty($Ville) && !empty($Adresse) && !empty($Telephone) && !empty($Prenom) && !empty($Nom)) {
                            

                            // Connexion à la base de données :

                            include 'includes/database.php';
                            global $db;


                            // Vérification du mail unique :

                            $c = $db->prepare("SELECT Email FROM utilisateur WHERE Email =:Email");
                            $c->execute([
                                'Email' => $Email
                            ]);

                            $result = $c->rowCount();
                            if ($result == 0) {


                                // Vérification du mot de passe rempli deux fois :

                                if($Mdp == $MdpConfirm) {

                                    $email_a = 'joe@example';
                                    if (filter_var($email_a, FILTER_VALIDATE_EMAIL)) {
                                        echo "L'adresse email '$email_a' est considérée comme valide.";
                                    }


                                    // Vérification de la taille du mot de passe :

                                    $longueurMdp = strlen($Mdp);				

                                    if ($longueurMdp > 8) {

                                        $option = [
                                            'cost' => 12,
                                        ];// Hashage du Mdp
                                        $hashpass = password_hash($Mdp, PASSWORD_BCRYPT, $option); 
                                

                                        // Insertion des données :

                                        $q = $db->prepare("INSERT INTO utilisateur(Nom,Prenom,Tel,Adresse,Ville,CodePostal,Email,MDP) VALUES(:Nom,:Prenom,:Tel,:Adresse,:Ville,:CodePostal,:Email,:MDP)");
                                        $q->execute([
                                            'Nom' => $Nom,
                                            'Prenom' => $Prenom,
                                            'Tel' => $Telephone,
                                            'Adresse' => $Adresse,
                                            'Ville' => $Ville,
                                            'CodePostal' => $CodePostal,
                                            'Email' => $Email,
                                            'MDP' => $hashpass
                                        ]);

                                        echo '<p class="AjoutPhp">Inscription réalisée avec succès</p>';

                                    } else { echo '<p class="AjoutPhp">Le mot de passe est trop court !</p>'; }

                                } else { echo '<p class="AjoutPhp">La confirmation du mot de passe est différente de celui-ci !</p>'; }

                            } else { echo '<p class="AjoutPhp">Email déjà utilisé pour un autre compte !</p>'; }

                        } else { echo '<p class="AjoutPhp">Un des champs ' . "n'a pas été rempli</p>"; }
                    }
                ?>

                <div class="liensDessous">
                    <a href="index.html">Retour</a>
                    <span></span>
                    <a href="index.html">Déjà un compte ?</a>
                </div>
            </div>
        </div>
        
        <div class="ImageDroite">
        </div>

    </main>

</body>
</html>