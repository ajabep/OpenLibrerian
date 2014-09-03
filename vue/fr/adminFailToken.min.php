<h1>Espace Admin</h1><p class="alert alert-danger">ERREUR: <?php
	switch( $validityToken ) {
		case tokenAPI::ERR_TIME_LIMIT_PASSED :
			echo 'vous avez cliqué un lien périmé. Ré-essayé.';
			break;
		
		case tokenAPI::ERR_ALREADY_USED :
			echo 'Le formulaire a déjà été utilisé.';
			break;
		
		case tokenAPI::ERR_TOKEN_INVALID :
			echo 'le formulaire était invalide :( .';
			break;
		
		case 'noString' :
			echo 'Les mot de passes que vous avez renseigné sont invalides.';
			break;
		
		case 'noMatch' :
			echo 'Les mot-de-passes ne soont pas les mêmes.';
			break;
		
		default:
			echo 'Erreur inconnue.';
			error_log('Erreur inconnue : ' . $validityToken . ' in '. __FILE__ .':' . __LINE__);
	}
?> Vous avez essayé de demander la réinitialisation de votre mot de passe. Cette demande a échouée. Maintenant, que voulez vous faire ?</p><div class="panel-group" id="solutions"><div class="panel panel-success"><div class="panel-heading"><h2 class="panel-title"><a data-toggle="collapse" data-parent="#solutions" href="#tryAgain">Réessayer de vous connecter</a></h2></div><div id="tryAgain" class="panel-collapse collapse"><div class="panel-body"><p>Pour ressayer de vous connecter, rechargez la page <a href="<?php echo PREFIX_LINK_LANG; ?>admin/">en cliquant sur ce lien</a>.</p></div></div></div><div class="panel panel-danger"><div class="panel-heading"><h2 class="panel-title"><a data-toggle="collapse" data-parent="#solutions" href="#reset">Réessayer de re-initialiser votre mot-de-passe</a></h2></div><div id="reset" class="panel-collapse collapse"><div class="panel-body"><p class="alert alert-danger">Vous allez réinitialiser votre mot-de-passe. Si vous réussissez, votre ancient mot de passe ne sera plus valide.</p><form role="form" action="<?php echo PREFIX_LINK_LANG; ?>admin/" method="post"><input type="hidden" aria-hidden="true" name="token" value="{{token}}"><input type="submit" role="button" class="btn btn-danger" name="resetPassword" value="Réinitialiser le mot de passe"></form></div></div></div></div>