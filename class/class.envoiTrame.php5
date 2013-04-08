<?php

include_once('/var/www/domocan/www/conf/config.php');

class envoiTrame {

  /* PREPARATION DU CHECKSUM */
  function checksum() {

    for ($i = 0; $i <= 14; $i++) {
      $check = $this->trame[$i] + $check;
    }

    $this->trame[15] = $check % 256;  
  }

  /* CONVERSION DE LA TRAME AVEC PACK() */
  function conversion() {
    for ($i = 0; $i <= 15; $i++) {
      $this->trame_ok .= pack("c", $this->trame[$i]);
      $trame .= $this->trame[$i];
    }
  }

  /* ENVOI DE LA TRAME SUR L'INTERFACE */
  function envoiTrame() {

    $socket = socket_create(AF_INET, SOCK_DGRAM, 0);
    $longueur = strlen($this->trame_ok);
    socket_sendto($socket, $this->trame_ok, $longueur, 0, ADRESSE_INTERFACE, 1470);
    socket_close($socket);

  }

  /* PREPARE UNE TRAME CAN */
  function CAN($entete, $IDCAN = array(), $donnees = array()) {

    $this->trame[0] = $entete; // ENVOI D'UNE TRAME CAN
    $this->trame[1] = 0xfa; // ID DU PC QUI ENVOI
    $this->trame[2] = dechex(count($IDCAN) + count($donnees)); // NOMBRE D'OCTETS DE DATA

    if ( isset($IDCAN[DEST]) ) {
      $this->trame[3] = $IDCAN[DEST]; // TYPE DE CARTE (CAN)
    }
    else {
      $this->trame[3] = 0x00;
    }
 
   if ( isset($IDCAN[COMM]) ) {
      $this->trame[4] = $IDCAN[COMM]; // COMMANDE (CAN)
    }
    else { 
      $this->trame[4] = 0x00; 
    }

    if ( isset($IDCAN[CIBL]) ) {
      $this->trame[5] = $IDCAN[CIBL]; // CIBLE (CAN)
    }
    else { 
      $this->trame[5] = 0x00; 
    }

    if ( isset($IDCAN[PARA]) ) {
      $this->trame[6] = $IDCAN[PARA]; // PARAMETRE (CAN)
    }
    else { 
      $this->trame[6] = 0x00; 
    }

    $i = '7';
    foreach ($donnees as $valeur) {
      $this->trame[$i] = $valeur;
      $i++;
    }

    while ( $i <= 14 ) {
      $this->trame[$i] = 0x00;
      $i++;
    }

  }

  /* ARCHIVE VERS SQL */
  function logs($id_gradateur, $id_sortie, $valeur) {
    if (DEBUG_AJAX) {
      mysql_connect(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PWD);
      mysql_select_db(MYSQL_DB);
      mysql_query("INSERT INTO `logs` (id_gradateur,id_sortie,valeur) VALUES ('$id_gradateur', '$id_sortie', '$valeur')");
      mysql_close();
	}

  }

  /* ACCUSE VERS SQL */
  function accuse($id_gradateur, $id_sortie, $valeur) {

    mysql_connect(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PWD);
    mysql_select_db(MYSQL_DB);

    /* POUR RETOUR CHAUFFAGE */
    if ( $id_gradateur == '0x' . CARTE_CHAUFFAGE && $id_sortie == SORTIE_CHAUFFAGE ) {
      if ( $valeur == '32' ) {
        mysql_query("UPDATE `" . TABLE_CHAUFFAGE_CLEF . "` SET `valeur` = '1' WHERE `clef` = 'chaudiere'");
        $ch = curl_init(URIPUSH);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "chaudiere;En marche");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ret = curl_exec($ch);
        curl_close($ch);
      }
      else {
        mysql_query("UPDATE `" . TABLE_CHAUFFAGE_CLEF . "` SET `valeur` = '0' WHERE `clef` = 'chaudiere'");
        $ch = curl_init(URIPUSH);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "chaudiere;A l'arrêt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ret = curl_exec($ch);
        curl_close($ch);
      }
    }
    else {
      mysql_query("UPDATE `" . TABLE_LUMIERES . "` SET `valeur` = '" . $valeur . "' WHERE `carte` = '" . $id_gradateur . "' AND `sortie` = '0x" . $id_sortie . "'");
    }

    mysql_close();

  }

}

?>
