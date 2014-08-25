

	</main>

	<footer>
		<div class="container">
			<p class="pull-right"><a href="#top">Back to top</a></p>
			<p>Proudly powered by <a href="https://github.com/ajabep/OpenLibrerian/">OpenLibrerian</a>, created with <span class="heartIcon" title="love">&lt;3</span> by <a href="http://ajabep.tk">Ajabep</a>.</p>
		</div>
	</footer>



	<script src="<?php echo PREFIX_ABSOLUTE_CDN; ?>js/jquery-1_11_1.1.min.js"></script>
	<script src="<?php echo PREFIX_ABSOLUTE_CDN; ?>js/bootstrap.1.min.js"></script>

	<?php
		if( $this->name == 'object' && $_GET['edit'] == '' ) {
			echo '<script src="' . PREFIX_ABSOLUTE_CDN . 'js/translate.1.min.js" async></script>
				  <script src="' . PREFIX_ABSOLUTE_CDN . 'js/jeditable.1.min.js"></script>
				  <script src="' . PREFIX_ABSOLUTE_CDN . 'js/autogrow.1.min.js"></script>
				  <script src="' . PREFIX_ABSOLUTE_CDN . 'js/object.1.min.js"></script>';
		}
		
		if( $this->name == 'tag' && $_GET['edit'] == '' ) {
			echo '<script src="' . PREFIX_ABSOLUTE_CDN . 'js/translate.1.min.js" async></script>
				  <script src="' . PREFIX_ABSOLUTE_CDN . 'js/jeditable.1.min.js"></script>
				  <script src="' . PREFIX_ABSOLUTE_CDN . 'js/autogrow.1.min.js"></script>
				  <script src="' . PREFIX_ABSOLUTE_CDN . 'js/tag.1.min.js"></script>';
		}
		
		if( $this->name == 'admin' && $isAdmin ) {
			echo '<script src="' . PREFIX_ABSOLUTE_CDN . 'js/autogrow.1.min.js"></script>
				  <script src="' . PREFIX_ABSOLUTE_CDN . 'js/admin.1.min.js"></script>';
		}
		
	?>
</body>
</html>