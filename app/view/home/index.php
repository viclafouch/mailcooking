<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
	<meta name="robots" content="noindex, nofollow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="xxxx">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Mailcooking</title>


    <!-- <link rel="shortcut icon" href="images/favicon.png"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="webroot/css/home/main.css">
	<link rel="stylesheet" href="webroot/css/home/fonts.css">
  </head>
  <body>
<!-- 	<div class="containerloader">
		<div class="loader">
			<svg viewBox="0 0 32 32" width="32" height="32">
			  <circle id="spinner" cx="16" cy="16" r="14" fill="none"></circle>
			</svg>
		</div>
	</div> -->
	<?php if (isset($_GET["change_pass"])) { ?>
		<div class="notif">
			<p>Mot de passe modifié avec succès !</p>
		</div>
	<?php } ?>
	<main>
		<section class="cover">
		<!-- <canvas id="canvas"></canvas> -->
			<img src="webroot/img/home/logo.png" class="logo">
			<div class="menu-section">
			  <div class="menu-toggle">
				<div class="one"></div>
				<div class="two"></div>
				<div class="three"></div>
			  </div>
			  <nav>
					<ul role="navigation" class="hidden">
						<li><a href="#player" class="js-scrollTo">&Agrave; propos</a></li>
						<li><a href="#ccm" class="js-scrollTo">Comment ça marche</a></li>
						<li><a href="#tarifs" class="js-scrollTo">Tarifs</a></li>
						<li><a href="#contact" class="js-scrollTo">Contact</a></li>
					</ul>
				</nav>
			</div>
			<div class="intro">
				<h2>
					Concevez facilement vos
					campagnes emailing
				</h2>
				<h1>
					MailCooking est une plateforme PaaS vous permetant
					de concevoir et éditer vos newsletters en quelques clics et
					de les programmer sur votre routeurs
				</h1>
				<button class="free-test signup-btn"><span class="buttoneffect"></span><span class="text-cta">Testez gratuitement</span></button>
				<button class="free-test login-btn"><span class="buttoneffect"></span><span class="text-cta">Connexion</span></button>
			</div>
				<a class="mouse-scroll js-scrollTo" href="#player"> 
				  <span class="mouse">
					<span class="mouse-movement"> 
					</span>
				  </span>
				</a>
		</section>
		<section class="video" id="player">
			<h2>Deux minutes pour tout comprendre...</h2>
			<div class="player">
					<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve" width="512px" height="512px">
						<path d="M30,0C13.458,0,0,13.458,0,30s13.458,30,30,30s30-13.458,30-30S46.542,0,30,0z M45.563,30.826l-22,15  C23.394,45.941,23.197,46,23,46c-0.16,0-0.321-0.038-0.467-0.116C22.205,45.711,22,45.371,22,45V15c0-0.371,0.205-0.711,0.533-0.884  c0.328-0.174,0.724-0.15,1.031,0.058l22,15C45.836,29.36,46,29.669,46,30S45.836,30.64,45.563,30.826z" fill="#FFFFFF"/>
					</svg>
			</div>
			<div class="modal-overlay">
				<iframe id="video" src="https://www.youtube.com/embed/nRTiHgAuf3s" frameborder="0" allowfullscreen></iframe>
			</div>
		</section>
		<section class="slider" id="ccm">
			<div class="story" id="story">
				<h2>... et autant pour réaliser vos campagnes</h2>
				<section id="scene-indicator">
					<a data-scroll href="#scene1">
					<span class="first">01</span>
					</a>
					<span class="sep"></span>
					<a data-scroll href="#scene2">
						<span class="second">02</span>
					</a>
					<span class="sep"></span>
					<a data-scroll href="#scene3">
						<span class="third">03</span>
					</a>
				</section>
				<section id="scene1">
					<div id="pinned-row1">
						<div class="voffset50">
							<div class="storimg"><img src="webroot/img/home/coding.png" /></div>
							<div class="framexplain">
								<h3>
									Un moteur 100% drag<br /> 
									& drop
								</h3>
								<div class="edito">
									<p>
										La conception de vos newsletters est maintenant un jeu d'enfant ! Renseignez votre charte graphique (couleurs, typologies d'écriture etc.) et déplacez les sections dont vous avez besoin.
										<br />
										Vous avez déjà un template de newsletter ? Notre équipe d'intégration s'occupe de l'implémenter directement dans l'outil
									</p>
								</div>
							</div>
						</div>
						<div class="spacer"></div>
					</div>
				</section>
				<section id="scene2">
					<div id="pinned-row2">
						<div class="voffset50">
							<div class="storimg"><img src="webroot/img/home/coding.png" /></div>
							<div class="framexplain">
								<h3>
									Une édition simple<br />
									du contenu
								</h3>
								<div class="edito">
									<p>
										Une fois que votre design est réalisé, vous n'avez plus qu'à cliquer sur les zones à éditer. Modifiez les boutons, liens ou tout autres contenus à volonté et sans connaissances HTML requises.
										<br />
										Vous aurez la possibilité d'enregistrer le tempalte en cours de production pour y retourner plus tard.
									</p>
								</div>
							</div>
						</div>
						<div class="spacer"></div>
					</div>
				</section>
				<section id="scene3">
					<div id="pinned-row3">
						<div class="voffset50">
							<div class="storimg"><img src="webroot/img/home/coding.png" /></div>
							<div class="framexplain">
								<h3>
									Il n'y a plus qu'à
									<br />
									programmer
								</h3>
								<div class="edito">
									<p>
										MailCooking s'adapte à toutes les organisations et infrastructures. 
										<br />
										Vous pouvez soit télécharger le fichier HTML source avec le dossier images en .zip ou vous connecter directement à votre plateforme de routage via les API's à disposition. Votre routeur n'est pas présent ? Faites le nous savoir et nous y remédierons
									</p>
								</div>
							</div>
						</div>
						<div class="spacer"></div>
					</div>
				</section>
			</div>
		</section>
		<section class="prices" id="tarifs">
			<h2>Le tout en complète transaparence</h2>
			<h4>
				Nos tarifs sont clairs et fixes. Vous aurez la possibilité de mettre votre compte en pause
				en fonction de votre activité et de le relancer quand vous le souhaiterez, sans perte
				de données.
			</h4>
			<div id="pricing">
				<div class="price_card alpha">
					<div class="header">
						<span class="price">49 €<sub>/Mo</sub></span>
						<span class="name">Alpha Pack</span>
					</div>
					<ul class="features">
						<li>Complete documentation</li>
						<li>Working materials in PSD and Sketch format</li>
					</ul>
					<button><span class="buttoneffect"></span><span class="text-cta">Add to cart</span></button>
					<span class="tip">* Great for beginners!</span>
				</div>
				<div class="price_card bravo">
					<div class="header">
						<span class="price">99 €<sub>/Mo</sub></span>
						<span class="name">Bravo Pack</span>
					</div>
					<ul class="features">
						<li>Complete documentation</li>
						<li>Working materials in PSD, Sketch and EPS format</li>
						<li>6 months access to the library</li>
					</ul>
					<button><span class="buttoneffect"></span><span class="text-cta">Add to cart</span></button>
					<span class="tip">* Most popular!</span>
				</div>
				<div class="price_card charlie">
					<div class="header">
						<span class="price">149 €<sub>/Mo</sub></span>
						<span class="name">Charlie Pack</span>
					</div>
					<ul class="features">
						<li>Complete documentation</li>
						<li>Working materials in PSD, Sketch and EPS format</li>
						<li>1 year access to the library</li>
						<li>2GB cloud storage</li>
					</ul>
					<button><span class="buttoneffect"></span><span class="text-cta">Add to cart</span></button>
				</div>
			</div>
		</section>
		<div class="form-overlay"></div>
		<div class="form-container form-sign">
			<div class="form style-2">
				<header class="header">
					<h1>S'inscrire à la plateforme</h1>
				</header>
				<form class="active" method="post" action="?module=home&action=index">
					<div class="form-group">
						<input id="first_name" type="text" name="first_name" required="required"/>
						<label for="first_name">Prénom</label>
						<div class="line"></div>
					</div>
					<div class="form-group">
						<input id="last_name" type="text" name="last_name" required="required"/>
						<label for="last_name">Nom</label>
						<div class="line"></div>
					</div>
					<div class="form-group">
						<input id="societe" type="text" name="societe" required="required"/>
						<label for="societe">Société</label>
						<div class="line"></div>
					</div>
					<div class="form-group">
						<input id="nb_phone" type="text" name="nb_phone" required="required"/>
						<label for="nb_phone">Numéro de téléphone</label>
						<div class="line"></div>
					</div>
					<div class="form-group">
						<input id="user_email" type="text" name="user_email" required="required"/>
						<label for="user_email">Email</label>
						<div class="line"></div>
					</div>
					<div class="form-group">
						<input id="user_password" type="password" name="user_password" required="required"/>
						<label for="user_password">Password</label>
						<div class="line"></div>
					</div>
					<button>
						<span class="buttoneffect"></span>
						<span class="text-cta">S'inscrire</span>
					</button>
				</form>
			</div>
		</div>
		<div class="form-container form-login">
			<div class="form style-2">
				<header class="header">
					<h1>BONNE ID&Eacute;E</h1>
				</header>
				<form class="active" method="post" action="?module=home&action=index">
					<div class="form-group">
						<input id="user_email" type="email" name="user_email" required="required"/>
						<label for="user_email">Email</label>
						<div class="line"></div>
					</div>
					<div class="form-group">
						<input id="user_password" type="password" name="user_password" required="required"/>
						<label for="user_password">Password</label>
						<div class="line"></div>
					</div>
					<button>
						<span class="buttoneffect"></span>
						<span class="text-cta">Connexion</span>
					</button>
					<div class="footer">
						<a class="password_forget" href="" title="">Mot de passe oublié ?</a>
					</div>
				</form>
			</div>
		</div>
		<div class="form-container form-password">
			<div class="form style-2">
				<header class="header">
					<h1>MOT DE PASSE OUBLI&Eacute; ?</h1>
				</header>
				<form class="active" method="post" action="?module=home&action=password_forgot">
					<div class="form-group">
						<input id="user_email" type="email" name="user_email" required="required"/>
						<label for="user_email">Email</label>
						<div class="line"></div>
					</div>
					<button>
						<span class="buttoneffect"></span>
						<span class="text-cta">Confirmer</span>
					</button>
				</form>
			</div>
		</div>
	</main>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src='webroot/js/home/smooth-scroll.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.1/TweenMax.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.1/ScrollMagic.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.1/plugins/animation.gsap.js'></script>
	<!-- <script src="js/smoke.js"></script> -->
	<script src="webroot/js/home/main.js"></script>
	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
	<script>
		// var canvas = document.getElementById('canvas')
		// var ctx = canvas.getContext('2d')
		// canvas.width = $(".cover").width();
		// canvas.height = $(".cover").height();

		// var party = smokemachine(ctx, [54, 16.8, 18.2])
		// party.start() // start animating

		// onmousemove = function (e) {
		// 	var x = e.clientX
		// 	var y = e.clientY
		// 	var n = .5
		// 	var t = Math.floor(Math.random() * 200) + 3800
		// 	party.addsmoke(x, y, n, t)
		// }

		// setInterval(function(){
		// 	party.addsmoke(innerWidth/2, innerHeight, 1)
		// }, 100)
		$( ".password_forget" ).click(function() {
		  	$(".form-login").css({
				visibility:"hidden",
				opacity:"0",
			});  
			$(".form-password").css({
				visibility:"visible",
				opacity:"1",
			});   
    		return false;
  		});

	</script>
  </body>
</html>