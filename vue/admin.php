		<h1>Admin space</h1>
		
		{{alert}}
		
		<p>What do you want to do ?</p>
		
		<div class="panel-group" id="action">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h2 class="panel-title"><a href="<?php echo PREFIX_LINK_LANG; ?>">Edit objects</a></h2>
				</div>
			</div>
			
			<div class="panel panel-info">
				<div class="panel-heading">
					<h2 class="panel-title"><a href="<?php echo PREFIX_LINK_LANG; ?>tags/">Edit tags</a></h2>
				</div>
			</div>
			
			<div class="panel panel-info">
				<div class="panel-heading">
					<h2 class="panel-title"><a data-toggle="collapse" data-parent="#action" href="#createObject">Create an object</a></h2>
				</div>
				<div id="createObject" class="panel-collapse collapse">
					<div class="panel-body">
						<form role="form" action="<?php echo PREFIX_LINK_LANG; ?>admin/" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label for="file">File input</label>
								<input type="file" id="file" name="file">
							</div>
							<div class="form-group">
								<textarea rows="10" class="form-control" id="description" name="description" placeholder="Description"></textarea>
							</div>
							<input type="hidden" aria-hidden="true" name="token" value="{{token}}">
							<div class="form-group text-right">
								<button type="submit" class="btn btn-default">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<div class="panel panel-info">
				<div class="panel-heading">
					<h2 class="panel-title"><a data-toggle="collapse" data-parent="#action" href="#createTag">Create a tag</a></h2>
				</div>
				<div id="createTag" class="panel-collapse collapse">
					<div class="panel-body">
						<form role="form" action="<?php echo PREFIX_LINK_LANG; ?>admin/" method="post">
							<div class="form-group">
								<input type="text" class="form-control" name="tag" placeholder="Tag name">
							</div>
							<input type="hidden" aria-hidden="true" name="token" value="{{token}}">
							<div class="form-group text-right">
								<button type="submit" class="btn btn-default">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h2 class="panel-title"><a href="<?php echo PREFIX_LINK_LANG; ?>">Delete objects</a></h2>
				</div>
			</div>
			
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h2 class="panel-title"><a href="<?php echo PREFIX_LINK_LANG; ?>tags/">Delete tags</a></h2>
				</div>
			</div>
		</div>
		
		
		
		