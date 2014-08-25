var lang = getDocumentLanguage();

function getDocumentLanguage() {
	var htmlAttributes = document.getElementsByTagName('html')[0].attributes;
	
	for(var i = 0, c = htmlAttributes.length; i < c; ++i) {
		if( htmlAttributes[i].name == 'lang' || htmlAttributes[i].localName == 'lang' || htmlAttributes[i].nodeName == 'lang' ||  htmlAttributes[i].name == 'xml:lang' || htmlAttributes[i].localName == 'xml:lang' || htmlAttributes[i].nodeName == 'xml:lang' ){
			return htmlAttributes[i].value || htmlAttributes[i].textContent || htmlAttributes[i].nodeValue;
		}
	}
	
	if( document.getElementsByTagName('body')[0].attributes.lang )
		return document.getElementsByTagName('body')[0].attributes.lang;
	
	if( navigator.language )
		return navigator.language;
	
	return 'en'; // DEFAULT LANGUAGE
	
}

function translate(msg, args){
	
	switch( lang ) {
		case 'fr':
			
			switch( msg ) {
				case 'Do you want to delete the "{{name}}" tag ?':
					msg = 'Voulez vous vraiment supprimer the tag ayant pour nom "{{name}}" ?';
					break;
				
				case 'An error occured on the delete of the tag.\nDetails : \n{{error}}':
					msg = 'Une erreur s\'est produite lors de la suppression du tag.\nDétails:\n{{error}}';
					break;
				
				case 'An error occured.\n\nType : {{errType}}\nDetails : {{error}}':
					msg = 'Une erreur s\'est produite.\n\nType : {{errType}}\nDétails : {{error}}';
					break;
				
				case 'We can\'t recording the tag.':
					msg = 'Nous ne pouvons pas enregistrer ce tag.';
					break;
				
				case 'We can\'t delete the tag.':
					msg = 'Nous ne pouvons pas supprimer ce tag.';
					break;
				
				case 'Server error. Try later.':
					msg = 'Erreur du serveur. Réessayez plus tard.';
					break;
			}
			break;
		
		case 'es':
			
			switch( msg ) {
				case 'Do you want to delete the "{{name}}" tag ?':
					msg = '¿ Quiere realmente eliminar la etiqueta con el nombre "{{name}}" ?';
					break;
				
				case 'An error occured on the delete of the tag.\nDetails : \n{{error}}':
					msg = 'Se produjo un error al eliminar la etiqueta.\nDetalles : \n{{error}}';
					break;
				
				case 'An error occured.\n\nType : {{errType}}\nDetails : {{error}}':
					msg = 'Se ha producido un error.\n\nTipo : {{errType}}\nDetalles : {{error}}';
					break;
				
				case 'We can\'t recording the tag.':
					msg = 'No podemos grabar la etiqueta.';
					break;
				
				case 'We can\'t delete the tag.':
					msg = 'No podemos eliminar esta etiqueta.';
					break;
				
				case 'Server error. Try later.':
					msg = 'Server Error. Inténtalo de nuevo más tarde.';
			}
	}
	
	for( var arg in args ) {
		
		msg = msg.replace( '{{' + arg + '}}', args[arg]);
		
	}
	
	return msg;
	
}