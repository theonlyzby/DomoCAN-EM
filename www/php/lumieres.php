<?php

  $titre = 'Gestion des points lumineux';

  include '../class/class.envoiTrame.php5';
  include '../class/class.gradateur.php5';

  /* DECLARATION DES FONCTIONS EN AJAX */
  $xajax->register(XAJAX_FUNCTION, 'inverser');
  $xajax->register(XAJAX_FUNCTION, 'allumerall');
  $xajax->register(XAJAX_FUNCTION, 'eteindreall');
  $xajax->register(XAJAX_FUNCTION, 'modenuit');

  /* FONCTIONS PHP AJAX */
  function inverser($carte, $sortie) {
    $reponse = new XajaxResponse();
    $gradateur = new gradateur();
    $gradateur->inverser($carte, $sortie);
    $reponse->script("$('#traitement').css('display', 'none')");
    return $reponse;
  }

  function allumerall($localisation) {
    $reponse = new XajaxResponse();
    $gradateur = new gradateur();
    mysql_connect(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PWD);
    mysql_select_db(MYSQL_DB);
    $retour = mysql_query("SELECT * FROM `" . TABLE_LUMIERES . "` WHERE `localisation` = '" . $localisation . "'");
    while ( $row = mysql_fetch_array($retour) ) {
      $gradateur->allumer($row['carte'], hexdec(substr($row['sortie'], 2, 3)));
      sleep(1);
    }
    mysql_close();
    $reponse->script("$('#traitement').css('display', 'none')");
    return $reponse;
  }

  function eteindreall($localisation) {
    $reponse = new XajaxResponse();
    $gradateur = new gradateur();
    mysql_connect(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PWD);
    mysql_select_db(MYSQL_DB);
    $retour = mysql_query("SELECT * FROM `" . TABLE_LUMIERES . "` WHERE `localisation` = '" . $localisation . "'");
    while( $row = mysql_fetch_array($retour) ) {
      $gradateur->eteindre($row['carte'], hexdec(substr($row['sortie'], 2, 3)));
      sleep(1);
    }
    mysql_close();
    $reponse->script("$('#traitement').css('display', 'none')");
    return $reponse;
  }

  /* ACTIVATION - DESACTIVATION MODE NUIT FORCEE */
  function modenuit() {
    $reponse = new XajaxResponse();
    mysql_connect(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PWD);
    mysql_select_db(MYSQL_DB);
    $retour = mysql_query("SELECT `valeur` FROM `" . TABLE_LUMIERES_CLEF . "` WHERE `clef` = 'nuit'");
    $row = mysql_fetch_array($retour);
    if ( $row['valeur'] == '1' ) {
      $tmp = 'php ' . PATHBIN . 'mode_nuit.php off';
      exec($tmp);
    } else if ( $row['valeur'] == '0' ) {
      $tmp = 'php ' . PATHBIN . 'mode_nuit.php on';
      exec($tmp);
    }
    mysql_close();
    $reponse->script("$('#traitement').css('display', 'none')");
    return $reponse;
  }

  /* CONNEXION BDD */
  mysql_connect(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PWD);
  mysql_select_db(MYSQL_DB);

  /* AFFICHAGE DES PLANS ET DES POINTS LUMINEUX */
  $retour0 = mysql_query("SELECT `lieu` FROM `" . TABLE_LOCALISATION . "`");
  while( $row0 = mysql_fetch_array($retour0) ) {

    if ( $row0['lieu'] == DEFAUT_LOCALISATION ) {
      $_XTemplate->assign('CACHER', 'display: block;');
    }
    else {
      $_XTemplate->assign('CACHER', 'display: none;');
    }


    $retour = mysql_query("SELECT * FROM `" . TABLE_LUMIERES . "` WHERE `localisation` = '" . $row0['lieu'] . "'");
    while( $row = mysql_fetch_array($retour) ) {
      if ( $row['valeur'] != '0' ) {
        $lumiere = "on";
      } else {
        $lumiere = "off";
      }
      $_XTemplate->assign('LUMIERE', $lumiere);
      $_XTemplate->assign('IMG_X',   $row['img_x']);
      $_XTemplate->assign('IMG_Y',   $row['img_y']);
      $_XTemplate->assign('CARTE',   $row['carte']);
      $_XTemplate->assign('SORTIE',  $row['sortie']);
      $_XTemplate->parse('main.PLAN.AMPOULE');
    }
    $_XTemplate->assign('LOCALISATION', $row0['lieu']);
    $_XTemplate->parse('main.PLAN');

  }

  /* AFFICHAGE DES NIVEAUX */
  $retour = mysql_query("SELECT * FROM `localisation`");
  while( $row = mysql_fetch_array($retour) ) {
    $_XTemplate->assign('LOCALISATION', $row['lieu']);
    $_XTemplate->parse('main.NIVEAU');
  }

  /* AFFICHAGE ETAT DU MODE NUIT */
  $retour = mysql_query("SELECT `valeur` FROM `" . TABLE_LUMIERES_CLEF . "` WHERE `clef` = 'nuit'");
  $row = mysql_fetch_array($retour);
  if ( $row['valeur'] == '1' ) {
    $_XTemplate->assign('MODENUIT', 'Activé');
  } else if ( $row['valeur'] == '0' ) {
    $_XTemplate->assign('MODENUIT', 'Désactivé');
  }

  /* FERMETURE BDD */
  mysql_close();

?>
