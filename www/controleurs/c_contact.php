<?php

/**
 * Gestion de l'affichage du formulaire de contact
 *
 * PHP Version 7
 *
 * @category  B13
 * @package   ChocolateIn
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2020 José GIL
 * @license   José GIL
 * @version   GIT: <0>
 * @link      https://chocolatein.gil83.fr Contexte « Chocolate'In »
 */
$action = isset($_GET['action']) ? $_GET['action'] : '';
$personne = isset($_POST['ident']) ? $_POST['ident'] : '';
$statut = isset($_POST['statut']) ? $_POST['statut'] : '';
$mail = isset($_POST['email']) ? $_POST['email'] : '';
$tel = isset($_POST['tel']) ? $_POST['tel'] : '';
$ville = isset($_POST['ville']) ? $_POST['ville'] : '';
$site = isset($_POST['site']) ? $_POST['site'] : '';
$message = isset($_POST['msg']) ? $_POST['msg'] : '';
if (!empty($action)) {
    if ($action === "envoiContact") {
        $envoiReussi = $pdo->setLeContact($personne, $statut, $mail, $tel, $ville, $site, $message);
    }
}
include 'vues/v_contact.php';
