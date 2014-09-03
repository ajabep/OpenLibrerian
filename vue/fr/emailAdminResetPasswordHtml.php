<style>
.success {
	color: #5cb85c;
}
.info {
	color: #428bca;
}
</style>
<p>Nous avons reçu une demande de ré-initialisation du mot de passe admin pour votre <?php echo NAME_OF_THE_SYSTEM; ?>.</p>
<ul>
	<li>Si c'ets vous qui avez demandé cette réinitialisation, <a href="<?php echo PREFIX_ABSOLUTE_TINY_LINK_LANG; ?>admin/?resetPassword=1&token={{token}}">Cliquez ici</a> ou allez à l'adresse suivante : "<?php echo PREFIX_ABSOLUTE_TINY_LINK_LANG; ?>admin/?resetPassword=1&token={{token}}".</li>
	<li>Si il s'agit d'une erreur, ignorez ce message. Votre mot-de-passe reste le même.</li>
</ul>
<hr>
<p>The three steps to reset your password are :</p>
<ol>
	<li class="success">Vous avez demandé la réinitialisation de votre mot de passe.</li>
	<li class="info">Cliquez sur le lien ci-dessus.</li>
	<li>Re-définissez votre mot de passe.</li>
</ol>