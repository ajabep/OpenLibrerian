<?php

$configFile = '../offline/config.inc.php';

require $configFile;

header('Content-Type: application/javascript');
header('Last-Modified: ' . date ("F d Y H:i:s.", filemtime($configFile)) );

?>
$( function() {
	$('[data-toggle=tooltip]').tooltip();
	
	$.editable.addInputType('autogrow', {
		element : function(settings, original) {
			var textarea = $('<textarea />');
			if (settings.rows) {
				textarea.attr('rows', settings.rows);
			} else {
				textarea.height(settings.height);
			}
			if (settings.cols) {
				textarea.attr('cols', settings.cols);
			} else {
				textarea.width(settings.width);
			}
			$(this).append(textarea);
			return(textarea);
		},
		plugin : function(settings, original) {
			$('textarea', this).autogrow(settings.autogrow);
		}
	});

	
	$("h1 .editable").editable("<?php echo PREFIX_LINK; ?>ajax/editObject/", {
		indicator    : "Saving ...",
		type         : "text",
		name         : "name",
		list         : "tags",
		submit       : "OK",
		cancel       : "cancel",
		placeholder  : "Double-click to name your file...",
		tooltip      : "Double-click to edit...",
		event        : "dblclick",
		submitdata   : function(revert, settings) {
			
			var textH1 = $('h1').text(),
				textEditable = $('h1 .editable').text(),
				ext = $.trim( textH1.substr( textEditable.length ) );
			
			return {
						id : document.getElementsByTagName('h1')[0].getAttribute('data-id-object'),
						ext : ext,
						element : 'nameFile'
					};
		},
		ajaxoptions  : {
			dataType : 'json',
			error    : function() { },
			success  : function() { }
		},
		always       : function(a, b, c, settings, self, reset){
			self.editing = false;
			
			/* Show tooltip again. */
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
	
	$(".description").editable("<?php echo PREFIX_LINK; ?>ajax/editObject/", {
		indicator   : "Saving ...",
		type        : "autogrow",
		name        : "description",
		list        : "tags",
		submit      : "OK",
		cancel      : "cancel",
		placeholder : "Double-click to describe your file...",
		tooltip     : "Double-click to edit...",
		event       : "dblclick",
		data        : function(html, settings) {
			
			var text = html.replace(/<br>\r?\n?/gim, '\n');
			
			text = text.replace(/<.*>/gim, '');
			text = text.replace(/&lt;/gim, '<');
			text = text.replace(/&gt;/gim, '>');
			
			return text;
		},
		submitdata  : function() {
			return {
						id : document.getElementsByTagName('h1')[0].getAttribute('data-id-object'),
						element : 'description'
					};
		},
		ajaxoptions : {
			dataType  : 'json',
			error     : function() { },
			success   : function() { }
		},
		always      : function(a, b, c, settings, self, reset){
			self.editing = false;
			
			/* Show tooltip again. */
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

	$('#addTagBtn').on('click', function(){
		
		document.getElementById( 'addTagInput' ).value = '';
		
		$( '#addTagModal' ).modal();
	});
	
	
	$( '.tagList' ).find( '[data-delete].glyphicon.glyphicon-remove-sign' )
				   .on('click', function(){
						deleteTag( this );
				   });
	
	$( '#btnAddTag' ).on('click', function(){
		
		var name = document.getElementById( 'addTagInput' ).value;
		
		$.post(
			'<?php echo PREFIX_LINK; ?>ajax/editObject/', {
				'element' : 'addTag',
				'id' : document.getElementsByTagName('h1')[0].getAttribute('data-id-object'),
				'name' : name
			},
			function ( datas, status, jXHR ) {
				if( datas.status === true ) {
					if( !$( '[data-delete=' + datas.id + ']' ).length ) {
						$( '.tagList' ).append( '<a class="tagIcon" href="' + datas.PREFIX_LINK_LANG + 'tag/' + datas.id + '/'  + datas.nameToUrl + '/" data-id="' + datas.id + '">' + name + '</a><span class="glyphicon glyphicon-remove-sign" data-delete="' + datas.id + '"></span>' );
						
						$( '[data-delete=' + datas.id + ']' ).on('click', function(){
																deleteTag( this );
															});
					}
					$( '#addTagModal' ).modal( 'hide' );
				}
				else {
					failAddTag(jXHR, status, ( datas.errMsg || translate('We can\'t recording the tag.') ) );
				}
			},
			'json'
		)
		.fail(
			function (jXHR, status, error){
				failAddTag(jXHR, status, error);
			}
		);
	});
	
	
	
	
	$.get(
		'<?php echo PREFIX_LINK; ?>ajax/tagList/',
		function ( datas ) {
			var datalist = '';
			
			for(var i = 0, c = datas.length; i<c; ++i) {
				datalist += '<option value="' + datas[i].name + '">';
			}
			
			document.getElementById( 'tagsList' ).innerHTML = datalist;
			
		},
		'json'
	);
	
	$( '#addTagModal' ).on( 'shown.bs.modal', function (e) {
		$( '#addTagInput' ).focus();
	});
	
} );

function deleteTag(self){
	
	var tagID = self.getAttribute('data-delete'),
		tagElement = $('[data-id=' + tagID + ']'),
		tagName = tagElement.text();
	
	$(self).removeClass('glyphicon-remove-sign')
		   .addClass('glyphicon-refresh');
	
	if(
		confirm(
			translate('Do you want to delete the "{{name}}" tag ?', {
					'name' : tagName
				}
			)
		)
	) {
		
		$.post(
			'<?php echo PREFIX_LINK; ?>ajax/editObject/', {
				'element' : 'deleteTag',
				'idObject' : $('h1').attr('data-id-object'),
				'idTag' : tagID
			},
			function( datas, status, jXHR ) {
				if( datas.status === true ) {
					$( '[data-id=' + datas.id + '], [data-delete=' + datas.id + ']' ).hide(500,function(){
																								this.remove();
																							});
				}
				else {
					failDeleteTag(jXHR, status, ( datas.errMsg || translate('We can\'t delete the tag.') ) );
				}
			},
			'json'
		)
		.fail(
			function (jXHR, status, error){
				failDeleteTag(jXHR, status, error);
			}
		);
		
	}
	
	$(self).removeClass('glyphicon-refresh')
		   .addClass('glyphicon-remove-sign');
}



function failDeleteTag (jXHR, status, error) {
	if( jXHR.status != 200 ) {
		error = 'HTTP ERROR ' + jXHR.status + ' : ' + jXHR.statusText;
	}
	alert(
		translate('An error occured on the delete of the tag.\nDetails : \n{{error}}', {
				'error' : error
			}
		)
	);
}



function failAddTag (jXHR, status, error) {
	if( jXHR.status != 200 ) {
		error = 'HTTP ERROR ' + jXHR.status + ' : ' + jXHR.statusText;
	}
	alert(
		translate('An error occured on the adding of the tag.\nDetails : \n{{error}}', {
				'error' : error
			}
		)
	);
}