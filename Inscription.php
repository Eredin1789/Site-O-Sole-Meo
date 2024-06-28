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

    $RecupEmail = '';
    $RecupCodePostal = '';
    $RecupVille = '';
    $RecupAdresse = '';
    $RecupTelephone = '';
    $RecupPrenom = '';
    $RecupNom = '';

    $Message = '';

    if($_SERVER["REQUEST_METHOD"] == "POST") { 


// Purification et validation des données :

        function NettoyageVar($Variable) {
            return htmlspecialchars(strip_tags(trim($Variable)), ENT_QUOTES, 'UTF-8');
        }

        $Nom = NettoyageVar($_POST['Nom'] ?? '');
        $Prenom = NettoyageVar($_POST['Prenom'] ?? '');
        $Telephone = NettoyageVar($_POST['Telephone'] ?? '');
        $Adresse = NettoyageVar($_POST['Adresse'] ?? '');
        $Ville = NettoyageVar($_POST['Ville'] ?? '');
        $CodePostal = NettoyageVar($_POST['CodePostal'] ?? '');

        $Email = filter_var(NettoyageVar($_POST['Email'] ?? ''), FILTER_SANITIZE_EMAIL);

        $Mdp = NettoyageVar($_POST['Mdp'] ?? '');
        $MdpConfirm = NettoyageVar($_POST['MdpConfirm'] ?? '');
        

        $RecupEmail = $Email;
        $RecupCodePostal = $CodePostal;
        $RecupVille = $Ville;
        $RecupAdresse = $Adresse;
        $RecupTelephone = $Telephone;
        $RecupPrenom = $Prenom;
        $RecupNom = $Nom;

        if(!empty($Mdp) && !empty($MdpConfirm) && !empty($Email) && !empty($CodePostal) && !empty($Ville) && !empty($Adresse) && !empty($Telephone) && !empty($Prenom) && !empty($Nom)) {


    // Vérification du Nom et Prenom valide :

            $ParametresValides = '/^[a-zA-Zà-ÿÀ-ÿ\-]+$/u';

/* Pas sure */            if (preg_match($ParametresValides, $Prenom) && preg_match($ParametresValides, $Nom)) {

        // Vérification du mail valide :

                if (filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                
                // Connexion à la base de données :

                include 'includes/database.php';
                global $db;

                
            // Vérification du mail unique :

                    $sql = "SELECT Email FROM utilisateur WHERE Email = :Email";

                    $stmt = $db->prepare($sql);

                    $stmt->bindValue(":Email", $Email, PDO::PARAM_STR);

                    $stmt->execute();

                    $result = $stmt->rowCount();
                    if ($result == 0) {


                // Vérification du mot de passe rempli deux fois :

                        if($Mdp == $MdpConfirm) {


                    // Vérification de la conformité du mot de passe :

                            if (preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{8,20}$/', $Mdp)) {


                        // Vérification de la conformité du téléphone :

                                if (preg_match('/^0\d{9}$/', $Telephone)) {


                                    // Création de la clé de confirmaton mail :  :

                                    $Key = bin2hex(random_bytes(16));
            

                                    // Hashage du Mdp :

                                    $option = [
        /*pas fou*/                               'cost' => 12,
                                    ];
                                    $hashpass = password_hash($Mdp, PASSWORD_BCRYPT, $option); 
                            

                            // Insertion des données :


                                    $sql = "INSERT INTO utilisateur(Nom, Prenom, Tel, Adresse, Ville, CodePostal, Email, MDP, ConfirmKey) VALUES(:Nom, :Prenom, :Tel, :Adresse, :Ville, :CodePostal, :Email, :MDP, :ConfirmKey)";
                                    $stmt = $db->prepare($sql);


                                    // Spécification des paramètres de la requête :

                                    $params = [
                                        ':Nom' =>  $Nom,
                                        ':Prenom' => $Prenom,
                                        ':Tel' => $Telephone,
                                        ':Adresse' => $Adresse,
                                        ':Ville' => $Ville,
                                        ':CodePostal' => $CodePostal,
                                        ':Email' => $Email,
                                        ':MDP' => $hashpass,
                                        ':ConfirmKey' => $Key
                                    ];

                                    // Liaison des paramètres avec spécification des types de données :

                                    foreach ($params as $Parametre => $Value) {
                                        $stmt->bindValue($Parametre, $Value, PDO::PARAM_STR);
                                    }
                                    
                                    $stmt->execute();
                                    
                                    //  :


                                    $Message = 'Inscription réalisée avec succès !';

                                } else { $Message = 'Le numéro de téléphone n\'est pas valide !'; }

                            } else { $Message = 'Le mot n\'est pas conforme !'; }

                        } else { $Message = 'La confirmation du mot de passe est différente de celui-ci !'; }

                    } else { $Message = 'Email déjà utilisé pour un autre compte !'; }

                } else { $Message = 'Email non valide !'; }

            } else { $Message = 'Nom ou Prénom non valide !'; }
        
        } else { $Message = 'Un des champs n\'a pas été rempli !'; }

    } 
    
    $Message = htmlspecialchars($Message, ENT_QUOTES, 'UTF-8');
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
                            <input type="text" name="Nom" id="Nom" placeholder="Nom" value="<?= htmlspecialchars($RecupNom, ENT_QUOTES, 'UTF-8') ?>" required>
                            <input type="text" name="Prenom" id="Prenom" placeholder="Prenom" value="<?= htmlspecialchars($RecupPrenom, ENT_QUOTES, 'UTF-8') ?>" required>
                            <input type="text" name="Telephone" id="Telephone" placeholder="Téléphone (06 03..." value="<?= htmlspecialchars($RecupTelephone, ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                        <div>
                            <input type="text" name="Adresse" id="Adresse" placeholder="Adresse" value="<?= htmlspecialchars($RecupAdresse, ENT_QUOTES, 'UTF-8') ?>" required>
                            <input type="text" name="Ville" id="Ville" placeholder="Ville" value="<?= htmlspecialchars($RecupVille, ENT_QUOTES, 'UTF-8') ?>" required>
                            <input type="text" name="CodePostal" id="CodePostal" placeholder="Code Postal" value="<?= htmlspecialchars($RecupCodePostal, ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                    </div>

                    <div>
                        <div>
                            <span class="dividerForm"></span>

                            <input type="email" name="Email" id="Email" placeholder="Email" value="<?= htmlspecialchars($RecupEmail, ENT_QUOTES, 'UTF-8') ?>" required> 
                        
                            <div>
                                <input type="password" name="Mdp" id="Mdp" placeholder="Mot de passe" value="aaaaaaaA!" required>
                                <input type="password" name="MdpConfirm" id="MdpConfirm" placeholder="Ressaisir mot de passe" value="aaaaaaaA!" required>
                            </div>

                            <input type="submit" name="Envoyer" id="Envoyer" value="S'inscrire">

                        </div>
                    </div>
                </form>
                
                <?=
                    '<p class="AjoutPhp">'.
                    $Message.
                    '</p>'
                ?>

                <div class="liensDessous">
                    <div>
                        <a href="index.html">Retour</a>
                    </div>

                    <span></span>

                    <div>
                        <a href="index.html">Déjà un compte ?</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="ImageDroite">
        </div>

    </main>

</body>
</html>