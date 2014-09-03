		
		<h1 data-id="<?php echo $tag->ID(); ?>"><span class="editable"><?php echo $tag->name(); ?></span><?php
			if( $isAdmin ){
				echo ' <small data-toggle="tooltip" data-placement="top" class="glyphicon glyphicon-info-sign" title="To edit, double-click on the infos."></small>';
			}
			
		?></h1>
		
		
		
		<?php
			if( $isAdmin ){
				?>
					<form role="form" method="post" action="<?php echo PREFIX_LINK_LANG; ?>tag/<?php echo $tag->ID(); ?>/<?php echo stringToUrl($tag->name()); ?>/delete/" class="text-right">
						<input type="hidden" aria-hidden="true" name="token" value="{{token}}">
						<button type="submit" role="button" class="btn btn-danger">Delete <span class="glyphicon glyphicon-remove"></span></button>
					</form>
				<?php
			}
		?>
		
		<?php
			$objectsList = $tag->objects();
			if( count($objectsList) ) {
				?>
					<div class="objectList">
						<?php
							foreach( $objectsList as $object ){
								?>
								<div class="object">
									<div class="objectContent">
										<h2><?php echo $object->name(); ?></h2>
										<!--p class="tagList"><a class="tagIcon" href="#tag/1/Tag_1/">Tag 1</a> <span class="tagIcon">Tag 1</span> <a class="tagIcon" href="#tag/2/Tag_2/">Tag 2</a></p-->
										<p class="description"><?php echo $object->description(); ?></p>
										<p class="readMore pull-right"><a href="<?php echo PREFIX_LINK_LANG . 'object/' . $object->ID() . '/' . stringToUrl( $object->name() ) . '/'; ?>">Go &rarr;</a></p>
										<?php
											if( $isAdmin ) {
												echo '<p class="editLink pull-left"><a href="' . PREFIX_LINK_LANG . 'object/' . $object->ID() . '/' . stringToUrl( $object->name() ) . '/">Edit &rarr;</a></p><form role="form" method="post" action="' . PREFIX_LINK_LANG . 'object/' . $object->ID() . '/' . stringToUrl($object->name()) . '/delete/" class="deleteLink text-center"><input type="hidden" aria-hidden="true" name="token" value="{{tokenDeleteObject}}"><button type="submit" role="button" class="btn btn-link">Delete &rarr;</button></form>';
											}
										?>
									</div>
								</div>
								<?php
							}
						?>
					</div>
				<?php
			}
			else {
				?>
					<p class="alert alert-danger">There is nothing here !<br>Nada. Nothing. Zip. Zilch. Zero.</p>
				<?php
			}
		?>
		
		
		