<nav id="top" class="navbar navbar-default navbar-static-top" role="navigation"><div class="container"><div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="navbar-brand" href="<?php if( $this->name != 'index' ) { echo PREFIX_LINK_LANG . '" title="Click to go home !'; } else { echo '#stopscroll'; } ?>"><img src="<?php echo PREFIX_ABSOLUTE_CDN; ?>img/logo-main.1.png" width="155" height="25" alt="<?php echo NAME_OF_THE_SYSTEM; ?>"></a></div><div class="navbar-collapse collapse"><ul class="nav navbar-nav"><li<?php if($this->name == 'index') { ?> class="active"><a href="#stopscroll"><?php } else { ?>><a href="<?php echo PREFIX_LINK_LANG; ?>"><?php } ?><span class="glyphicon glyphicon-th-list"></span> Objects List</a></li><li<?php if($this->name == 'tags') { ?> class="active"><a href="#stopscroll"><?php } else { ?>><a href="<?php echo PREFIX_LINK_LANG; ?>tags/"><?php } ?><span class="glyphicon glyphicon-tags"></span> Tag List</a></li><li<?php if($this->name == 'about') { ?> class="active"><a href="#stopscroll"><?php } else { ?>><a href="<?php echo PREFIX_LINK_LANG; ?>about/"><?php } ?><span class="glyphicon glyphicon-user"></span> About</a></li><?php
	if($othersLangAvailables) {
		?><li class="dropdown"><a href="#stopscroll" class="dropdown-toggle" data-toggle="dropdown">Others Languages <span class="caret"></span></a><ul class="dropdown-menu" role="menu"><?php
			foreach( $supportedLang as $lang ) {
				
				if( $lang == USER_LANGUAGE ){
					continue;
				}
				
				echo '<li><a href="' . PREFIX_LINK . 'lang/' . $lang . '/">';
				
				if( !empty($langNames[$lang] ) ) {
					echo $langNames[$lang];
				}
				else {
					echo '['.$lang.']';
				}
				echo '</a></li>';
			}
		?></ul></li><?php
	}
?></ul><ul class="nav navbar-nav navbar-right"><li<?php if($this->name == 'admin' && isset($isAdmin) && $isAdmin) { ?> class="active"><a href="#stopscroll"><?php } else { ?>><a href="<?php echo PREFIX_LINK_LANG; ?>admin/"><?php } ?><span class="glyphicon glyphicon-wrench"></span> Admin space</a></li></ul></div></div></nav><?php
	if( $this->name != 'about' ) {
		?>
			<main role="main" class="container main" itemprop="mainContentOfPage">
		<?php
	}
?><noscript><p class="errorMessage">For a better view, <a target="_blank" href="http://maboite.qc.ca/js_enable.php" rel="nofollow">enabled your JavaScript</a>, and update this page.</p></noscript>