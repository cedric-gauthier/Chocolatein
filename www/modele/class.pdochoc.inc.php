<?php
###test commit
class PdoChoc {

    private static $serveur = 'mysql:host=127.0.0.1';
    private static $bdd = 'dbname=chocolatein_vuln';
    private static $user = 'admin';
    private static $mdp = 'P@ssw0rdMariaDB';
    private static $monPdo;
    private static $monPdoChoc = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct() {
        try {
            PdoChoc::$monPdo = new PDO(
                    PdoChoc::$serveur . ';' . PdoChoc::$bdd,
                    PdoChoc::$user,
                    PdoChoc::$mdp
            );
            PdoChoc::$monPdo->query('SET CHARACTER SET utf8');
        } catch (PDOException $e) {
            echo "Une erreur s'est produite, merci de rééssayer dans quelques instants...";
            throw $e;
        }
    }

    /**
     * Méthode destructeur appelée dès qu'il n'y a plus de référence sur un
     * objet donné, ou dans n'importe quel ordre pendant la séquence d'arrêt.
     */
    public function __destruct() {
        PdoChoc::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoChoc = PdoChoc::getPdoChoc();
     *
     * @return l'unique objet de la classe PdoChoc
     */
    public static function getPdoChoc() {
        if (PdoChoc::$monPdoChoc == null) {
            PdoChoc::$monPdoChoc = new PdoChoc();
        }
        return PdoChoc::$monPdoChoc;
    }

    /**
     * Retourne tous les id de la table Gamme
     *
     * @return un tableau associatif
     */
    public function getLesIdGamme() {
        $requete = 'SELECT id FROM gamme ORDER BY id';
        $res = PdoChoc::$monPdo->query($requete);
        return $res->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    /**
     * Retourne le libelle pour une gamme donnée en argument.
     *
     * @param String $idGamme ID de la gamme
     *
     * @return le libelle pour une gamme donnée en argument.
     */
    public function getLeLibelleGamme($idGamme) {
        $requete = "SELECT libelle FROM gamme WHERE id = '$idGamme'";
        $res = PdoChoc::$monPdo->query($requete);
        $leLibelleGamme = $res->fetch();
        return $leLibelleGamme['libelle'];
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les gammes
     *
     * @return toutes les gammessous la forme d'un tableau 
     * associatif
     */
    public function getLesGammes() {
        $requete = 'SELECT * FROM gamme';
        $res = PdoChoc::$monPdo->query($requete);
        return $res->fetchAll();
    }

    /**
     * Retourne sous forme d'un tableau associatif tous les produits
     * pour une gamme donnée en argument.
     *
     * @param String $idGamme ID de la gamme
     *
     * @return tous les produits de la gamme sous la forme d'un tableau 
     * associatif
     */
    public function getLesProduits($idGamme) {
        $requete = "SELECT * FROM produit WHERE idgamme = '$idGamme'";
        $res = PdoChoc::$monPdo->query($requete);
        return $res->fetchAll();
    }

    /**
     * Retourne tous les id de la table produit
     *
     * @return un tableau associatif
     */
    public function getLesIdProduit() {
        $requete = 'SELECT id FROM produit ORDER BY id';
        $res = PdoChoc::$monPdo->query($requete);
        return $res->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    /**
     * Retourne sous forme d'un tableau associatif le produit
     * pour un id donné en argument.
     *
     * @param String $idGamme ID de la gamme
     *
     * @return le produit pour un id donné en argument
     */
    public function getLeProduit($id) {
        $requete = "SELECT * FROM produit WHERE id = '$id'";
        $res = PdoChoc::$monPdo->query($requete);
        return $res->fetch();
    }

    /**
     * Retourne tous les détails d'un produit passé en paramètre
     *
     * @return un tableau associatif
     */
    public function getLesDetailsProduit($id) {
        $requete = "SELECT details FROM details_produits WHERE idproduit = '$id' ORDER BY num";
        $res = PdoChoc::$monPdo->query($requete);
        return $res->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    /**
     * Enregistre les informations de contacts dans la base
     *
     * @return void
     */
    public function setLeContact($personne, $statut, $mail, $tel, $ville, $site, $message) {
        $requete = 'INSERT INTO contact (personne, statut, mail, telephone, ville, site, message) '
                . "VALUES ('$personne', '$statut', '$mail', '$tel', '$ville', '$site', '$message')";
        $res = PdoChoc::$monPdo->query($requete);
        return $res->execute();
    }

    /**
     * Enregistre les demandes d'inscriptions à l'infolettre
     *
     * @return void
     */
    public function setInscriptionInfolettre($mail) {
        $requete = "INSERT INTO infolettre (email, confirmation, dateconfirmation) VALUES ('$mail', 0, null)";
        $res = PdoChoc::$monPdo->query($requete);
        return $res->execute();
    }

    /**
     * Retourne tous les produits qui contiennent l'expression recherchée
     *
     * @return un tableau associatif
     */
    public function getListeProduits($expression) {
        $requete = 'SELECT DISTINCT produit.* '
                 . 'FROM produit LEFT JOIN details_produits '
                 . 'ON produit.id=details_produits.idproduit '
                 . "WHERE nom LIKE '%$expression%' "
                 . "   OR description LIKE '%$expression%' "
                 . "   OR details LIKE '%$expression%' ";
        $res = PdoChoc::$monPdo->query($requete);
        return $res->fetchAll();
    }

}
