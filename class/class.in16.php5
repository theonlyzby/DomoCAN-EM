<?php

class in16 extends envoiTrame {

  function __construct() {

    $this->debug = new debug();
    $this->gradateur = new gradateur();

  }


  /*
    RECEPTION D'UNE TRAME A DESTINATION D'UNE CARTE IN16
  */
  function reception($COMMANDE, $CIBLE, $PARAMETRE, $D0, $D1, $D2, $D3, $D4, $D5, $D6, $D7) {

    switch ($COMMANDE) {

      /* EN CAS DACTION */
      case '18' :

        /* ACTION SPECIFIQUE : OUVERTURE SON OU FERMETURE SON */
        if ( $CIBLE == '04' && $PARAMETRE == '03' ) {
          if ( ($D0 == "22") || ($D0 == "26") || ($D0 == "32") ) {
            $a = `/usr/local/mpc/bin/mpc2 | grep playing | wc -l`;
            if ( $a == 1 ) {
              $cmd = '/usr/local/mpc/bin/mpc2 stop';
            }
            else {
              $cmd = '/usr/local/mpc/bin/mpc2 play';
            }
            exec($cmd);
          }
          if ( ($D0 == "52") || ($D0 == "42") || ($D0 == "46") ) {
            $volume = `cat /var/www/domocan/var/volume_sdb`;
            if ( $volume > 0 ) {
              $volume_new = $volume - 5;
              $tmp = 'amixer -c1 set Speaker,1 ' . $volume_new . '%';
              exec($tmp);
              $tmp = 'echo ' . $volume_new . ' > /var/www/domocan/var/volume_sdb';
              exec($tmp);
            }
          }
        }

        if ( $CIBLE == '04' && $PARAMETRE == '07' ) {
          if ( ($D0 == "22") || ($D0 == "26") || ($D0 == "32") ) {
            $cmd = '/usr/local/mpc/bin/mpc2 next';
            exec($cmd);
          }
          if ( ($D0 == "52") || ($D0 == "42") || ($D0 == "46") ) {
            $volume = `cat /var/www/domocan/var/volume_sdb`;
            if ( $volume < 100 ) {
              $volume_new = $volume - 5;
              $tmp = 'amixer -c1 set Speaker,1 ' . $volume_new . '%';
              exec($tmp);
              $tmp = 'echo ' . $volume_new . ' > /var/www/domocan/var/volume_sdb';
              exec($tmp);
            }
          }
        }

        /* ACTION LUMIERE CLASSIQUE */
        mysql_connect(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PWD);
        mysql_select_db(MYSQL_DB);
        $row = mysql_query("SELECT `id`,`sortie_carte`,`sortie_num`,`actif` FROM `entree` WHERE `carte` = '" . $CIBLE . "' AND `entree` = '0x" . $PARAMETRE . "'");
        $retour = mysql_fetch_array($row);
        if ( $retour[sortie_carte] != "" && $retour[sortie_num] != "" ) {
          $row2 = mysql_query("SELECT `valeur_souhaitee` FROM `" . TABLE_LUMIERES . "` WHERE `carte` = '" . $retour[sortie_carte] . "' AND `sortie` = '" . $retour[sortie_num] . "'");
          $retour2 = mysql_fetch_array($row2);

          /* ALLUMAGE OU EXTINCTION COMPLET */
          if ( (($D0 == "22") || ($D0 == "26") || ($D0 == "32")) ) {
            if ($retour['actif']) { 
              $this->gradateur->inverser($retour['sortie_carte'], hexdec(substr($retour['sortie_num'],2,3)), $retour2['valeur_souhaitee']);
            }
          }

          /* ALLUMAGE OU EXTINCTION EN PROGRESSION */
          if ( (($D0 == "52") || ($D0 == "42") || ($D0 == "46")) ) {
            if ($retour['actif']) {
              $this->gradateur->togalnum($retour['sortie_carte'], hexdec(substr($retour['sortie_num'],2,3)), $retour2['valeur_souhaitee']);
            }
          }

          /* ALLUMAGE OU EXTINCTION EN PROGRESSION */
          if ( $D0 == "8a" ) {
            if ($retour['actif']) {
              $this->gradateur->stopalnum($retour['sortie_carte'], hexdec(substr($retour['sortie_num'],2,3)), $retour2['valeur_souhaitee']);
            }
          }


          /* ALLUMAGE PROGRESSIF (POUR CAPTEUR) */
          if (($D0 == "53") || ($D0 == "43")) {
            if ($retour['actif']) {
              $this->gradateur->allumer($retour['sortie_carte'], hexdec(substr($retour['sortie_num'],2,3)), 0x02, $retour2['valeur_souhaitee']);
            }
          }
        }

        break;

        mysql_close();

    }

  }

  /*
    LIRE LE STATUT D'UNE FONCTION EN EEEPROM

    $cible => NUMERO DE CARTE D'ENTREE
    $entree => NUMERO DE L'ENTREE DE CETTE CARTE

  */
  function lireStatut($cible = 0xfe, $entree = 0x01) {
    $IDCAN[DEST] = 0x60;
    $IDCAN[COMM] = 0x02;
    $IDCAN[CIBL] = $cible;
    $IDCAN[PARA] = $entree;
    $donnees     = array();
    $this->CAN(0x60,$IDCAN,$donnees);
    $this->checksum();
    $this->conversion();
    $this->envoiTrame();
  }

  /*
    MODIFIER UNE FONCTION EN NORMALEMENT FERME

    $cible => NUMERO DE CARTE D'ENTREE
    $entree => NUMERO DE L'ENTREE DE CETTE CARTE

  */
  function normalementFerme($cible = 0xfe, $entree = 0x01) {
    $IDCAN[DEST] = 0x60;
    $IDCAN[COMM] = 0x01;
    $IDCAN[CIBL] = $cible;
    $IDCAN[PARA] = $entree;
    $donnees[0]  = 0xfc;
    $donnees[1]  = 0x03;
    $donnees[2]  = 0x00;
    $this->CAN(0x60,$IDCAN,$donnees);
    $this->checksum();
    $this->conversion();
    $this->envoiTrame();
  }


}
?>
