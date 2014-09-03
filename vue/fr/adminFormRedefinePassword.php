		<h1>Espace Admin</h1>

		<p>Vous aves confirmé votre identité en ciquant sur le lien. Maintenant, redéfinissez votre mot de passe.</p>
		
		<form role="form" class="form-signin" action="<?php echo PREFIX_LINK_LANG; ?>admin/" method="post">
			<input type="password" autofocus required placeholder="Votre nouveau mot-de-passe" title="Votre nouveau mot-de-passe" class="form-control" name="password">
			<input type="password" required placeholder="Confirmation de votre nouveau mot-de-passe" title="Confirmation de votre nouveau mot-de-passe" class="form-control" name="confirmation">
			<input type="hidden" aria-hidden="true" name="token" value="{{token}}">
			<button type="submit" class="btn btn-lg btn-primary btn-block">Ré-initialiser</button>
		</form>
		
		<ul class="list-group">
			<li class="list-group-item list-group-item-success">1. Vous avez demandé la réinitialisation de votre mot de passe.</li>
			<li class="list-group-item list-group-item-success">2. Nous vous avons evoyé un mail. Vous avez cliqué sur le lien dans ce mail.</li>
			<li class="list-group-item list-group-item-info">3. Re-définissez votre mot de passe.</li>
		</ul>