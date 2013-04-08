


<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width; initial-scale=0.8; maximum-scale=0.8; user-scalable=no;"/>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<title>Nest Thermostat for DomoCAN - Original Source:  - original soure: http://homeautomategorilla.blogspot.be</title>



<style>

body, div {
  -moz-user-select: none;
  user-select: none;  
  -webkit-user-select: none;
  -webkit-tap-highlight-color: rgba(0,0,0,0);    
}

a img {		border: none;
  	  }
a {		color: #FFF;
  }

 /* Fontes utilisées */  
@font-face {
    font-family: "N_E_B";
    src: url(N_E_B.TTF) format("truetype");
    }
	
@font-face {
    font-family: "MANDATOR";
    src: url(MANDATOR.TTF) format("truetype");
    }
	
.desc {
 position:relative;
 left:22;
 top:22;
 }
 /* Le grand cercle noir glossy */
.full-circle {
 position:relative;
 left:22;
 top:22;
 border: 3px solid #333;
 height: 350px;
 width: 350px;
 -moz-border-radius:350px;
 -webkit-border-radius: 350px;
  background: #cbcefb;
 /* Permet de ne pas pouvoir être sélectionné */
 -webkit-touch-callout: none;
 -webkit-user-select: none;
 -khtml-user-select: none;
 -moz-user-select: none;
 -ms-user-select: none;
 user-select: none;
 /* Permet de mettre un dégradé sur le cercle en fonction de tous les navigateurs */
 background: #eaeaea; /* Old browsers */
 background: -webkit-radial-gradient(top left, ellipse cover, #eaeaea 0%,#eaeaea 11%,#0e0e0e 61%); /* Chrome10+,Safari5.1+ */
 background: -moz-radial-gradient(top left, ellipse cover,  #eaeaea 0%, #eaeaea 11%, #0e0e0e 61%); /* FF3.6+ */
 background: -webkit-gradient(radial, top left, 0px, top left, 100%, color-stop(0%,#eaeaea), color-stop(11%,#eaeaea), color-stop(61%,#0e0e0e)); /* Chrome,Safari4+ */
 background: -o-radial-gradient(top left, ellipse cover,  #eaeaea 0%,#eaeaea 11%,#0e0e0e 61%); /* Opera 12+ */
 background: -ms-radial-gradient(top left, ellipse cover,  #eaeaea 0%,#eaeaea 11%,#0e0e0e 61%); /* IE10+ */
 background: radial-gradient(top left, ellipse cover,  #eaeaea 0%,#eaeaea 11%,#0e0e0e 61%); /* W3C */
 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eaeaea', endColorstr='#0e0e0e',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}

/* Fond chromé, j'utilise ici une image d'un disque brossé */
.fond {
  position:relative;
  background-image: url(fond.png);
  background-repeat: no-repeat;
  width: 400px;
  height: 400px;
  /*left: 45%;
  /*top:20%;
  /* Permet de replir la totalité de la zone */
  background-size:cover;
  /* Permet de ne pas pouvoir être sélectionné */
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* La petite feuille nest, affichée en cas d'économie d'énergie, ici lorsqu'on baisse la t° ou le ventilo */
.feuille {
  position:relative;
  top:-220px;
  left:90px;
  background-image: url(feuille.png);
  background-repeat: no-repeat;
  width: 32px;
  height: 32px;
  z-index:auto;
  /* non affichée par défaut */
  opacity:0;
  /* Permet de ne pas pouvoir être sélectionné */
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  /* Alignement */
  text-align: center;
}

/* La petite flamme, affichée en cas de demande de chauffage immédiate, disparait en cliquant desssus */
.fire {
  position:relative;
  top:-180px;
  left:90px;
  background-image: url(fire.png);
  background-repeat: no-repeat;
  width: 32px;
  height: 32px;
  z-index:auto;
  /* non affichée par défaut */
  opacity:0;
  /* Permet de ne pas pouvoir être sélectionné */
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  text-align: center;
}

/* La valeur NEST affichée, soit Température, soit % ventilo soit demande chauffage immédiat */
.nestValue {
position:relative;
  top:-100;
  left:-10;
  font-family: "MANDATOR", Verdana, Tahoma;
  font-size:60px;
  color:#ffffff;
  /* Permet de ne pas pouvoir être sélectionné */
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  text-align: center;
}

/* En cas de demande immédiate de chauffage, durée de demande ici 2h  */
.hour {
  position:relative;
  top:-160;
  left:60;
  font-family: "MANDATOR", Verdana, Tahoma;
  font-size:20px;
  color:#ffffff;
  /* Permet de ne pas pouvoir être sélectionné */
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;

  opacity:0;
  z-index:500;
}

/* En cas de demande immédiate de chauffage, durée de demande ici 4h  */
.hour2 {
  position:relative;
  top:-206;
  left:120;
  font-family: "MANDATOR", Verdana, Tahoma;
  font-size:20px;
  color:#ffffff;
  /* Permet de ne pas pouvoir être sélectionné */
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;

  opacity:0;
  z-index:500;
}

* En cas de demande immédiate de chauffage, durée de demande ici 2h  */
.consigne {
  position:relative;
 
  font-family: "MANDATOR", Verdana, Tahoma;
  font-size:10px;
  color:#ffffff;
  /* Permet de ne pas pouvoir être sélectionné */
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  display:none;
  opacity:0;
  z-index:500;
}

/* Mode Nest: Température, Fan, ou demande chauffage */
.nestMode {
position:relative;
  top:-30;
  left:-10;
  font-family: "MANDATOR", Verdana, Tahoma;
  font-size:20px;
  color:#ffffff;
  /* Permet de ne pas pouvoir être sélectionné */
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;

  text-align: center;
}

/* Titre nest, en cliquant les fonctions apparaissent */
.nestTitle {
  position:relative;
  top:-50;
  left:85;
  font-family: "N_E_B", Verdana, Tahoma;
  font-size:30px;
  color:#ffffff;
  z-index:100;
}


/* Le cercle bleu interne */
.center-circle-cold{
 position:relative;
 left:65;
 top:35;
 border: 0px solid #333;
 height: 220px;
 width: 220px;
 -moz-border-radius:220px;
 -webkit-border-radius: 220px;

  
 /* Dégradé circulaire */
 background: #3e61a8; /* Old browsers */
 background: -webkit-radial-gradient(top left, ellipse cover, #fff9f9 10%,#0338ac 60%); /* Chrome10+,Safari5.1+ */
 background: -moz-radial-gradient(top left, ellipse cover,  #eaeaea 0%, #fff9f9 10%, #0338ac 60%); /* FF3.6+ */
 background: -webkit-gradient(radial, top left, 0px, top left, 100%, color-stop(0%,#eaeaea), color-stop(10%,#fff9f9), color-stop(60%,#0338ac)); /* Chrome,Safari4+ */
 background: -o-radial-gradient(top left, ellipse cover,  #eaeaea 0%,#fff9f9 10%,#0338ac 60%); /* Opera 12+ */
 background: -ms-radial-gradient(top left, ellipse cover,  #eaeaea 0%,#fff9f9 10%,#0338ac 60%); /* IE10+ */
 background: radial-gradient(top left, ellipse cover,  #eaeaea 0%,#fff9f9 10%,#0338ac 60%); /* W3C */
 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eaeaea', endColorstr='#0338ac',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */

 /* Permet de ne pas pouvoir être sélectionné */
 -webkit-touch-callout: none;
 -webkit-user-select: none;
 -khtml-user-select: none;
 -moz-user-select: none;
 -ms-user-select: none;
 user-select: none;
}

/*----------------------------
	Barres de progression colorées
-----------------------------*/


#bars{
    
	height: 212px;
	margin: 0 auto;
	position: relative;
	top: 10px;
	left: 2px;
	width: 228px;
	-webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
     user-select: none;
}

.colorBar{
	width:15px;
	height:1px;
	position:absolute;
	opacity:0;
	background-color : #F4F4F4;
	-moz-transition:1s;
	-webkit-transition:1s;
	-o-transition:1s;
	transition:1s;
	-webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.colorBar.active{
	opacity:1;
}


</style>






<!-- <script src="./jquery.min.js" type="text/javascript"></script> !-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="./jQueryRotateCompressed.js"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
		
<style type="text/css"></style>



<script type="text/javascript">

        /* <![CDATA[ */
   google.load("jquery", "1.4.2");

   function listen(last_modified, etag) {
       $.ajax({
           'beforeSend': function(xhr) {
               xhr.setRequestHeader("If-None-Match", etag);
               xhr.setRequestHeader("If-Modified-Since", last_modified);
           },
           url: '/domocan/reception',
           dataType: 'text',
           type: 'get',
           cache: 'false',
           success: function(data, textStatus, xhr) {
               etag = xhr.getResponseHeader('Etag');
               last_modified = xhr.getResponseHeader('Last-Modified');

               div = $('<div class="msg">').text(data);
               info = $('<div class="info">').text('Last-Modified: ' + last_modified + ' | Etag: ' + etag);

               $('#data').prepend(div);
               /* $('#data').prepend(info); */

               /* Start the next long poll. */
               listen(last_modified, etag);
           },
           error: function(xhr, textStatus, errorThrown) {
               $('#data').prepend(textStatus + ' | ' + errorThrown);
           }
       });
   };

   
   google.setOnLoadCallback(function() {
       /* Start the first long poll. */
       /* setTimeout is required to let the browser know
          the page is finished loading. */
		
       setTimeout(function() {
           listen('Thu, 1 Jan 1970 00:00:00 GMT', '0');
       }, 500);
   });
        /* ]]> */




// Fonction permettant de dessiner les bars de progression
$(document).ready(function(){
	var rad2deg = 180/Math.PI;
	var deg = 0;
	var bars = $('#bars');
	var j=0;
	for(var i=-20;i<82;i++){
		deg = i*3;
		//console.log(deg);
		// Creation des barres
		mytop =(-Math.sin(deg/rad2deg)*95+100);
		myleft = Math.cos((180 - deg)/rad2deg)*95+100;
		// On ajoute ici 82 barres en indiquant à chacune l'angle de rotation
	$('<div id=barre' + j + ' name=barre' + j + ' class="colorBar" style="-webkit-transform: rotate(' + deg + 'deg); -moz-transform: rotate(' + deg + 'deg) scale(1.25, 0.5); -ms-transform: rotate(' + deg + 'deg) scale(1.25, 0.5);transform: rotate(15deg) scale(1.25, 0.5);top: '+ mytop + '; left: ' + myleft+ ' ; color:red" >')
		.appendTo(bars);	
		j++;
	}
	var colorBars = bars.find('.colorBar');
	var numBars = 0, lastNum = -1;
	// ici on les désactive toutes en utilisant la css active sur les éléments de 0 à 0. donc rien.
    colorBars.removeClass('active').slice(0, 0).addClass('active');
})


$(document).ready(function(){    
$("body").on("touchmove", false);

// Fonction principale, ici un tableau de couleurs dégradées
var grad = [
		'243594','2c358f','373487','44337e','513174',
		'5c306c','6b2f62','792e58','892d4d','9e2b3d',
		'b4292e','c9271f','e0250e'];

// Dernier angle calculé
var lastAngle=0;
// Savoir si le bouton de souris est pressé.
var mouseDown="";
// temperature par défaut
var temperature=19;
// temperature affichée sur le controleur Nest pas défaut.
var temperatureNest=19;
// soufflante par défaut
var airwave=50;
// soufflante affichée sur le controleur Nest par défaut.
var airwaveNest=50;
// ratio utilisé pour synchroniser les barres et le mode température
var ratioTemperature=4;
// ratio utilisé pour synchroniser les barres et le mode soufflante
var ratioAirwave=1;
// couleur de fond pour la temperature (par défaut)
var couleurFondTemperature="#243594";
// couleur de fond pour la soufflante (par défaut)
var couleurFondAirwave="#243594";
// couleur de fond pour autoaway
var couleurFondAutoAway="#000000";
// mode par défaut ici TEMP
var currentMode="TEMP";
// Savoir si on est en mode Demande de chauffage Now
var heatNow = "";
// Temperature courante remontée par une sonde 
var currentTemperature=20;

var consigne=$('#consigne');

// Calibrage des rotations, pour l'affichage uniquement, rien de fonctionnel
for(var i=0;i<3600;i++){
$('#full-circle').rotate(Math.round(i));  

}

// Permet de positionner la temperature de consigne sur les barres
function poseConsigne(numBar,val)
{
        var rad2deg = 180/Math.PI;
		deg = numBar*3;
		//console.log(deg);
		// Creation des barres
		mytop =(-Math.sin(deg/rad2deg)*95+100);
		myleft = Math.cos((180 - deg)/rad2deg)*95+100;
		
		
		
		//console.log("myleft=" + Math.round(myleft));
		var colorbar = $('#barre' + numBar)
		
		if  ( colorbar != null )
		{
		var colorbarOffset = colorbar.offset();
		//console.log("LEFT: " + colorbar.left);
		if ( colorbarOffset != null )
		{
		consigne.css("position","absolute");
		consigne.css("left",colorbarOffset.left);
		consigne.css("top",colorbarOffset.top);
		//for(var i=0;i<102;i++){
		//var colorbarTmp = $('#barre' + i);
		//colorbarTmp.css("height",1);
		//}
		//colorbar.css("height",4);
		}
		//console.log("NUMBAR: " + numBar);
		}
		consigne.css("font-family","MANDATOR");
		consigne.html(val);
};

// Définition de la fonction pour gestion de temperature
function manageTemperature(e) {
    var offset = $('#full-circle').offset();
    var width=$('#full-circle').width();
    var height=$('#full-circle').height();
    var center_x = (offset.left) + (width/2);
    var center_y = (offset.top) + (height/2);
    var mouse_x = e.pageX; var mouse_y = e.pageY;
	var bars = $('#bars');
	var centerCircle = $('#center-circle-cold');
	var colorBars = bars.find('.colorBar');
	var feuille = $('#feuille');

	//console.log("width="+ width + " height="+height + " center_x=" + center_x + " center_y=" + center_y + " offsetLeft=" + offset.left + " this.offsetTop="+ offset.top);
	// Choix de la couleur de fond en fonction de la temperature
	if ( temperatureNest < 12 )
	 {
	  couleurFondTemperature='#' + grad[0];
	 }
	if ( temperatureNest > 24 )
	 {
	  couleurFondTemperature='#' + grad[11];
	 }
	if (  (temperatureNest <= 24 ) && (temperatureNest >= 12) )
	  {
	  //console.log(temperatureNest - 12);
	  couleurFondTemperature='#' + grad[temperatureNest - 12];
	  }
	 
     // Arrondi au Dixième
     temperature=Math.round(temperature*10)/10;

	
     var radians = Math.atan2(mouse_x - center_x, mouse_y - center_y);
     degree = (radians * (180 / Math.PI) * -1) + 180; 
	 
	 // On regarde le dernier angle pour savoir si on est en mode + ou -
	 if ( degree - lastAngle > 0)
	 {
	   //console.log("lastAngle=" + lastAngle + " degree=" + degree + "+");
	   temperature+=0.1;
	   
	   feuille.css("opacity","0");
	   $( "#nestMode" ).html("HEATING");
	 } else
	 {
	   //console.log("lastAngle=" + lastAngle + " degree=" + degree + "-");
	   temperature-=0.1;
	   
       feuille.css("opacity","1");
	   $( "#nestMode" ).html("COOLING");
	 }
	 majCouleurCercle(couleurFondTemperature);
	 poseConsigne(ratioTemperature*temperatureNest,temperatureNest);
	 majBarres(temperature,ratioTemperature);
	 lastAngle=degree;
	 temperatureNest=Math.round(temperature);
	 $( "#nestValue" ).html(temperatureNest );
};


// Fonction mettant à jour les barresn en passant la valeur et le ratio
function majBarres(value,ratio)
{
var bars = $('#bars');
var colorBars = bars.find('.colorBar');
colorBars.removeClass('active').slice(0, Math.round(value*ratio)).addClass('active');

}

// Fonction mettant à jour le degradé sur cercle central en passant la couleur de fond à obtenir
function majCouleurCercle(couleurFond)
{
       var centerCircle = $('#center-circle-cold');
	   centerCircle.css("background", "-webkit-radial-gradient(top left, ellipse cover, #fcf7f7 10%," + couleurFond + " 60%)"); /* Chrome 10 */
	   centerCircle.css("background", "-moz-radial-gradient(top left, ellipse cover, #fcf7f7 10%," + couleurFond + " 60%)"); /* FF */
	   centerCircle.css("background", "-webkit-gradient(radial, top left, 0px, top left, 100%, color-stop(10%,fff9f9), color-stop(60%,"+ couleurFond +"))"); /* Safari */
	   centerCircle.css("background", "-o-radial-gradient(top left, ellipse cover, #fcf7f7 10%," + couleurFond + " 60%)"); /* Opera 12+ */
	   centerCircle.css("background", "-ms-radial-gradient(top left, ellipse cover, #fcf7f7 10%," + couleurFond + " 60%)"); /* IE10+ */
       centerCircle.css("background", "radial-gradient(top left, ellipse cover, #fcf7f7 10%," + couleurFond + " 60%)"); /* W3C */
}

// Définition de la fonction pour gestion de temperature
function manageAirwave(e) {
    var offset = $('#full-circle').offset();
    var width=$('#full-circle').width();
    var height=$('#full-circle').height();
    var center_x = (offset.left) + (width/2);
    var center_y = (offset.top) + (height/2);
    var mouse_x = e.pageX; var mouse_y = e.pageY;
	var bars = $('#bars');
	var centerCircle = $('#center-circle-cold');
	var colorBars = bars.find('.colorBar');
	var feuille = $('#feuille');
	

	//console.log("width="+ width + " height="+height + " center_x=" + center_x + " center_y=" + center_y + " offsetLeft=" + offset.left + " this.offsetTop="+ offset.top);
	// Choix de la couleur en fonction de la valeur de la soufflante
	if ( airwaveNest < 10 )
	 {
	  var couleurFondAirwave='#' + grad[0];
	 }
	if ( airwaveNest > 90 )
	 {
	  var couleurFondAirwave='#' + grad[11];
	 }
	if (  (airwaveNest <= 90 ) && (airwaveNest >= 10) )
	  {
	  //console.log(temperatureNest - 12);
	  var couleurFondAirwave='#' + grad[(airwaveNest/3)- 12];
	  }
	 
     // Arrondi au Dixième
     airwave=Math.round(airwave*10)/10;

	
     var radians = Math.atan2(mouse_x - center_x, mouse_y - center_y);
     degree = (radians * (180 / Math.PI) * -1) + 180; 
	 var ratio=1;
	 // Mode + ou - en analysant le dernier angle calculé et le nouveau
	 if ( degree - lastAngle > 0)
	 {
	   //console.log("lastAngle=" + lastAngle + " degree=" + degree + "+");
	   airwave+=1;
	   majCouleurCercle(couleurFondAirwave);
	   feuille.css("opacity","0");
	   $( "#nestMode" ).html("WIND");
	 } else
	 {
	   //console.log("lastAngle=" + lastAngle + " degree=" + degree + "-");
	   airwave-=1;
	   majCouleurCercle(couleurFondAirwave);
	   feuille.css("opacity","1");
	   $( "#nestMode" ).html("CALM");
	 }
	 majBarres(airwave,ratioAirwave);
	 lastAngle=degree;
	 airwaveNest=Math.round(airwave);
	 // On plafonne les valeurs
	 if ( airwaveNest > 100 )
	 {
	 airwaveNest=100;
	 airwave=100;
	 }
	 if ( airwaveNest < 0 )
	 {
	 airwaveNest=0;
	 airwave=0;
	 }
	 
	 
	 $( "#nestValue" ).html(airwaveNest );
};


$('#full-circle').mousedown(function(e){
  // Lorsqu'on appuie sur le bouton de gauche, on autorise le thermostat à bouger
  mouseDown="ok";
});

$('*').mouseup(function(e){
  // Lorsqu'on relache le bouton de gauche, on n'autorise plus le thermostat à bouger
  mouseDown="";
});

// Lorsque l'on clique sur l'icone 2h, on sauvegarde et on fait tout disparaitre
$('#hour').click(function(){ 
  $("#hour").css("opacity","0");
  $("#hour2").css("opacity","0");
  $("#fire").css("opacity","1");
  heatNow=2;
   $( "#nestValue" ).html("2h");
});
// Lorsque l'on clique sur l'icone 4h, on sauvegarde et on fait tout disparaitre
$('#hour2').click(function(){ 
  $("#hour").css("opacity","0");
  $("#hour2").css("opacity","0");
  $("#fire").css("opacity","1");
  heatNow=4;
   $( "#nestValue" ).html("4h");
});

// Lorsque l'on clique sur l'icone fire, le mode de demande immédiate de chauffage disparait
$('#fire').click(function(){ 
$("#fire").css("opacity","0");
heatNow="";
});

// Lorsque l'on clique sur le texte nest, on switch d'un mode à l'autre
$('#nestTitle').click(function(){ 

  console.log("clic" + " currentMode=" + currentMode);
  if ( currentMode == "Auto" )
   {
    currentMode="AIRWAVE"
	majBarres(airwave,ratioAirwave);
	majCouleurCercle(couleurFondAirwave);
	$( "#nestValue" ).html(airwaveNest );
	
	$("#hour").css("opacity","0");
	$("#hour2").css("opacity","0");
	$( "#consigne" ).css("opacity","0");
	$('#feuille').css("opacity","0");
   } else if ( currentMode == "AIRWAVE" )
   {
    currentMode="HEAT NOW";
	$( "#nestValue" ).html('for');
	majCouleurCercle(couleurFondTemperature);
	majBarres(0,ratioTemperature);
	$("#hour").css("opacity","1");
	$("#hour2").css("opacity","1");
	$( "#consigne" ).css("opacity","0");
	$('#feuille').css("opacity","0");
   } else if ( currentMode == "HEAT NOW" )
   {
   currentMode="TEMP";
	$( "#nestValue" ).html(temperatureNest );
	majCouleurCercle(couleurFondTemperature);
	majBarres(temperature,ratioTemperature);
	$( "#consigne" ).html("");
	$( "#consigne" ).css("opacity","1");
	$("#hour").css("opacity","0");
	$("#hour2").css("opacity","0");
	$('#feuille').css("opacity","0");
   }else if ( currentMode == "TEMP" )
   {
   currentMode="Auto";
	$( "#nestValue" ).html("AWAY");
	majCouleurCercle(couleurFondAutoAway);
	$( "#consigne" ).html("");
	$( "#consigne" ).css("opacity","0");
	$("#hour").css("opacity","0");
	$("#hour2").css("opacity","0");
	$('#feuille').css("opacity","1");
	majBarres(0,ratioTemperature);
   }
  
  
  $("#nestMode" ).slideUp();
  $( "#nestMode" ).html(currentMode)
  $("#nestMode" ).slideDown();
});



// En fonction du mode, on fait varier les couleurs et les barres différement
$('#full-circle').mousemove(function(e){ 
  // Si on est autorisé à bouger	
  if ( mouseDown == "ok" )
   {
    if ( currentMode == "TEMP" )
	{
	manageTemperature(e);
    } 
    if ( currentMode == "AIRWAVE" )
     {
	manageAirwave(e);
	}
	
     }
});


$('#full-circle').bind( "touchstart", function(e){
  // Lorsqu'on touche l'écran, on autorise le thermostat à bouger
  mouseDown="ok";
  console.log("touchstart");
});

$('*').bind( "touchend", function(e){
       // Lorsqu'on relache l'écran, on n'autorise plus le thermostat à bouger
  mouseDown="";
  console.log("touchend");
});

$('#full-circle').bind( "touchmove", function(e){
    var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
  // Si on est autorisé à bouger   
  if ( mouseDown == "ok" )
   {
    if ( currentMode == "TEMP" )
   {
   manageTemperature(touch);
    } 
    if ( currentMode == "AIRWAVE" )
     {
   manageAirwave(touch);
   }
 }
});
});
</script>

</head>
<body style="background: #FFF; color: #000;">	

<div id="div_info">test</div>

<div class="fond">
	<div id="full-circle" class="full-circle">
		<div id="center-circle-cold" class="center-circle-cold">
			  <div id="bars">
	          <p id="nestTitle" class="nestTitle">nest</p>
			  <p name="nestMode" id="nestMode" class="nestMode"></p>
			  <p name="nestValue" id="nestValue" class="nestValue"></p>
			  <p name="hour" id="hour" class="hour">2H</p>
			  <p name="hour2" id="hour2" class="hour2">4H</p>
			
			  <div id="feuille" class="feuille"></div>
			  <div id="fire" class="fire"></div>
		</div>
	</div>
</div>
</div>
<div id="data"></div>
  <div id="consigne" name="consigne" ></div>
  			  <p name="desc" id="desc" class="desc" >
  - Ajout mode AUTO AWAY<br>
- Affichage température sur barre de progressions.<br>
- Compatibilité IPAD/IPHONE <b>Merci à Simplearetenir ;)</b>.
</p>
</body></html>