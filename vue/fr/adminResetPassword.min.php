<h1>Esspace admnistrateur</h1><?php
	if($send) {
		echo '<p class="alert alert-success">Vous avez commencé les 3 étapes pour réinitialiser votre mot de passe. Afin de vérifier votre identité, nous vous avons envoyé un mail.</p>
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Instructions</h2>
			</div>
			<div class="panel-body">
				<p>Les 3 étapes pour réinitialiser votre mot de passe sont :</p>
			</div>
			<ul class="list-group">
				<li class="list-group-item list-group-item-success">1. Vous avez demandé la réinitialisation de votre mot de passe.</li>
				<li class="list-group-item list-group-item-info">2. Nous vous avons evoyé un mail. Vous devez cliqué sur le lien dans ce mail.</li>
				<li class="list-group-item">3. Re-définissez votre mot de passe.</li>
			</ul>
		</div>';
	}
	else {
		echo '<p class="alert alert-danger">Une erreur est survennue lors de l\'envois de mail. Le mot de passe reste toujours le même. Si vous voulez réinitialisez votre mot de passe, ré-essayez depuis le début. Si l\'érreur continue, c\'est alors qu\'il s\'agit d\'une erreur de configuration (dans le fichier offline/config.inc.php).</p>';
	}
?>