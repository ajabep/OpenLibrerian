<p class="alert alert-<?php
	if( $_SESSION['part'] == 'tag' ) {
		switch( $_SESSION['errAdmin'] ) {
			case 'dbPb':
				echo 'danger">La basse de donnée a un problème. Ré-essayez plus tard.';
				break;
			
			case tokenAPI::TOKEN_VALID:
				echo 'success">Le mot-clé est enregistré ! :)';
				break;
			
			case tokenAPI::ERR_TOKEN_INVALID:
				echo 'danger">Désollé, mais pour des raisons de sécurité ce formulaire n\'était pas valide. Ré-essayez plus tard.';
				break;
			
			case tokenAPI::ERR_TIME_LIMIT_PASSED:
				echo 'danger">Désolé, mais vous avez envoyé le formulaire trop tard (ce formulaire est valide 50 minutes). Ré-essayez plus tard.';
				break;
			
			case tokenAPI::ERR_ALREADY_USED:
				echo 'danger">Désolé, mais vous avez déjà envoyé ce formulaire. Ré-essayez plus tard.';
				break;
			
			case tokenAPI::ERR_TRY_LATER:
				echo 'danger">Erreur inconnue. Ré-essayez plus tard.';
				break;
			
			default:
				echo 'danger">Erreur inconnue. Ré-essayez plus tard.';
				error_log('Erreur inconnue : ' . var_export($_SESSION['errAdmin'], true) . ' in '. __FILE__ .':' . __LINE__);
		}
	}
	elseif( $_SESSION['part'] == 'object' ) {
		switch( $_SESSION['errAdmin'] ) {
			case 'dbPb':
				echo 'danger">La basse de donnée a un problème. Ré-essayer plus tard.';
				break;
			
			case 'filePb':
				echo 'danger">Le fichier système a un problème. Ré-essayez plus tard.';
				break;
			
			case tokenAPI::TOKEN_VALID:
				echo 'success">L\'objet a bien été créé ! :)';
				break;
			
			case tokenAPI::ERR_TOKEN_INVALID:
				echo 'danger">Désollé, mais pour des raisons de sécurité ce formulaire n\'était pas valide. Ré-essayez plus tard.';
				break;
			
			case tokenAPI::ERR_TIME_LIMIT_PASSED:
				echo 'danger">Désolé, mais vous avez envoyé le formulaire trop tard (ce formulaire est valide 50 minutes). Ré-essayez plus tard.';
				break;
			
			case tokenAPI::ERR_ALREADY_USED:
				echo 'danger">Désolé, mais vous avez déjà envoyé ce formulaire. Ré-essayez plus tard.';
				break;
			
			case tokenAPI::ERR_TRY_LATER:
				echo 'danger">Erreur inconnue. Ré-essayez plus tard.';
				break;
			
			case 'f' . UPLOAD_ERR_INI_SIZE:
				echo 'danger">Le fichier est trop grand pour être envoyé. Taille maximale : ' . ini_get('upload_max_filesize') . 'bytes.';
				break;
			
			case 'f' . UPLOAD_ERR_FORM_SIZE:
				echo 'danger">Le fichier est trop grand pour être envoyé.';
				break;
			
			case 'f' . UPLOAD_ERR_PARTIAL:
				echo 'danger">Le fichier uploadé est n\'a pas été complettement reçu. Ré-essayez plus tard.';
				break;
			
			case 'f' . UPLOAD_ERR_NO_FILE:
				echo 'danger">Vous n\'avez reseigné aucun fichier. Ré-essayez.';
				break;
			
			case 'f' . UPLOAD_ERR_NO_TMP_DIR:
				echo 'danger">Il manque le dossier temporaire sur le serveur. Ré-essayez plus tard.';
				break;
			
			case 'f' . UPLOAD_ERR_CANT_WRITE:
				echo 'danger">Erreur d\'écriture sur le disque. Ré-essayez plus tard.';
				break;
			
			case 'f' . UPLOAD_ERR_EXTENSION:
				echo 'danger">Téléchargement stoppé par l\'extention du fichier. Ré-essayez plus tard.';
				break;
			
			default:
				echo 'danger">Erreur inconnue. Ré-essayez plus tard.';
				error_log('Erreur inconnue : ' . var_export($_SESSION['errAdmin'], true) . ' in '. __FILE__ .':' . __LINE__);
		}
	}
	else {
		echo 'danger">Erreur inconnue. Ré-essayez plus tard.';
		error_log('Erreur inconnue : ' . var_export($_SESSION['errAdmin'], true) . ' with' . var_export($_SESSION['part'], true) . ' in '. __FILE__ .':' . __LINE__);
	}

?></p>