<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
          <?php foreach ($contacts as $contact): ?>
            <h3><?php echo $contact['Page']['title']; ?></h3>
            <?php endforeach; ?>
        </div>
        <div class="small-12 medium-12 large-12 columns center blacka">
                <h6><i class="fa fa-arrow-circle-left"></i> <?php echo $this->Html->link(
                                'Retour à la page précédente',
                                $this->request->referer(),
                                array('title'=>'bouton pour revenir à la page précédente')
                                ); ?></h6>
        </div>
    </div>
    <div class="row">
      <div class="small-12 medium-12 large-12 columns">
        <?php foreach ($contacts as $contact): ?>
      <h2 class="robotobold"></h2>
        <p>SARL L’EPITAPHE</p>
        <p>12 avenue du plateau des Glières</p>
        <p>86000 Poitiers</p>
        <p>France</p>
        <p>Tel. 06.50.08.41.06</p>
        <p>Contact : contact@scanepitaphe.fr</p>
        <?php
if (isset($_POST["envoyer"])){ // Si le formulaire a été soumis
    $etat = "erreur"; // On initialise notre etat à erreur, il sera changé à "ok" si la vérification du formulaire est un succès, sinon il reste à erreur

    // On récupère les champs du formulaire, et on arrange leur mise en forme
  
      if (isset($_POST["titre"])) $_POST["titre"]=trim(stripslashes($_POST["titre"]));

      if (isset($_POST["nom"])) $_POST["nom"]=trim(stripslashes($_POST["nom"]));

      if (isset($_POST["prenom"])) $_POST["prenom"]=trim(stripslashes($_POST["prenom"]));

      if (isset($_POST["email"])) $_POST["email"]=trim(stripslashes($_POST["email"]));

      if (isset($_POST["telephone"])) $_POST["telephone"]=trim(stripslashes($_POST["telephone"]));

      if (isset($_POST["objet"])) $_POST["objet"]=trim(stripslashes($_POST["objet"]));

      if (isset($_POST["priorite"])) $_POST["priorite"]=trim(stripslashes($_POST["priorite"]));

      if (isset($_POST["message"])) $_POST["message"]=trim(stripslashes($_POST["message"]));

      if (isset($_POST["spam"])) $_POST["spam"]=trim(stripslashes($_POST["spam"]));

    // Après la mise en forme, on vérifie la validité des champs
    if (empty($_POST["nom"])) { // L'utilisateur n'a pas rempli le champ pseudo
        $erreur="Vous n'avez pas entré votre nom..."; // On met dans erreur le message qui sera affiché
        }
        elseif (empty($_POST["email"])) { // L'utilisateur n'a pas rempli le champ email
            $erreur="Nous avons besoin de votre e-mail pour vous répondre...";
        }
        elseif (!eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\.[a-z]{2,4}$",$_POST["email"])){ // On vérifie si l'email est bien de la forme messagerie@domaine.tld (cf cours d'expressions régulières)
            $erreur="Votre adresse e-mail n'est pas valide...";
        }
        elseif (empty($_POST["objet"])) { // L'utilisateur n'a pas rempli le champ objet
            $erreur="Vous devez entrer l'objet de votre message...";
        }
        elseif ( $_POST["spam"]!=5) { // L'utilsateur n'a écrit aucun message
            $erreur="Erreur dans l'opération 2 + 3";
        }
        elseif (empty($_POST["message"])) { // L'utilsateur n'a écrit aucun message
            $erreur="Merci de saisir un message...";
        }
        else { // Si tous les champs sont valides, on change l'état à ok
            $etat="ok";
        }
}
else { // Sinon le formulaire n'a pas été soumis
    $etat="attente"; // On passe donc dans l'état attente
}

if ($etat!="ok"){ // Le formulaire a été soumis mais il y a des erreurs (etat=erreur) OU le formulaire n'a pas été soumis (etat=attente)
    if ($etat=="erreur"){ // Cas où le formulaire a été soumis mais il y a des erreurs
        echo "<span style=\"color:red\">".$erreur."</span><br /><br />\n"; // On affiche le message correspondant à l'erreur
    }
?>
          <div  >
            <form method="post">
              <fieldset  class="contactform "><legend class="contactformb">&nbsp;Vos informations&nbsp;</legend>

                                <p><label for="contact_title" class="left">Votre titre :</label><br/>
                   <select name="titre" id="contact_title" class="combo">
                     <option value="M" selected="selected">M.</option>
                     <option value="Mme">Mme</option>
                     <option value="Mlle">Mlle</option></select></p>
                
           
                <p><label for="contact_firstname" class="left">Nom* :</label><br/>
                   <input type="text" name="nom" id="contact_firstname" class="field" value="<?php
        if (!empty($_POST["nom"])) {
        echo htmlspecialchars($_POST["nom"],ENT_QUOTES);
        }
        ?>" /></p>
           
                <p><label for="contact_familyname" class="left">Prénom :</label><br/>
                   <input type="text" name="prenom" id="contact_familyname" class="field" value="<?php
        if (!empty($_POST["prenom"])) {
        echo htmlspecialchars($_POST["prenom"],ENT_QUOTES);
        }
        ?>" /></p>
           
               <p><label for="contact_phone" class="left">Téléphone :</label><br/>
                   <input type="text" name="telephone" id="contact_phone" class="field" value="<?php
        if (!empty($_POST["telephone"])) {
        echo htmlspecialchars($_POST["telephone"],ENT_QUOTES);
        }
        ?>" /></p>
           
                <p><label for="contact_email" class="left">E-mail* :</label><br/>
                   <input type="text" name="email" id="contact_email" class="field" value="<?php
        if (!empty($_POST["email"])) {
        echo htmlspecialchars($_POST["email"],ENT_QUOTES);
        }
        ?>" /></p>
           
              </fieldset>
        
        
              <fieldset class="contactform "><legend class="contactformb">&nbsp;Votre message&nbsp;</legend>
                <p><label for="contact_subject" class="left">Sujet* :</label><br/>
                   <input type="text" name="objet" id="contact_subject" class="field" value="<?php
        if (!empty($_POST["objet"])) {
        echo htmlspecialchars($_POST["objet"],ENT_QUOTES);
        }
        ?>" /></p>
           
                <p><label for="contact_urgency" class="left">Priorité :</label><br/>
                   <select name="priorite" id="contact_urgency" class="combo">
                     <option value="Très basse">Très basse</option>
                     <option value="Basse">Basse</option>
                     <option value="Normale" selected="selected">Normale</option>
                     <option value="Haute">Haute</option>
                     <option value="Très Haute">Très haute</option></select></p>

                <p><label for="nature" class="left">Votre demande concerne :</label><br/>
                   <select name="demande" id="nature" class="combo">
                      <option value="renseigner" selected="selected">A renseigner</option>
                     <option value="Creation site">Assistance technique</option>
                     <option value="Maj">Une facture / Une commande</option>
                     <option value="Creation logo">Un devis</option>
                     <option value="Autre">Autre</option></select></p>
           
                <p><label for="contact_message" class="left">Message* :</label><br/>
                   <textarea name="message" id="contact_message" cols="45" rows="10"><?php
        if (!empty($_POST["message"])) {
        echo htmlspecialchars($_POST["message"],ENT_QUOTES);
        }
        ?></textarea></p>

        <p><label for="contact_spam" class="left">Combien font 2 + 3?* :</label><br/>
                   <input type="text" name="spam" id="contact_spam" class="field" value="<?php
        if (!empty($_POST["spam"])) {
        echo htmlspecialchars($_POST["spam"],ENT_QUOTES);
        }
        ?>" /></p>

                <p><input type="submit" name="envoyer" class="buttoncont" value="Envoyer" /></p>
              </fieldset>
            </form>
          </div>
<?php
}
else { // Sinon l'état est ok donc on envoie le mail
$titre = $_POST["titre"];
      $nom = $_POST["nom"]; 
      $prenom = $_POST["prenom"];// On stocke les variables récupérées du formulaire
    $email = $_POST["email"];
     $objet = $_POST["objet"];
    $message = $_POST["message"];
  $telephone = $_POST["telephone"];
  $priorite = $_POST["priorite"];
    $demande = $_POST["demande"];
// ================= Les 3 lignes suivantes sont à modifier ====================================
    $mon_email = "contact@scanepitaphe.fr"; // Mise en forme du message que vous recevrez
    $mon_pseudo = ".:ScanEpitaphe:.";
    $mon_url = "http://scanepitaphe.fr/";
    $msg_pour_moi = "
Par $titre $nom $prenom
- E-mail : $email
- Nature demande : $demande
- Objet du message : $objet
- Message :
$message

- Autres:
Priorité : $priorite
Tel: $telephone";

    // Mise en forme de l'accusé réception qu'il recevra
    $accuse_pour_lui = "
Bonjour $titre $nom nous tâcherons de vous répondre le plus rapidement possible.\n\n
- Votre E-mail : $email \n
- L'objet de votre message : $objet
- La nature demande : $demande
- Votre message :
$message

Merci et à bientôt sur $mon_url !";

    // Envoie du mail
    $entete = "From: ScanEpitaphe by Scanstele" . $mon_email . ""; // On prépare l'entête du message
    $entete .= "";

    if (@mail($mon_email,$objet,$msg_pour_moi,$entete) && @mail($email,$objet,$accuse_pour_lui,$entete)){ // Si le mail a été envoyé
        echo "<p style=\"text-align:center\">Votre message a été envoyé, vous recevrez une confirmation par mail.<br /><br />\n"; // On affiche un message de confirmation
        echo "<a href=\"" . $mon_url . "\">Retour</a></p>\n"; // Avec un lien de retour vers l'accueil du site
    }
    else { // Sinon il y a eu une erreur lors de l'envoi
        echo "<p style=\"text-align:center\">Un problème s'est produit lors de l'envoi du message.\n";
        echo "<a href=\"".$_SERVER["PHP_SELF"]."\">Réessayez...</a></p>\n"; // On propose un lien de retour vers le formulaire
    }
}
?>
    <?php endforeach; ?>
      </div>
    </div>
</div>
