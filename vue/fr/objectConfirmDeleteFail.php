		<h1>Supprimer <?php echo $object->name(); ?></h1>
		
		<div class="alert alert-danger">
			<p>Erreur de suppression. Ré-essayez plus tard.</p>
			
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
							if( empty($deleteResult) )
								echo 'Erreur inconnue.';
							else
								echo 'Une erreur est survenue lors de la suppression de ce fichier. Ré-essayez.';
					}
					
				?></p>
			</details>
			<div class="text-right">
				<a href="<?php echo PREFIX_LINK_LANG; ?>object/<?php echo $object->ID(); ?>/<?php echo stringToUrl($object->name()); ?>/" class="btn btn-default">Annuler</a>
				<form role="form" method="post" action="<?php echo PREFIX_LINK_LANG; ?>object/<?php echo $object->ID(); ?>/<?php echo stringToUrl($object->name()); ?>/delete/" class="display-inline">
					<input type="hidden" aria-hidden="true" name="token" value="{{token}}">
					<button type="submit" role="button" class="btn btn-danger">Ré-essayez la supprétion <span class="glyphicon glyphicon-remove"></span></button>
				</form>
			</div>
		</div>

