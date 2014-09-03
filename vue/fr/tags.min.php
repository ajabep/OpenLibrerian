<h1>Mots-clés</h1><?php
	$pagination = paginate(PREFIX_LINK_LANG . 'tags/', '', '/', ceil( $countTags / NUMBER_OF_OBJECT_BY_PAGES ), $page, NUMBER_OF_PAGE_BY_PAGINATION_BY_SIDE );
	echo $pagination;
	
	if( count($tagList) ) {
		?><div class="table-responsive"><table class="table table-striped table-hover"><?php
			foreach( $tagList as $tag ){
				$link = PREFIX_LINK_LANG . 'tag/' . $tag->ID() . '/' . stringToUrl( $tag->name() ) . '/';
				$objects = $tag->objects();
				$countObjects = count($objects);
				echo '<tr><td><a href="' . $link . '">' . $tag->name() . ' <small>( ' . $countObjects . ' element' . ( ($countObjects>1)? 's' : '' ) . ' )</small></a></td><td><a href="' . $link . '"><span class="goIcon"><span></span><span></span><span></span></span></a></td></tr>';
			}
		?></table></div><?php
	}
	else {
		?><p class="alert alert-danger">Il n'y a rien ici !<br>Nada. Nothing. Zip. Zilch. Zero.<br>Vous pouvez ajouter des objets en accédant à l'espace admin :) !</p><?php
	}

	echo $pagination;