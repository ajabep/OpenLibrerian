<?php

$configFile = '../offline/config.inc.php'

require $configFile;

header('Content-Type: application/javascript');
header('Last-Modified: ' . date ("F d Y H:i:s.", filemtime($configFile)) );

?>
$( function() {
	$('[data-toggle=tooltip]').tooltip();
	
	
	$("h1 .editable").editable("<?php echo PREFIX_LINK; ?>ajax/editTag/", {
		indicator    : "Saving ...",
		type         : "text",
		name         : "name",
		submit       : "OK",
		cancel       : "cancel",
		placeholder  : "Double-click to rename your file...",
		tooltip      : "Double-click to edit...",
		event        : "dblclick",
		submitdata   : function(revert, settings) {
			return {
						id : document.getElementsByTagName('h1')[0].getAttribute('data-id'),
						element : 'rename'
					};
		},
		ajaxoptions  : {
			dataType : 'json',
			error    : function() { },
			success  : function() { }
		},
		always       : function(a, b, c, settings, self, reset){
			self.editing = false;
			
			// Show tooltip again. 
			if (settings.tooltip) {
				self.setAttribute('title', settings.tooltip); 
			}
			
			if( typeof a.readyState == "undefined" ) { // "success"
				
				if( a.status === true ) {
					self.innerHTML = a.result;
					
					if ( !$.trim( self.innerHTML ) ) {
						self.innerHTML = settings.placeholder;
					}
					
					return;
				}
				a = c;
				b = 'server';
				c = translate('Server error. Try later.');
			}
			// error
			
			self.innerHTML = self.revert;
			
			if ( !$.trim( self.innerHTML ) ) {
				self.innerHTML = settings.placeholder;
			}
			
			
			if( a.status != 200 ) {
				c = 'HTTP ERROR ' + a.status + ' : ' + a.statusText;
			}
			alert(
				translate('An error occured.\n\nType : {{errType}}\nDetails : {{error}}', {
						'errType' : b,
						'error' : c
					}
				)
			);
			
		}
	});
} );

