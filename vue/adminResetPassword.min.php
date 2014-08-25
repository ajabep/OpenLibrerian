<h1>Admin space</h1><?php
	if($send) {
		echo '<p class="alert alert-success">You have begin the three steps to reset your password. To verifing your identity, we have send you a mail.</p><div class="panel panel-default"><div class="panel-heading"><h2 class="panel-title">Instructions</h2></div><div class="panel-body"><p>The three steps to reset your password are :</p></div><ul class="list-group"><li class="list-group-item list-group-item-success">1. You have ask for the reset.</li><li class="list-group-item list-group-item-info">2. We have send you an mail. Click on the link in this mail.</li><li class="list-group-item">3. Define your new password.</li></ul></div>';
	}
	else {
		echo '<p class="alert alert-danger">An error occured when we sending the reset mail. The password is always the same. If you want to reset the password, retry it from the begining. If the error continue, it\'s an configuration error (in offline/config.inc.php file).</p>';
	}
?>