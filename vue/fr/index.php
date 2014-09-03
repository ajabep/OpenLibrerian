		<h1>Objets</h1>
		
		<?php
			
			$pagination = paginate(PREFIX_LINK_LANG, '', '/', ceil( $countObjects / NUMBER_OF_OBJECT_BY_PAGES ), $page, NUMBER_OF_PAGE_BY_PAGINATION_BY_SIDE );
			echo $pagination;
		?>
		
		
		<?php
			if( count($objectList) ) {
				?>
					<div class="objectList">
						<?php
							foreach( $objectList as $object ){
								$tags = $object->tags();
								$tagsText = array();
								foreach( $tags as $tag ){
									$tagsText[] = '<a class="tagIcon" href="' . PREFIX_LINK_LANG . 'tag/' . $tag->ID() . '/' . stringToUrl( $tag->name() ) . '/">' . $tag->name() . '</a>';
								}
								?>
									<div class="object col-sm-6">
										<div class="objectContent">
											<h2><?php echo $object->name(); ?></h2>
											<p class="tagList"><?php echo implode(' ', $tagsText ); ?></p>
											<p class="description"><?php echo $object->description(); ?></p>
											<p class="readMore pull-right"><a href="<?php echo PREFIX_LINK_LANG . 'object/' . $object->ID() . '/' . stringToUrl( $object->name() ) . '/'; ?>">Go &rarr;</a></p>
											<?php
												if( $isAdmin ) {
													echo '<p class="editLink pull-left"><a href="' . PREFIX_LINK_LANG . 'object/' . $object->ID() . '/' . stringToUrl( $object->name() ) . '/">Editer &rarr;</a></p>
														  <!--p class="deleteLink text-center"><a href="' . PREFIX_LINK_LANG . 'object/' . $object->ID() . '/' . stringToUrl( $object->name() ) . '/delete/">Supprimer &rarr;</a></p-->
														  
														  
														  <form role="form" method="post" action="' . PREFIX_LINK_LANG . 'object/' . $object->ID() . '/' . stringToUrl($object->name()) . '/delete/" class="deleteLink text-center">
															<input type="hidden" aria-hidden="true" name="token" value="{{token}}">
															<button type="submit" role="button" class="btn btn-link">Supprimer &rarr;</button>
														  </form>';
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
					<p class="alert alert-danger">Il n'y a rien ici !<br>Nada. Nothing. Zip. Zilch. Zero.<br>Vous pouvez ajouter des objets en accédant à l'espace admin :) !</p>
				<?php
			}
		?>
		
		
		<?php echo $pagination; ?>
