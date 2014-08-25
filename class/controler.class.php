<?php
class controler {
	protected $name = '';
	protected $code;
	protected $get = array();

	public function __construct($action) {
		
		if( DEVELOPPEMENT == 2 ) {
			$action = 'maintenance';
		}
		
		switch($action){
			case 'index' :
				$this->name = 'index';
				break;
			
			case 'tags' :
				$this->name = 'tags';
				break;
			
			case 'object' :
				$this->name = 'object';
				break;
			
			case 'tag' :
				$this->name = 'tag';
				break;
			
			case 'about' :
				$this->name = 'about';
				break;
			
			case 'admin' :
				$this->name = 'admin';
				break;
			
			case 'download' :
				$this->name = 'download';
				break;
			
			case 'ajax' :
				$this->name = 'ajax';
				break;
			
			case 'changeLang' :
				$this->name = 'changeLang';
				break;
			
			default :
				$action=404;
			case '400' :
			case '403' :
			case '404' :
				$this->name = 'errorHttp';
				$this->code = $action;
				break;
			
			case 'maintenance' :
				$this->name = 'maintenance';
				break;
			
		}
	}


	public function getName() {
		return $this->name;
	}


	public function exec( $get = array() ) {
		$this->get = $get;
		$this->{ $this->name }();
	}



	public function index() {
		global $html, $langNames, $db;
		
		$supportedLang = $html->getSupportedLang();
		
		$othersLangAvailables = count($supportedLang) - 1;
		
		if( empty($this->get['page']) ) {
			$page = 1;
		}
		else{
			$page = max( (int) $this->get['page'], 1 );
		}
		
		$limitStart = NUMBER_OF_OBJECT_BY_PAGES * ( $page - 1 );
		
		open_db();
		
		$objectManager = new objectManager( $db );
		$countObjects = $objectManager->count();
		
		if( 0 > $countObjects ){
			close_db();
			dbProblem(__FILE__, __LINE__);
			return;
		}
		
		if( $limitStart > $countObjects ){
			close_db();
			notFound();
			return;
		}
		
		if( $countObjects ) {
			$objectList = $objectManager->getAll(false, true, false, $limitStart, NUMBER_OF_OBJECT_BY_PAGES);
		}
		else {
			$objectList = array();
		}
		
		$tokenAPI = new tokenAPI($db, false);
		$token = $tokenAPI->create('deleteObject');
		
		close_db();
		
		if( DEVELOPPEMENT )
			$robotsInstruction = 'noindex, nofollow, none, noarchive, nosnippet, noodp, noimageindex';
		else
			$robotsInstruction = 'index, follow';
		
		header('X-Robots-Tag: ' . $robotsInstruction, true);
		header('Content-language: ' . USER_LANGUAGE);
		
		if( isset($_SESSION['isAdmin']) ) {
			$isAdmin = $_SESSION['isAdmin'];
		}
		else {
			$_SESSION['isAdmin'] = $isAdmin = false;
		}
		
		$arrayHtmlCache = array(DEVELOPPEMENT, PREFIX_ABSOLUTE_CDN, PREFIX_LINK_LANG, PREFIX_ABSOLUTE_LINK, PREFIX_LINK, NAME_OF_THE_SYSTEM, $supportedLang, $countObjects, $page, NUMBER_OF_OBJECT_BY_PAGES, NUMBER_OF_PAGE_BY_PAGINATION_BY_SIDE, serialize($objectList), $isAdmin);
		
		if( $html->isCached($this->name, $arrayHtmlCache) ) {
			$htmlReturned = $html->readCachedFile($this->name, $arrayHtmlCache, true);
		}
		else {
			ob_start();
			
			include $html->doctype();
			include $html->header();
			include $html->page($this->name);
			include $html->footer();
			
			$htmlReturned = ob_get_clean();
			
			$html->cacheIt($this->name, $htmlReturned, $arrayHtmlCache, true);
		}
		
		$htmlReturned = str_replace('{{token}}', $token, $htmlReturned);
		
		echo $htmlReturned;
		return;
	}

	public function tags() {
		global $html, $langNames, $db;
		
		$supportedLang = $html->getSupportedLang();
		
		$othersLangAvailables = count($supportedLang) - 1;
		
		if( empty($this->get['page']) ) {
			$page = 1;
		}
		else {
			$page = max( (int) $this->get['page'], 1 );
		}
		
		$limitStart = NUMBER_OF_OBJECT_BY_PAGES * ( $page - 1 );
		
		open_db();
		
		$tagManager = new tagManager( $db );
		$countTags = $tagManager->count();
		
		if( 0 > $countTags ){
			close_db();
			dbProblem(__FILE__, __LINE__);
			return;
		}
		if( $limitStart > $countTags ){
			close_db();
			notFound();
			return;
		}
		
		if( $countTags ) {
			$tagList = $tagManager->getAll(false, true, false, $limitStart, NUMBER_OF_OBJECT_BY_PAGES);
		}
		else {
			$tagList = array();
		}
		
		close_db();
		
		if( DEVELOPPEMENT )
			$robotsInstruction = 'noindex, nofollow, none, noarchive, nosnippet, noodp, noimageindex';
		else
			$robotsInstruction = 'index, follow';
		
		header('X-Robots-Tag: ' . $robotsInstruction, true);
		header('Content-language: ' . USER_LANGUAGE);
		
		
		$arrayHtmlCache = array(DEVELOPPEMENT, PREFIX_ABSOLUTE_LINK, PREFIX_ABSOLUTE_CDN, PREFIX_LINK, PREFIX_LINK_LANG, NAME_OF_THE_SYSTEM, $supportedLang, $countTags, NUMBER_OF_OBJECT_BY_PAGES, $page, NUMBER_OF_PAGE_BY_PAGINATION_BY_SIDE, $tagList);
		if( $html->isCached($this->name, $arrayHtmlCache) ) {
			$html->readCachedFile($this->name, $arrayHtmlCache);
			return;
		}
		
		ob_start();
		
		include $html->doctype();
		include $html->header();
		include $html->page($this->name);
		include $html->footer();
		
		$htmlReturned = ob_get_flush();
		
		$html->cacheIt($this->name, $htmlReturned, $arrayHtmlCache, true);
	}

	public function object() {
		global $html, $langNames, $db;
		
		$supportedLang = $html->getSupportedLang();
		
		$othersLangAvailables = count($supportedLang) - 1;
		
		if( empty($this->get['id']) ) {
			notFound();
			return;
		}
		else {
			$id = (int) $this->get['id'];
		}
		
		
		if( isset($_SESSION['isAdmin']) ) {
			$isAdmin = $_SESSION['isAdmin'];
		}
		else {
			$_SESSION['isAdmin'] = $isAdmin = false;
		}
		
		open_db();
		
		$objectManager = new objectManager( $db );
		$objectsList = $objectManager->getBy( 'ID', $id);
		$tokenAPI = new tokenAPI($db, false);
		
		if( !( count($objectsList) && ( $object = $objectsList[0] ) instanceof object ) ){
			notFound();
			return;
		}
		
		switch($this->get['edit']){
			default :
				close_db();
				notFound();
				return;
			
			case '':
				$token = $tokenAPI->create('deleteObject');
				break;
			
			case 'delete':
				if( !$isAdmin ) {
					close_db();
					notFound();
				}
				
				if( isset($_POST['confirmDelete']) ) {
					$validityToken = $tokenAPI->verify($_POST['confirmDelete'], 'ConfirmDeleteObject', ( tokenAPI::WITH_TIME | tokenAPI::WITHOUT_MIN_TIME ) );
					$token = '';
					if( $validityToken == tokenAPI::TOKEN_VALID ) {
						$deleteResult = $objectManager->delete('ID', $_GET['id']);
					}
					else {
						$token = $tokenAPI->create( 'deleteObject' );
					}
				}
				
				elseif( isset($_POST['token']) ) {
					$validityToken = $tokenAPI->verify($_POST['token'], 'deleteObject', ( tokenAPI::WITH_TIME | tokenAPI::WITHOUT_MIN_TIME ) );
					$token = $tokenAPI->create( ( $validityToken == tokenAPI::TOKEN_VALID ) ? 'ConfirmDeleteObject' : 'deleteObject' );
				}
				
				else {
					close_db();
					notFound();
				}
		}
		
		close_db();
		
		switch($this->get['edit']){
			case '':
				$namePage = $this->name;
				break;
			
			case 'delete':
				if( isset($_POST['confirmDelete']) ) {
					if( $validityToken == tokenAPI::TOKEN_VALID ) {
						if( $deleteResult ) {
							unlink('./offline/files/' . $_GET['id']);
							$namePage = $this->name . 'ConfirmDelete';
						}
						else
							$namePage = $this->name . 'ConfirmDeleteFail';
					}
					else {
						$namePage = $this->name . 'ConfirmDeleteFail';
					}
				}
				
				if( isset($_POST['token']) ) {
					if( $validityToken == tokenAPI::TOKEN_VALID ) {
						$namePage = $this->name . 'Delete';
					}
					else {
						$namePage = $this->name . 'DeleteFail';
					}
				}
		}
		
		
		if( DEVELOPPEMENT )
			$robotsInstruction = 'noindex, nofollow, none, noarchive, nosnippet, noodp, noimageindex';
		else
			$robotsInstruction = 'index, follow';
		
		header('X-Robots-Tag: ' . $robotsInstruction, true);
		header('Content-language: ' . USER_LANGUAGE);
		
		$arrayHtmlCache = array(DEVELOPPEMENT, PREFIX_ABSOLUTE_LINK, $this->get['edit'], serialize($object), PREFIX_ABSOLUTE_CDN, PREFIX_LINK, PREFIX_LINK_LANG, NAME_OF_THE_SYSTEM, $supportedLang, $isAdmin);
		
		if( $namePage == $this->name ) {
			$arrayHtmlCache[] = $isAdmin;
		}
		elseif( $namePage == $this->name . 'ConfirmDeleteFail' || $namePage == $this->name . 'DeleteFail' ) {
			$arrayHtmlCache[] = $validityToken;
		}
		
		if( $html->isCached($namePage, $arrayHtmlCache) ) {
			$htmlReturned = $html->readCachedFile($namePage, $arrayHtmlCache, true);
		}
		else {
			ob_start();
			
			include $html->doctype();
			include $html->header();
			include $html->page($namePage);
			include $html->footer();
			
			$htmlReturned = ob_get_clean();
			
			$html->cacheIt($namePage, $htmlReturned, $arrayHtmlCache, true);
		}
		
		$htmlReturned = str_replace('{{token}}', $token, $htmlReturned);
		
		echo $htmlReturned;
		return;
	}

	public function tag() {
		global $html, $langNames, $db;
		
		$supportedLang = $html->getSupportedLang();
		
		$othersLangAvailables = count($supportedLang) - 1;
		
		$id = (int) $this->get['id'];
		
		
		if( isset($_SESSION['isAdmin']) ) {
			$isAdmin = $_SESSION['isAdmin'];
		}
		else {
			$_SESSION['isAdmin'] = $isAdmin = false;
		}
		
		open_db();
		
		$tagManager = new tagManager( $db );
		$tagList = $tagManager->getBy('ID', $id);
		
		$tokenAPI = new tokenAPI($db, false);
		
		if( !( count($tagList) && ( $tag = $tagList[0] ) instanceof tag ) ){
			notFound();
			return;
		}
		
		switch($this->get['edit']){
			default :
				close_db();
				notFound();
				return;
			
			case '':
				$token = $tokenAPI->create( 'deleteTag' );
				$tokenDeleteObject = $tokenAPI->create( 'deleteObject' );
				break;
			
			case 'delete':
				
				$tokenDeleteObject = '';
				
				if( !$isAdmin ) {
					close_db();
					notFound();
				}
				
				if( isset($_POST['confirmDelete']) ) {
					$validityToken = $tokenAPI->verify($_POST['confirmDelete'], 'ConfirmDeleteTag', ( tokenAPI::WITH_TIME | tokenAPI::WITHOUT_MIN_TIME ) );
					$token = '';
					if( $validityToken == tokenAPI::TOKEN_VALID ) {
						$deleteResult = $tagManager->delete('ID', $_GET['id']);
					}
					else {
						$token = $tokenAPI->create( 'deleteTag' );
					}
				}
				
				elseif( isset($_POST['token']) ) {
					$validityToken = $tokenAPI->verify($_POST['token'], 'deleteTag', ( tokenAPI::WITH_TIME | tokenAPI::WITHOUT_MIN_TIME ) );
					$token = $tokenAPI->create( ( $validityToken == tokenAPI::TOKEN_VALID ) ? 'ConfirmDeleteTag' : 'deleteTag' );
				}
				
				else {
					close_db();
					notFound();
				}
		}
		
		close_db();
		
		switch($this->get['edit']){
			case '':
				$namePage = $this->name;
				break;
			
			case 'delete':
				if( isset($_POST['confirmDelete']) ) {
					if( $validityToken == tokenAPI::TOKEN_VALID ) {
						if( $deleteResult ) {
							$namePage = $this->name . 'ConfirmDelete';
						}
						else
							$namePage = $this->name . 'ConfirmDeleteFail';
					}
					else {
						$namePage = $this->name . 'ConfirmDeleteFail';
					}
				}
				
				if( isset($_POST['token']) ) {
					if( $validityToken == tokenAPI::TOKEN_VALID ) {
						$namePage = $this->name . 'Delete';
					}
					else {
						$namePage = $this->name . 'DeleteFail';
					}
				}
		}
		
		if( DEVELOPPEMENT )
			$robotsInstruction = 'noindex, nofollow, none, noarchive, nosnippet, noodp, noimageindex';
		else
			$robotsInstruction = 'index, follow';
		
		header('X-Robots-Tag: ' . $robotsInstruction, true);
		header('Content-language: ' . USER_LANGUAGE);
		
		if( isset($_SESSION['isAdmin']) ) {
			$isAdmin = $_SESSION['isAdmin'];
		}
		else {
			$isAdmin = false;
		}
		
		$arrayHtmlCache = array(DEVELOPPEMENT, PREFIX_ABSOLUTE_LINK, $this->get['edit'], serialize($tag), PREFIX_ABSOLUTE_CDN, PREFIX_LINK, PREFIX_LINK_LANG, NAME_OF_THE_SYSTEM, $supportedLang, $isAdmin);
		
		if( $namePage == $this->name ) {
			$arrayHtmlCache[] = $isAdmin;
		}
		elseif( $namePage == $this->name . 'ConfirmDeleteFail' || $namePage == $this->name . 'DeleteFail' ) {
			$arrayHtmlCache[] = $validityToken;
		}
		
		if( $html->isCached($namePage, $arrayHtmlCache) ) {
			$htmlReturned = $html->readCachedFile($namePage, $arrayHtmlCache, true);
		}
		else {
			ob_start();
			
			include $html->doctype();
			include $html->header();
			include $html->page($namePage);
			include $html->footer();
			
			$htmlReturned = ob_get_clean();
			
			$html->cacheIt($namePage, $htmlReturned, $arrayHtmlCache, true);
		}
		
		$htmlReturned = str_replace('{{token}}', $token, $htmlReturned);
		$htmlReturned = str_replace('{{tokenDeleteObject}}', $tokenDeleteObject, $htmlReturned);
		
		echo $htmlReturned;
		return;
	}

	public function about() {
		global $html, $langNames;
		
		$supportedLang = $html->getSupportedLang();
		
		$othersLangAvailables = count($supportedLang) - 1;
		
		if( DEVELOPPEMENT )
			$robotsInstruction = 'noindex, nofollow, none, noarchive, nosnippet, noodp, noimageindex';
		else
			$robotsInstruction = 'index, follow';
		
		header('X-Robots-Tag: ' . $robotsInstruction, true);
		header('Content-language: ' . USER_LANGUAGE);
		
		$arrayHtmlCache = array(DEVELOPPEMENT, PREFIX_ABSOLUTE_LINK, PREFIX_ABSOLUTE_CDN, PREFIX_LINK, PREFIX_LINK_LANG, NAME_OF_THE_SYSTEM, $supportedLang);
		
		if( $html->isCached($this->name, $arrayHtmlCache) ) {
			$html->readCachedFile($this->name, $arrayHtmlCache);
			return;
		}
		
		ob_start();
		
		include $html->doctype();
		include $html->header();
		include $html->page($this->name);
		include $html->footer();
		
		$htmlReturned = ob_get_flush();
		
		$html->cacheIt($this->name, $htmlReturned, $arrayHtmlCache, true);
	}

	public function admin() {
		global $html, $langNames, $db;
		
		$supportedLang = $html->getSupportedLang();
		
		$othersLangAvailables = count($supportedLang) - 1;
		
		$robotsInstruction = 'noindex, nofollow, none, noarchive, nosnippet, noodp, noimageindex';
		
		header('X-Robots-Tag: ' . $robotsInstruction, true);
		header('Content-language: ' . USER_LANGUAGE);
		
		$isAdmin = ( isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] == file_get_contents('offline/login.admin.conf') && hash('sha512', $_SERVER['PHP_AUTH_PW']) == file_get_contents('offline/password.admin.conf') );
		
		if( !$isAdmin ) {
			if( empty($_POST['resetPassword']) && empty($_POST['password']) && empty($_GET['resetPassword']) && empty( $_GET['err'] ) ) {
				
				header('WWW-Authenticate: Basic realm="Admin space"');
				header('HTTP/1.0 401 Unauthorized');
				
				open_db();
				
				$tokenAPI = new tokenAPI($db, false);
				$token = $tokenAPI->create('admin');
				
				close_db();
				
				$arrayHtmlCache = array(PREFIX_ABSOLUTE_LINK, PREFIX_ABSOLUTE_CDN, PREFIX_LINK, PREFIX_LINK_LANG, NAME_OF_THE_SYSTEM, $supportedLang);
				$namePage = $this->name . 'NoLogin';
				
				if( $html->isCached($namePage, $arrayHtmlCache) ) {
					$htmlSend = $html->readCachedFile($namePage, $arrayHtmlCache, true);
				}
				else{
					
					ob_start();
					
					include $html->doctype();
					include $html->header();
					include $html->page($namePage);
					include $html->footer();
					
					$htmlSend = ob_get_clean();
					
					$html->cacheIt($namePage, $htmlSend, $arrayHtmlCache, true);
				}
				
				$htmlSend = str_replace('{{token}}', $token, $htmlSend);
				echo $htmlSend;
				return;
			}
			elseif( !empty($_GET['err']) ) {
				
				$validityToken = $_GET['err'];
				
				open_db();
				
				$tokenAPI = new tokenAPI($db, false);
				$token = $tokenAPI->create('admin');
				
				close_db();
				
				$arrayHtmlCache = array(PREFIX_ABSOLUTE_LINK, PREFIX_ABSOLUTE_CDN, PREFIX_LINK, PREFIX_LINK_LANG, NAME_OF_THE_SYSTEM, $supportedLang, $validityToken);
				$namePage = $this->name . 'FailToken';
				
				if( $html->isCached($namePage, $arrayHtmlCache) ) {
					$htmlSend = $html->readCachedFile($namePage, $arrayHtmlCache, true);
				}
				else{
					
					ob_start();
					
					include $html->doctype();
					include $html->header();
					include $html->page($namePage);
					include $html->footer();
					
					$htmlSend = ob_get_clean();
					
					$html->cacheIt($namePage, $htmlSend, $arrayHtmlCache, true);
				}
				
				if( $html->isCached($this->name, $arrayHtmlCache) ) {
					$htmlSend = $html->readCachedFile($this->name, $arrayHtmlCache, true);
				}
				else{
					
					ob_start();
					
					include $html->doctype();
					include $html->header();
					include $html->page($this->name . 'FailToken');
					include $html->footer();
					
					$htmlSend = ob_get_clean();
					
					$html->cacheIt($this->name, $htmlSend, $arrayHtmlCache, true);
				}
				
				$htmlSend = str_replace('{{token}}', $token, $htmlSend);
				echo $htmlSend;
				return;
			}
			elseif( !empty($_POST['resetPassword']) ) {
				open_db();
				
				$tokenAPI = new tokenAPI($db, false);
				$validityToken = $tokenAPI->verify($_POST['token'], 'admin', ( tokenAPI::WITH_TIME | tokenAPI::WITHOUT_MIN_TIME ) , true, 5);
				
				$token = $tokenAPI->create('emailResetPasswordAdmin');
				
				close_db();
				
				if( $validityToken == tokenAPI::TOKEN_VALID ) {
					# mail it;
					ob_start();
					
					include $html->page('emailAdminResetPasswordHtml');
					
					$mailHtml = ob_get_clean();
					
					ob_start();
					
					include $html->page('emailAdminResetPasswordMD');
					
					$mailMD = ob_get_clean();
					
					
					$mailHtml = str_replace('{{token}}', $token, $mailHtml);
					$mailMD = str_replace('{{token}}', $token, $mailMD);
					
					
					$PHPMailer = new PHPMailer();
					$PHPMailer->IsSMTP();
					if( DEVELOPPEMENT )
						$PHPMailer->SMTPDebug = 2;
					else
						$PHPMailer->SMTPDebug = 2;
					$PHPMailer->Host = HOST_MAIL;
					$PHPMailer->Port = PORT_MAIL;
					$PHPMailer->SMTPSecure = SMTPSECURE_MAIL;
					$PHPMailer->SMTPAuth = SMTPAUTH_MAIL;
					$PHPMailer->Username = USERNAME_MAIL;
					$PHPMailer->Password = PASSWORD_MAIL;
					$PHPMailer->SetFrom(ACCOUNT_MAIL, utf8_decode(NAME_OF_THE_SYSTEM) );
					$PHPMailer->AddAddress(ADMIN_MAIL, utf8_decode(NAME_OF_THE_SYSTEM) );
					$PHPMailer->ClearReplyTos();
					$PHPMailer->Subject = utf8_decode('Reset admin password');
					$PHPMailer->AltBody = utf8_decode($mailMD);
					$PHPMailer->MsgHTML( utf8_decode($mailHtml) );
					$send = $PHPMailer->Send();
					
				}
				else{
					http_redirect( PREFIX_LINK_LANG . 'admin/', array( 'err' => $validityToken ), false, HTTP_REDIRECT_FOUND);
					return;
				}
				
				$arrayHtmlCache = array(PREFIX_ABSOLUTE_LINK, PREFIX_ABSOLUTE_CDN, PREFIX_LINK, PREFIX_LINK_LANG, NAME_OF_THE_SYSTEM, $supportedLang, $send);
				$namePage = $this->name . 'ResetPassword';
				
				if( $html->isCached($namePage, $arrayHtmlCache) ) {
					$html->readCachedFile($namePage, $arrayHtmlCache);
					return;
				}
				
				ob_start();
				
				include $html->doctype();
				include $html->header();
				include $html->page($namePage);
				include $html->footer();
				
				$htmlReturned = ob_get_flush();
				
				$html->cacheIt($namePage, $htmlReturned, $arrayHtmlCache, true);
				return;
			}
			elseif( !empty($_GET['resetPassword']) ) {
				
				open_db();
				
				$tokenAPI = new tokenAPI($db, false);
				$validityToken = $tokenAPI->verify($_GET['token'], 'emailResetPasswordAdmin', ( tokenAPI::WITH_TIME | tokenAPI::WITHOUT_MIN_TIME ));
				
				$token = $tokenAPI->create('formRedefinePassword');
				
				close_db();
				
				if( $validityToken != tokenAPI::TOKEN_VALID ) {
					http_redirect( PREFIX_LINK_LANG . 'admin/', array( 'err' => $validityToken ), false, HTTP_REDIRECT_FOUND);
					return;
				}
				
				$arrayHtmlCache = array(PREFIX_ABSOLUTE_LINK, PREFIX_ABSOLUTE_CDN, PREFIX_LINK, PREFIX_LINK_LANG, NAME_OF_THE_SYSTEM, $supportedLang);
				$namePage = $this->name . 'FormRedefinePassword';
				
				if( $html->isCached($namePage, $arrayHtmlCache) ) {
					$html->readCachedFile($namePage, $arrayHtmlCache);
					return;
				}
				
				ob_start();
				
				include $html->doctype();
				include $html->header();
				include $html->page($namePage);
				include $html->footer();
				
				$htmlReturned = ob_get_flush();
				
				$html->cacheIt($namePage, $htmlReturned, $arrayHtmlCache, true);
				return;
			}
			elseif( !empty($_POST['password']) ) {
				
				open_db();
				
				$tokenAPI = new tokenAPI($db, false);
				$validityToken = $tokenAPI->verify($_POST['token'], 'formRedefinePassword', ( tokenAPI::WITH_TIME | tokenAPI::WITHOUT_MIN_TIME ) );
				
				close_db();
				
				if( $validityToken == tokenAPI::TOKEN_VALID ) {
					if( !is_string($_POST['password']) || !is_string($_POST['confirmation']) ) {
						http_redirect( PREFIX_LINK_LANG . 'admin/', array( 'err' => 'noString' ), false, HTTP_REDIRECT_FOUND);
						return;
					}
					
					if( $_POST['password'] != $_POST['confirmation'] ) {
						http_redirect( PREFIX_LINK_LANG . 'admin/', array( 'err' => 'noMatch' ), false, HTTP_REDIRECT_FOUND);
						return;
					}
					
					file_put_contents('offline/password.admin.conf', hash('sha512', $_POST['password']));
				}
				else {
					http_redirect( PREFIX_LINK_LANG . 'admin/', array( 'err' => $validityToken ), false, HTTP_REDIRECT_FOUND);
					return;
				}
				
				$arrayHtmlCache = array(PREFIX_ABSOLUTE_LINK, PREFIX_ABSOLUTE_CDN, PREFIX_LINK, PREFIX_LINK_LANG, NAME_OF_THE_SYSTEM, $supportedLang);
				$namePage = $this->name . 'ResetPasswordOk';
				
				if( $html->isCached($namePage, $arrayHtmlCache) ) {
					$html->readCachedFile($namePage, $arrayHtmlCache);
					return;
				}
				
				ob_start();
				
				include $html->doctype();
				include $html->header();
				include $html->page($namePage);
				include $html->footer();
				
				$htmlSend = ob_get_clean();
				
				$html->cacheIt($namePage, $htmlReturned, $arrayHtmlCache, true);
			}
			
			
			
		}
		elseif( empty($_POST['token']) ) {
			
			$_SESSION['isAdmin'] = $isAdmin = true;
			
			open_db();
			
			$tokenAPI = new tokenAPI($db, false);
			$token = $tokenAPI->create('admin');
			
			close_db();
			
			$arrayHtmlCache = array(PREFIX_ABSOLUTE_LINK, PREFIX_ABSOLUTE_CDN, PREFIX_LINK, PREFIX_LINK_LANG, NAME_OF_THE_SYSTEM, $supportedLang);
			
			if( $html->isCached($this->name, $arrayHtmlCache) ) {
				$htmlReturned = $html->readCachedFile($this->name, $arrayHtmlCache, true);
			}
			else {
				ob_start();
				
				include $html->doctype();
				include $html->header();
				include $html->page($this->name);
				include $html->footer();
				
				$htmlReturned = ob_get_clean();
				
				$html->cacheIt($this->name, $htmlReturned, $arrayHtmlCache, true);
			}
			
			$alert = '';
			if( !empty( $_SESSION['errAdmin'] ) && !empty( $_SESSION['part'] ) ) {
				
				$arrayHtmlCache = array($_SESSION['errAdmin'], $_SESSION['part']);
				$name = $this->name . 'Alert';
				
				if( $html->isCached($name, $arrayHtmlCache) ) {
					$alert = $html->readCachedFile($name, $arrayHtmlCache, true);
				}
				else {
					ob_start();
					
					include $html->page($name);
					
					$alert = ob_get_clean();
					
					$html->cacheIt($name, $alert, $arrayHtmlCache, true);
				}
				
				
				$_SESSION['errAdmin'] = $_SESSION['part'] = '';
			}
			
			
			$htmlReturned = str_replace('{{token}}', $token, $htmlReturned);
			$htmlReturned = str_replace('{{alert}}', $alert, $htmlReturned);
			
			echo $htmlReturned;
			return;
			
		}
		elseif( !empty($_POST['tag']) ) {
			$_SESSION['part'] = 'tag';
			
			if( empty( $_POST['token'] ) || empty( $_POST['tag'] = trim($_POST['tag']) ) || !ctype_print($_POST['tag']) ) {
				notFound();
				return;
			}
			
			open_db();
			
			$tokenAPI = new tokenAPI($db, false);
			$validityToken = $tokenAPI->verify($_POST['token'], 'admin', ( tokenAPI::WITH_TIME | tokenAPI::WITHOUT_MIN_TIME ) );
			$_SESSION['errAdmin'] = $validityToken;
			
			if( $validityToken == tokenAPI::TOKEN_VALID ) {
				$tagManager = new tagManager( $db );
				$tag = $tagManager->set($_POST['tag'], false, false);
				
				if( !( $tag instanceof tag ) ){
					close_db();
					$_SESSION['errAdmin'] = 'dbPb';
					dbProblem(__FILE__, __LINE__);
					return;
				}
			}
			
			close_db();
			http_redirect( PREFIX_LINK_LANG . 'admin/', array(), false, HTTP_REDIRECT_FOUND);
		}
		else {
			$_SESSION['part'] = 'object';
			if( empty( $_POST['token'] ) || empty($_FILES['file']) || !isset($_POST['description']) || !is_string($_POST['description']) ) {
				notFound();
				return;
			}
			
			if( $_FILES['file']['error'] == UPLOAD_ERR_OK ) {
				
				open_db();
				
				$tokenAPI = new tokenAPI($db, false);
				$validityToken = $tokenAPI->verify($_POST['token'], 'admin', ( tokenAPI::WITH_TIME | tokenAPI::WITHOUT_MIN_TIME ) );
				$_SESSION['errAdmin'] = $validityToken;
				
				if( $validityToken == tokenAPI::TOKEN_VALID ) {
					$objectManager = new objectManager( $db );
					$object = $objectManager->set($_FILES['file']['name'], $_POST['description'], array(), false, false);
					
					close_db();
					
					if( !( $object instanceof object ) ){
						$_SESSION['errAdmin'] = 'dbPb';
						dbProblem(__FILE__, __LINE__);
						return;
					}
					
					$resultat = move_uploaded_file($_FILES['file']['tmp_name'], './offline/files/' . $object->ID());
					if( !$resultat ) {
						$_SESSION['errAdmin'] = 'filePb';
					}
				}
			}
			else {
				$_SESSION['errAdmin'] = 'f' . $_FILES['file']['error'];
			}
			
			http_redirect( PREFIX_LINK_LANG . 'admin/', array(), false, HTTP_REDIRECT_FOUND);
		}
	}

	public function download() {
		
		if(ini_get('zlib.output_compression')){
			ini_set('zlib.output_compression', 'Off');
		}
		
		global $html, $langNames, $db;
		
		$supportedLang = $html->getSupportedLang();
		
		$othersLangAvailables = count($supportedLang) - 1;
		
		if( empty($this->get['id']) ) {
			notFound();
			return;
		}
		else {
			$id = (int) $this->get['id'];
		}
		
		
		if( isset($_SESSION['isAdmin']) ) {
			$isAdmin = $_SESSION['isAdmin'];
		}
		else {
			$_SESSION['isAdmin'] = $isAdmin = false;
		}
		
		open_db();
		
		$objectManager = new objectManager( $db );
		$objectsList = $objectManager->getBy('ID', $id, false, false);
		
		close_db();
		
		if( !( count($objectsList) && ( $object = $objectsList[0] ) instanceof object ) ){
			notFound();
			return;
		}
		
		$file = './offline/files/' . $object->ID();
		
		if( !file_exists( $file ) ) {
			notFound();
			return;
		}
		
		$name = urlencode( $object->name() );
		$ext = strtolower( substr( strrchr($name, '.'), 1) );
		
		$mimeType = getMimeType($ext);
		
		// End of Mime Type
		
		header('Pragma: no-cache');
		header('Content-Length: ' . filesize($file) );
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control:  private, no-store, no-cache, must-revalidate'); // HTTP/1.1
		header('Cache-Control: post-check=0, pre-check=0, max-age=0', false); 
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Passed date
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Content-Type: application/force-download');
		header('Content-Type: application/octet-stream');
		header('Content-Type: application/download');
		header('Content-Type: ' . $mimeType);
		header('Content-Disposition: attachment; filename="' . $name . '"');
		header('Content-Description: File Transfer');
		
		
		
		header('Content-MD5: ' . base64_encode( md5_file($file, true) ) );
		header('X-Robots-Tag: noindex, nofollow, noarchive', true);
		readfile($file);
		
	}

	public function ajax() {
		
		global $db;
		
		if( isset($_SESSION['isAdmin']) ) {
			$isAdmin = $_SESSION['isAdmin'];
		}
		else {
			$_SESSION['isAdmin'] = $isAdmin = false;
		}
		
		switch( $_GET['page'] ) {
			
			case 'tagList':
				
				open_db();
				
				$tagManager = new tagManager($db);
				
				$tagList = $tagManager->getAll(true, false);
				
				close_db();
				
				header('Content-Type: application/json');
				echo json_encode( $tagList );
				
				return;
			
			case 'editObject':
				
				if( ! $isAdmin ) {
					notFound();
					return;
				}
				
				switch( $_POST['element'] ) {
					
					case 'addTag':
						if( !isset($_POST['id']) || !isset($_POST['name']) || !ctype_print($_POST['name']) ) {
							notFound();
							return;
						}
						
						$_POST['id'] = (int) $_POST['id'];
						
						$return = array();
						
						open_db();
						
						$objectManager = new objectManager($db);
						
						$return['status'] = $objectManager->addTag($_POST['name'], $_POST['id']);
						
						$tagManager = new tagManager($db);
						
						$tagList = $tagManager->getBy('name', $_POST['name']);
						
						close_db();
						
						if( is_array($tagList) && isset($tagList[0]) && ($tag = $tagList[0]) instanceof tag ) {
							$return['PREFIX_LINK_LANG'] = PREFIX_LINK_LANG;
							$return['id'] = $tag->ID();
							$return['name'] = $tag->name();
							$return['nameToUrl'] = stringToUrl( $tag->name() );
						}
						else{
							$return['status'] = false;
							$return['errMsg'] = 'database unreachable';
						}
						
						header('Content-Type: application/json');
						echo json_encode( $return );
						
						return;
					
					case 'deleteTag':
						if( !isset($_POST['idObject']) || !isset($_POST['idTag']) ) {
							notFound();
							return;
						}
						
						$_POST['idObject'] = (int) $_POST['idObject'];
						$_POST['idTag'] = (int) $_POST['idTag'];
						
						$return = array();
						
						open_db();
						
						$objectManager = new objectManager($db);
						
						$return['status'] = $objectManager->deleteTag($_POST['idTag'], $_POST['idObject']);
						
						close_db();
						
						$return['id'] = $_POST['idTag'];
						
						header('Content-Type: application/json');
						echo json_encode( $return );
						
						return;
					
					case 'nameFile':
						
						if( !isset($_POST['id']) || !isset($_POST['name']) || !ctype_print($_POST['name']) || !isset($_POST['ext']) || !ctype_print( $_POST['ext'] = trim($_POST['ext']) ) || strrpos( $_POST['ext'], '.') != strpos( $_POST['ext'], '.') || strpos( $_POST['ext'], '.') !== 0 ) {
							notFound();
							return;
						}
						
						$_POST['id'] = (int) $_POST['id'];
						
						$name = $_POST['name'] . $_POST['ext'];
						
						$return = array();
						
						open_db();
						
						$objectManager = new objectManager($db);
						
						$obj = $objectManager->update('name', $name, 'ID', $_POST['id'], false, false);
						
						close_db();
						
						if( $obj instanceof object ) {
							$return['status'] = true;
							$return['result'] = $_POST['name'];
						}
						else {
							$return['status'] = false;
						}
						
						header('Content-Type: application/json');
						echo json_encode( $return );
						
						return;
					
					case 'description':
						
						if( !isset($_POST['id']) || !isset($_POST['description']) || !is_string($_POST['description']) ) {
							notFound();
							return;
						}
						
						$_POST['id'] = (int) $_POST['id'];
						$_POST['description'] = trim($_POST['description']);
						
						$return = array();
						
						open_db();
						
						$objectManager = new objectManager($db);
						
						$obj = $objectManager->update('description', $_POST['description'], 'ID', $_POST['id'], false, false);
						
						close_db();
						
						if( $obj instanceof object ) {
							$return['status'] = true;
							$return['result'] = $obj->description();
						}
						else {
							$return['status'] = false;
						}
						
						header('Content-Type: application/json');
						echo json_encode( $return );
						
						return;
					
					
					
				}
				
				return;
			
			
			case 'editTag':
				
				if( ! $isAdmin ) {
					notFound();
					return;
				}
				
				switch( $_POST['element'] ) {
					
					case 'rename':
						
						if( !isset($_POST['id']) || !isset($_POST['name']) || !ctype_print( ( $_POST['name'] = trim($_POST['name']) ) ) ) {
							notFound();
							return;
						}
						
						$_POST['id'] = (int) $_POST['id'];
						
						$return = array();
						
						open_db();
						
						$tagManager = new tagManager($db);
						
						$tag = $tagManager->update('name', $_POST['name'], 'ID', $_POST['id'], false, false);
						
						close_db();
						
						if( $tag instanceof tag ) {
							$return['status'] = true;
							$return['result'] = $_POST['name'];
						}
						else {
							$return['status'] = false;
						}
						
						header('Content-Type: application/json');
						echo json_encode( $return );
						
						return;
						
				}
				
				return;
			
			default :
				notFound();
		}
		
	}

	public function changeLang() {
		global $html;
		

		$resultChang = $html->lang($this->get['lang']);
		
		
		if(isset($_SERVER['HTTP_REFERER'])){
			$url = $_SERVER['HTTP_REFERER'];
			$lang = '';
			
			
			if(USER_LANGUAGE!=DEFAULT_LANGUAGE){
				$lang = USER_LANGUAGE .'/';
			}
			
			if(strpos($url, PREFIX_ABSOLUTE_LINK . $lang)===0){
				$page = substr_replace($url, '', 0, strlen(PREFIX_ABSOLUTE_LINK . $lang));
			}
			else{
				$page = '';
			}
			
			
			
		}
		
		$lang = '';
		
		if($resultChang && $this->get['lang']!=DEFAULT_LANGUAGE){
			$lang = $this->get['lang'].'/';
		}
		elseif( !$resultChang && USER_LANGUAGE!=DEFAULT_LANGUAGE){
			$lang = USER_LANGUAGE.'/';
		}
		
		
		$newUrl = PREFIX_ABSOLUTE_LINK . $lang . $page;
		
		
		http_redirect($page, array(), false, HTTP_REDIRECT_TEMP);
		return;
	}



	public function errorHttp() {
		http_send_status($this->code);
		header('Content-Type: text/html; charset=utf-8', true);
		header('X-Robots-Tag: noindex, nofollow, none, noarchive, nosnippet, noodp, noimageindex', true);
		error_log('Error HTTP '.$this->code.' le '.$_SERVER['REQUEST_TIME']."\r\n", 3, './offline/errorHttp.log');
		
		global $html;
		include $html->page($this->code);
	}


	public function maintenance() {
		http_send_status(403);
		header('Content-Type: text/html; charset=utf-8', true);
		header('X-Robots-Tag: noindex, nofollow, none, noarchive, nosnippet, noodp, noimageindex', true);
		
		global $html;
		include $html->page($this->name);
	}

}