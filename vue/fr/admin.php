		<h1>Espace Admin</h1>
		
		{{alert}}
		
		<p>Que voulez vous faire ?</p>
		
		<div class="panel-group" id="action">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h2 class="panel-title"><a href="<?php echo PREFIX_LINK_LANG; ?>">Editer des objets</a></h2>
				</div>
			</div>
			
			<div class="panel panel-info">
				<div class="panel-heading">
					<h2 class="panel-title"><a href="<?php echo PREFIX_LINK_LANG; ?>tags/">Editer des mots-clés</a></h2>
				</div>
			</div>
			
			<div class="panel panel-info">
				<div class="panel-heading">
					<h2 class="panel-title"><a data-toggle="collapse" data-parent="#action" href="#createObject">Créer des objets</a></h2>
				</div>
				<div id="createObject" class="panel-collapse collapse">
					<div class="panel-body">
						<form role="form" action="<?php echo PREFIX_LINK_LANG; ?>admin/" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label for="file">Fichier à partager</label>
								<input type="file" id="file" name="file">
							</div>
							<div class="form-group">
								<textarea rows="10" class="form-control" id="description" name="description" placeholder="Description"></textarea>
							</div>
							<input type="hidden" aria-hidden="true" name="token" value="{{token}}">
							<div class="form-group text-right">
								<button type="submit" class="btn btn-default">Envoyer</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<div class="panel panel-info">
				<div class="panel-heading">
					<h2 class="panel-title"><a data-toggle="collapse" data-parent="#action" href="#createTag">Créer un mot-clé</a></h2>
				</div>
				<div id="createTag" class="panel-collapse collapse">
					<div class="panel-body">
						<form role="form" action="<?php echo PREFIX_LINK_LANG; ?>admin/" method="post">
							<div class="form-group">
								<input type="text" class="form-control" name="tag" placeholder="Nom du tag">
							</div>
							<input type="hidden" aria-hidden="true" name="token" value="{{token}}">
							<div class="form-group text-right">
								<button type="submit" class="btn btn-default">Créer</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h2 class="panel-title"><a href="<?php echo PREFIX_LINK_LANG; ?>">Supprimer des objets</a></h2>
				</div>
			</div>
			
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h2 class="panel-title"><a href="<?php echo PREFIX_LINK_LANG; ?>tags/">Supprimer des tags</a></h2>
				</div>
			</div>
		</div>
		
		
		
		