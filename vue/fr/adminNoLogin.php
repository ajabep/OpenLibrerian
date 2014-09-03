		<h1>Espace administration</h1>
		
		<p>Vous avez essayé de vous connecter dans cet espace. Mais vous n'avez pas réussi. Maintenant que voulez vous faire ?</p>
		
		<div class="panel-group" id="solutions">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h2 class="panel-title"><a data-toggle="collapse" data-parent="#solutions" href="#tryAgain">Ré-essayer</a></h2>
				</div>
				<div id="tryAgain" class="panel-collapse collapse">
					<div class="panel-body">
						<p>Pour réessayer de vous connecter, rechargez la page en faisant <kbd>F5</kbd> ou <a href="<?php echo PREFIX_LINK_LANG; ?>admin/">en cliquant ici</a>.</p>
					</div>
				</div>
			</div>
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h2 class="panel-title"><a data-toggle="collapse" data-parent="#solutions" href="#reset">Réinitialiser votre mot de passe</a></h2>
				</div>
				<div id="reset" class="panel-collapse collapse">
					<div class="panel-body">
						<p class="alert alert-danger">Vous allez réinitialiser votre mot-de-passe. Si vous réussissez, votre ancient mot de passe ne sera plus valide.</p>
						
						<form role="form" action="<?php echo PREFIX_LINK_LANG; ?>admin/" method="post">
							<input type="hidden" aria-hidden="true" name="token" value="{{token}}">
							<input type="submit" role="button" class="btn btn-danger" name="resetPassword" value="Réinitialiser le mot de passe">
						</form>
					</div>
				</div>
			</div>
		</div>
		
		
		
		
		
		