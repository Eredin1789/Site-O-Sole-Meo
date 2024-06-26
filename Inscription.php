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

    if(isset($_POST['Envoyer'])) {

        $Message = '';

        extract($_POST);


        // Extraction des données :
/*
        $Nom = filter_input(INPUT_POST, 'Nom', FILTER_SANITIZE_STRING);
extraction        $Prenom = filter_input(INPUT_POST, 'Prenom', FILTER_SANITIZE_STRING);
        $Email = filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL);
*/        
        $RecupEmail = $Email;
        $RecupCodePostal = $CodePostal;
        $RecupVille = $Ville;
        $RecupAdresse = $Adresse;
        $RecupTelephone = $Telephone;
        $RecupPrenom = $Prenom;
        $RecupNom = $Nom;

        if(!empty($Mdp) && !empty($MdpConfirm) && !empty($Email) && !empty($CodePostal) && !empty($Ville) && !empty($Adresse) && !empty($Telephone) && !empty($Prenom) && !empty($Nom)) {
            

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

/**/                    $email_a = 'joe@example';
                    if (filter_var($email_a, FILTER_VALIDATE_EMAIL)) {
                        echo "L'adresse email '$email_a' est considérée comme valide.";
                    }


            // Vérification de la conformité du mot de passe :

                    if (preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{8,}$/', $Mdp)) {


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
                                ':Nom' => ['value' => $Nom, 'type' => PDO::PARAM_STR],
                                ':Prenom' => ['value' => $Prenom, 'type' => PDO::PARAM_STR],
                                ':Tel' => ['value' => $Telephone, 'type' => PDO::PARAM_STR],

                                ':Adresse' => ['value' => $Adresse, 'type' => PDO::PARAM_STR],
                                ':Ville' => ['value' => $Ville, 'type' => PDO::PARAM_STR],
                                ':CodePostal' => ['value' => $CodePostal, 'type' => PDO::PARAM_STR],
                                ':Email' => ['value' => $Email, 'type' => PDO::PARAM_STR],
                                ':MDP' => ['value' => $hashpass, 'type' => PDO::PARAM_STR],
                                ':ConfirmKey' => ['value' => $Key, 'type' => PDO::PARAM_STR]
                            ];

                            // Liaison des paramètres avec spécification des types de données :

                            foreach ($params as $Parametre => $param) {
                                $stmt->bindValue($Parametre, $param['value'], $param['type']);
                            }
                            
                            $stmt->execute();
                            
                            //  :


                            $Message = '<p class="AjoutPhp">Inscription réalisée avec succès</p>';

                        } else { $Message = '<p class="AjoutPhp">Le numéro de téléphone ' . "n'est pas valide !</p>"; }

                    } else { $Message = '<p class="AjoutPhp">Le mot ' . " n'est pas conforme !</p>"; }

                } else { $Message = '<p class="AjoutPhp">La confirmation du mot de passe est différente de celui-ci !</p>'; }

            } else { $Message = '<p class="AjoutPhp">Email déjà utilisé pour un autre compte !</p>'; }

        } else { $Message = '<p class="AjoutPhp">Un des champs ' . "n'a pas été rempli</p>"; }

    } 
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
                            <input type="text" name="Nom" id="Nom" placeholder="Nom" value="<?= htmlspecialchars($RecupNom) ?>" required>
                            <input type="text" name="Prenom" id="Prenom" placeholder="Prenom" value="<?= htmlspecialchars($RecupPrenom) ?>" required>
                            <input type="text" name="Telephone" id="Telephone" placeholder="Téléphone (06 03..." value="<?= htmlspecialchars($RecupTelephone) ?>" required>
                        </div>
                        <div>
                            <input type="text" name="Adresse" id="Adresse" placeholder="Adresse" value="<?= htmlspecialchars($RecupAdresse) ?>" required>
                            <input type="text" name="Ville" id="Ville" placeholder="Ville" value="<?= htmlspecialchars($RecupVille) ?>" required>
                            <input type="text" name="CodePostal" id="CodePostal" placeholder="Code Postal" value="<?= htmlspecialchars($RecupCodePostal) ?>" required>
                        </div>
                    </div>

                    <div>
                        <div>
                            <span class="dividerForm"></span>

                            <input type="email" name="Email" id="Email" placeholder="Email" value="<?= htmlspecialchars($RecupEmail) ?>" required> 
                        
                            <div>
                                <input type="password" name="Mdp" id="Mdp" placeholder="Mot de passe" value="aaaaaaaA!" required>
                                <input type="password" name="MdpConfirm" id="MdpConfirm" placeholder="Ressaisir mot de passe" value="aaaaaaaA!" required>
                            </div>

                            <input type="submit" name="Envoyer" id="Envoyer" value="S'inscrire">

                        </div>
                    </div>
                </form>
                
                <?=
                    $Message
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