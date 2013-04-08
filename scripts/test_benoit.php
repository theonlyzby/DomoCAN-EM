<?php

include_once('/var/www/domocan/class/class.envoiTrame.php5');
include_once('/var/www/domocan/class/class.gradateur.php5');
include_once('/var/www/domocan/class/class.communes.php5');
include_once('/var/www/domocan/class/class.admin.php5');
include_once('/var/www/domocan/class/class.in16.php5');
include_once('/var/www/domocan/class/class.debug.php5');

$gradateur = new gradateur();
$admin = new admin();
$in16 = new in16();
$communes = new communes();

if ( $argv[1] == 'onall' ) {
  $gradateur->allumer(0xff, 0x10, 0);
}
if ( $argv[1] == 'onetage' ) {
  $gradateur->allumer(0x03, 0x5, 0);
}
if ( $argv[1] == 'onetagenuit' ) {
  $gradateur->allumer(0x03, 0xa, 2, 0xa);
}
if ( $argv[1] == 'offetage' ) {
  $gradateur->eteindre(0x03, 0x5);
}
if ( $argv[1] == 'offall' ) {
  $gradateur->eteindre(0xff, 0x10,0);
}
if ( $argv[1] == 'on1' ) {
  $gradateur->allumer(0x03, 0x04, 0);
}
if ( $argv[1] == 'off1' ) {
  $gradateur->eteindre(0x03, 0x04, 0);
}
if ( $argv[1] == 'on2' ) {
  $gradateur->allumer(0x03, 0x02, 0, dechex($argv[2]));
}
if ( $argv[1] == 'off2' ) {
  $gradateur->eteindre(0x03, 0x02, 0);
}
if ( $argv[1] == 'on3' ) {
  $gradateur->allumer(0x01, 0xc, 2);
}
if ( $argv[1] == 'off3' ) {
  $gradateur->eteindre(0x01, 0xc, 2);
}
if ( $argv[1] == 'on4' ) {
  $gradateur->allumer(0x01, 0xa, 500);
}
if ( $argv[1] == 'off4' ) {
  $gradateur->eteindre(0x01, 0xa, 500);
}
if ( $argv[1] == 'state' ) {
  $in16->lireStatut(0x04, 0x0a);
}
if ( $argv[1] == 'u' ) {
  $in16->normalementFerme(0x04, 0x0a);
}
if ( $argv[1] == 'stop' ) {
  $admin->stop();
}
if ( $argv[1] == 'parametres' ) {
  $admin->parametresCAN();
}

if ( $argv[1] == 'v' ) {
  $communes->modifierCible(0x60, 0xfe, 0x02);
}
if ( $argv[1] == 'inv' ) {
  $gradateur->togalnum(0xff, 0x10);
}
if ( $argv[1] == 'nom' ) {
  $communes->lireNom(0x60, 0xff);
}
if ( $argv[1] == 'infos' ) {
  $communes->informations(0x60, 0x04);
}
if ( $argv[1] == 'boot' ) {
  $communes->entrerBootloader(0x60, 0xfe);
}
if ( $argv[1] == 'noboot' ) {
  $communes->sortirBootloader(0x60, 0xfe);
}
if ( $argv[1] == 'zone' ) {
  $communes->lireZoneUtilisateur(0x50, 0xfe);
}
if ( $argv[1] == 'varier' ) {
  $gradateur->varier(0x01, 0x0c, 0, 0x05, 40);
}
?>
