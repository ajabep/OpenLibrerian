		<h1>Supprimer <?php echo $object->name(); ?></h1>
		
		<div class="alert alert-danger">
			<p>Erreur de suppretion.</p>
			
			<details>
				<summary>Details : </summary>
				<p><?php
					
					switch( $validityToken ) {
						case tokenAPI::ERR_TOKEN_INVALID:
							echo 'Le lien est invalide.';
							break;
						
						case tokenAPI::ERR_TIME_LIMIT_PASSED:
							echo 'Le temps maximal a été dépassé.';
							break;
						
						case tokenAPI::ERR_TRY_LATER:
							echo 'Erreur de serveur. Ré-essayez plus tard.';
							break;
						
						case tokenAPI::ERR_ALREADY_USED:
							echo 'Ce lien a déjà été utilisé.';
							break;
						
						default :
							echo 'Erreur inconnue.';
					}
					
				?></p>
			</details>
			
			<div class="text-right">
				<a href="<?php echo PREFIX_LINK_LANG; ?>object/<?php echo $object->ID(); ?>/<?php echo stringToUrl($object->name()); ?>/" class="btn btn-default">Annuler</a>
				<form role="form" method="post" action="<?php echo PREFIX_LINK_LANG; ?>object/<?php echo $object->ID(); ?>/<?php echo stringToUrl($object->name()); ?>/delete/" class="display-inline">
					<input type="hidden" aria-hidden="true" name="token" value="{{token}}">
					<button type="submit" role="button" class="btn btn-danger">Ré-essayer de supprimer <span class="glyphicon glyphicon-remove"></span></button>
				</form>
			</div>
		</div>
