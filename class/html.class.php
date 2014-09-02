<?php
class html {
	protected $supportedLang = array('en'); // in lower case // add it in the .htaccess to
	protected $defaultLanguage = DEFAULT_LANGUAGE; // in lowercase
	protected $lang = '';
	protected $option;
	protected $wayToGeoIpPath = './offline/geoip'; // without / at the end
	
	//Flags
		//LANG
			const NO_FORCE_LANG = 0x1;
			const NO_DEFINE_LANG = 0x2;
			const FORCE_LANG_EN = 0x4;
		
		// COOKIES
			const NO_DEFINE_COOKIES = 0x10;
		
		//Mixed
			const NO_FORCE_LANG_WITHOUT_COOKIES = 0x11; // self::NO_FORCE_LANG | self::NO_DEFINE_COOKIES
			const NO_DEFINE_LANG_WITHOUT_COOKIES = 0x12; // self::NO_DEFINE_LANG | self::NO_DEFINE_COOKIES
			
			
			

	public function __construct( $option = self::NO_FORCE_LANG ) {
		$this->option = $option;
		if( !($option & self::NO_DEFINE_LANG) ) {
			$this->chooseLanguage();
		}
	}

	public function chooseLanguage() { // language detection
		
		$return = false;
		
		if( $this->option & self::FORCE_LANG_EN ) {
			$return = $this->lang('en');
		}
		if( isset($_COOKIE['htmlLang']) && in_array($_COOKIE['htmlLang'], $this->supportedLang) ) {
			$this->lang = mb_strtolower($_COOKIE['htmlLang']);
			// $return = $this->lang($_COOKIE['htmlLang']);
			$return = true;
		}
		if( !$return ) {
			if( isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) )
				$httpAcceptLanguage = explode(',', str_replace(';', ',', $_SERVER['HTTP_ACCEPT_LANGUAGE']) );
			else
				$httpAcceptLanguage = array();
			
			foreach($httpAcceptLanguage as $language) {
				if( false !== ( $positionEgal = strpos($language,'-') ) ) {
					$language = substr($language, $positionEgal); // = strstr($language, '-', true) but not only with PHP >= 5.3.0
				}
				if( false === strpos($language,'=') ) {
					$return = $this->lang($language);
					break;
				}
			}
		}
		if( !$return && isset($_SERVER['HTTP_CF_IPCOUNTRY']) ) { // CloudFlare country detection
			$return = $this->lang($_SERVER['HTTP_CF_IPCOUNTRY']);
		}
		if( !$return ) { // GEOIP contry Detection
			
			require_once $this->wayToGeoIpPath . '/geoipcity.inc.php';
			$geoipDatabase = geoip_open($this->wayToGeoIpPath . '/GeoLiteCity.dat', GEOIP_STANDARD);
			$record = geoip_record_by_addr($geoipDatabase, $_SERVER['REMOTE_ADDR']);
			if( is_object($record) && !empty($record->country_code) ) {
				$return = $this->lang($record->country_code);
			}
		}
		if(  !$return  &&  !empty($this->defaultLanguage)  )  {
			$return = $this->lang($this->defaultLanguage);
		}
		if( !$return ) {
			$return = $this->lang($this->supportedLang[0]);
		}
		return $return;
	}

	public function lang( $lang = null ) {
		
		if( $lang === null ) {
			return $this->lang;
		}
		elseif( in_array( ( $lang = mb_strtolower($lang) ), $this->supportedLang ) ) {
			$this->lang = $_COOKIE['htmlLang'] = $lang;
			if( !($this->option & self::NO_DEFINE_COOKIES) ) {
				$_COOKIE['htmlLang'] = $this->lang;
				setcookie('htmlLang', $lang, time()+365*24*3600, '/', null, false, true); // si le cookie existe, la date sera repoussé à dans un an.
			}
			return true;
		}
		return false;
		
	}

	public function getSupportedLang() {
		return $this->supportedLang;
	}

	static public function hashFileWay( array $key ) {
		$jsonCachedValue = json_encode($key); // why json_encode : 
		$hash = md5($jsonCachedValue) . sha1($jsonCachedValue);
		
		return $hash;
		
	}

	public function getCachedFileWay( $page, array $key ) {
		$hash = self::hashFileWay( $key );
		
		if( file_exists('cache/' . $this->lang . '/' . $page . '.' . $hash . '.cache') )
			return 'cache/' . $this->lang . '/' . $page . '.' . $hash . '.cache';
		
		if( file_exists('cache/' . $page . '.' . $hash . '.cache') )
			return 'cache/' . $page . '.' . $hash . '.cache';
		
		return false;
		
	}

	public function cacheIt($page, $html, array $key, $rewrite = false) {
		$hash = self::hashFileWay( $key );
		
		if( empty($this->lang) )
			$fileName = 'cache/' . $page . '.' . $hash . '.cache';
		else
			$fileName = 'cache/' . $this->lang . '/' . $page . '.' . $hash . '.cache';
		
		if( DEVELOPPEMENT || (file_exists($fileName) && !$rewrite) )
			return false;
		
		return file_put_contents($fileName, $html);
	}

	public function isCached( $page, array $key ) {
		return !DEVELOPPEMENT && $this->getCachedFileWay($page, $key);
	}

	public function readCachedFile( $page, array $key, $returnHtml = false ) {
		// var_dump($this->getCachedFileWay($page, $key), $returnHtml, file_get_contents($this->getCachedFileWay($page, $key)));
		
		if( $this->getCachedFileWay($page, $key) ) {
			if( $returnHtml )
				return file_get_contents($this->getCachedFileWay($page, $key));
			else {
				readfile( $this->getCachedFileWay($page, $key) );
				return true;
			}
		}
		
		return false;
	}

	public function doctype() {
		return $this->page('doctype');
	}

	public function header() {
		return $this->page('header');
	}

	public function footer() {
		return $this->page('footer');
	}

	public function page($page) {
		if( file_exists('vue/' . $this->lang . '/' . $page . '.min.php') ) {
			return 'vue/' . $this->lang . '/' . $page . '.min.php';
		}
		elseif( file_exists('vue/' . $this->lang . '/' . $page . '.php') ) {
			return 'vue/' . $this->lang . '/' . $page . '.php';
		}
		elseif( file_exists('vue/' . $page . '.min.php') ) {
			return 'vue/' . $page . '.min.php';
		}
		return 'vue/' . $page . '.php';
	}
}
