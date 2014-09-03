		<h1>Delete <?php echo $object->name(); ?></h1>
		
		<div class="alert alert-danger">
			<p>Error of delete. Try again.</p>
			
			<details>
				<summary>Details : </summary>
				<p><?php
					
					switch( $validityToken ) {
						case tokenAPI::ERR_TOKEN_INVALID:
							echo 'The link was invalid.';
							break;
						
						case tokenAPI::ERR_TIME_LIMIT_PASSED:
							echo 'The time limit is passed.';
							break;
						
						case tokenAPI::ERR_TRY_LATER:
							echo 'Try later.';
							break;
						
						case tokenAPI::ERR_ALREADY_USED:
							echo 'The link is already used.';
							break;
						
						default :
							echo 'Unknown error.';
					}
					
				?></p>
			</details>
			
			<div class="text-right">
				<a href="<?php echo PREFIX_LINK_LANG; ?>object/<?php echo $object->ID(); ?>/<?php echo stringToUrl($object->name()); ?>/" class="btn btn-default">Cancel</a>
				<form role="form" method="post" action="<?php echo PREFIX_LINK_LANG; ?>object/<?php echo $object->ID(); ?>/<?php echo stringToUrl($object->name()); ?>/delete/" class="display-inline">
					<input type="hidden" aria-hidden="true" name="token" value="{{token}}">
					<button type="submit" role="button" class="btn btn-danger">Try again to delete <span class="glyphicon glyphicon-remove"></span></button>
				</form>
			</div>
		</div>
