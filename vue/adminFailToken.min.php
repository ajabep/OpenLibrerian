<h1>Admin space</h1><p class="alert alert-danger">ERROR : <?php
	switch( $validityToken ) {
		case tokenAPI::ERR_TIME_LIMIT_PASSED :
			echo 'you have click on a out of date link.';
			break;
		
		case tokenAPI::ERR_ALREADY_USED :
			echo 'the form was already used.';
			break;
		
		case tokenAPI::ERR_TOKEN_INVALID :
			echo 'the form was invalid :( .';
			break;
		
		case 'noString' :
			echo 'the passwords that you have send are invalids.';
			break;
		
		case 'noMatch' :
			echo 'the passwords don\'t match.';
			break;
		
		default:
			echo 'unknown error.';
			error_log('Unknown error : ' . $validityToken . ' in '. __FILE__ .':' . __LINE__);
	}
?> You have try to ask for reset the password. But you have failed. Now, what do you want to do ?</p><div class="panel-group" id="solutions"><div class="panel panel-success"><div class="panel-heading"><h2 class="panel-title"><a data-toggle="collapse" data-parent="#solutions" href="#tryAgain">Try again to log in</a></h2></div><div id="tryAgain" class="panel-collapse collapse"><div class="panel-body"><p>To try again  to fill the log in form, reload this page, <a href="<?php echo PREFIX_LINK_LANG; ?>admin/">click here</a></p></div></div></div><div class="panel panel-danger"><div class="panel-heading"><h2 class="panel-title"><a data-toggle="collapse" data-parent="#solutions" href="#reset">Try again to reset password</a></h2></div><div id="reset" class="panel-collapse collapse"><div class="panel-body"><p class="alert alert-danger">You will reset your password. If you reset it, your actual password will expire.</p><form role="form" action="<?php echo PREFIX_LINK_LANG; ?>admin/" method="post"><input type="hidden" aria-hidden="true" name="token" value="{{token}}"><input type="submit" role="button" class="btn btn-danger" name="resetPassword" value="Reset password"></form></div></div></div></div>