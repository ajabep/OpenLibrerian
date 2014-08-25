<p class="alert alert-<?php
	if( $_SESSION['part'] == 'tag' ) {
		switch( $_SESSION['errAdmin'] ) {
			case 'dbPb':
				echo 'danger">The database had a problem. Retry later please.';
				break;
			
			case tokenAPI::TOKEN_VALID:
				echo 'success">The tag is record ! :)';
				break;
			
			case tokenAPI::ERR_TOKEN_INVALID:
				echo 'danger">Sorry, but the security on the form was invalid. Retry later please.';
				break;
			
			case tokenAPI::ERR_TIME_LIMIT_PASSED:
				echo 'danger">Sorry, but you have send the form too later (the form is valid 50 minutes). Retry later please.';
				break;
			
			case tokenAPI::ERR_ALREADY_USED:
				echo 'danger">Sorry, but you have already send this form. Retry later please.';
				break;
			
			case tokenAPI::ERR_TRY_LATER:
				echo 'danger">Unknown error. Retry later please.';
				break;
			
			default:
				echo 'danger">Unknown error. Retry later please.';
				error_log('Unknown error : ' . var_export($_SESSION['errAdmin'], true) . ' in '. __FILE__ .':' . __LINE__);
		}
	}
	elseif( $_SESSION['part'] == 'object' ) {
		switch( $_SESSION['errAdmin'] ) {
			case 'dbPb':
				echo 'danger">The database had a problem. Retry later please.';
				break;
			
			case 'filePb':
				echo 'danger">The file system had a problem. Retry later please.';
				break;
			
			case tokenAPI::TOKEN_VALID:
				echo 'success">The object is record ! :)';
				break;
			
			case tokenAPI::ERR_TOKEN_INVALID:
				echo 'danger">Sorry, but the security on the form was invalid. Retry later please.';
				break;
			
			case tokenAPI::ERR_TIME_LIMIT_PASSED:
				echo 'danger">Sorry, but you have send the form too later (the form is valid 50 minutes). Retry later please.';
				break;
			
			case tokenAPI::ERR_ALREADY_USED:
				echo 'danger">Sorry, but you have already send this form. Retry later please.';
				break;
			
			case tokenAPI::ERR_TRY_LATER:
				echo 'danger">Unknown error. Retry later please.';
				break;
			
			case 'f' . UPLOAD_ERR_INI_SIZE:
				echo 'danger">The file is too big to be send. Maximal size : ' . ini_get('upload_max_filesize') . 'bytes.';
				break;
			
			case 'f' . UPLOAD_ERR_FORM_SIZE:
				echo 'danger">The file is too big to be send.';
				break;
			
			case 'f' . UPLOAD_ERR_PARTIAL:
				echo 'danger">The uploaded file was only partially uploaded. Retry later.';
				break;
			
			case 'f' . UPLOAD_ERR_NO_FILE:
				echo 'danger">No file was uploaded. Retry later.';
				break;
			
			case 'f' . UPLOAD_ERR_NO_TMP_DIR:
				echo 'danger">Missing a temporary folder. Retry later.';
				break;
			
			case 'f' . UPLOAD_ERR_CANT_WRITE:
				echo 'danger">Failed to write file to disk. Retry later.';
				break;
			
			case 'f' . UPLOAD_ERR_EXTENSION:
				echo 'danger">File upload stopped by extension. Retry later.';
				break;
			
			default:
				echo 'danger">Unknown error. Retry later please.';
				error_log('Unknown error : ' . var_export($_SESSION['errAdmin'], true) . ' in '. __FILE__ .':' . __LINE__);
		}
	}
	elseif( $_SESSION['part'] == 'update' ) {
		switch( $_SESSION['errAdmin'] ) {
			case 1:
				echo 'danger">You can\'t update your system.';
				break;
			
			case 2:
				echo 'danger">The uploaded file is corrupt.';
				break;
			
			case 3:
				echo 'danger">Th file is invalid can\'t be open like a zip archive.';
				break;
			
			case 4:
				echo 'danger">The archive can\'t be extract.';
				break;
			
			case 5:
				echo 'danger">An error occur when deleting the old files.';
				break;
			
			case 4:
				echo 'danger">We can\'t record the settings. Retry later.';
				break;
			
			case 4:
				echo 'success">Your system is up to date now !';
				break;
			
			default:
				echo 'danger">Unknown error. Retry later please.';
				error_log('Unknown error : ' . var_export($_SESSION['errAdmin'], true) . ' in '. __FILE__ .':' . __LINE__);
		}
	}
	else {
		echo 'danger">Unknown error. Retry later please.';
		error_log('Unknown error : ' . var_export($_SESSION['errAdmin'], true) . ' with' . var_export($_SESSION['part'], true) . ' in '. __FILE__ .':' . __LINE__);
	}

?></p>