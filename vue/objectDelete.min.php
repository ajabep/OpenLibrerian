		<h1>Delete <?php echo $object->name(); ?></h1>
		
		<div class="alert alert-warning">
			<p>You will delete the file named "<?php echo $object->name(); ?>". If you delete it, you will be unable recover it.<br>Are you sure to delete it ?</p>
			<div class="text-right">
				<a href="<?php echo PREFIX_LINK_LANG; ?>object/<?php echo $object->ID(); ?>/<?php echo stringToUrl($object->name()); ?>/" class="btn btn-default" data-dismiss="modal">Cancel</a>
				<form role="form" method="post" action="<?php echo PREFIX_LINK_LANG; ?>object/<?php echo $object->ID(); ?>/<?php echo stringToUrl($object->name()); ?>/delete/" class="display-inline">
					<input type="hidden" aria-hidden="true" name="confirmDelete" value="{{token}}">
					<button type="submit" role="button" class="btn btn-danger">Delete <span class="glyphicon glyphicon-remove"></span></button>
				</form>
			</div>
		</div>
