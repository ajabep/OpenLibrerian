<?php


function notFound(){
	$controlerObj=new controler('404');
	$controlerObj->exec($_GET);
	exit;
}

function dbProblem($file, $line){
	error_log('An db error is catch : in ' . $file . ':' . $line);
	error_log('An db error is catch : in ' . $file . ':' . $line, 1, DEVELOPPER_EMAIL);
	http_send_status(503);
	exit('The database have a problem. Thank you try again later. If it\'s continu, contact the webmaster at "'.DB_EMAIL.'".');
}

function clearDir($dir, array $except = array()) {
	$opendir = @opendir($dir);
	
	if (!$opendir) return false;
	
	while( $file = readdir($opendir) ) {
		
		if( $file == '.' || $file == '..' ) continue;
		

var_dump($dir . '/' . $file);continue;

		
		if( is_dir( $dir . '/' . $file ) && in_array($dir . '/' . $file, $except) ) {
			$r = clearDir( $dir . '/' . $file );
			if( !$r ) return false;
		}
		else {
			$r = @unlink( $dir . '/' . $file );
			if( !$r ) return false;
		}
	}
	
	closedir( $opendir );
	
	$rm = @rmdir($dir);
	
	if( !$rm ) return false;
	
	return true;
}

function getMimeType( $ext ) {
	
	// Mime Type
	
	
	//know 1076 extentions
	switch($ext){
		//image
		case 'gif':        $mimeType='image/gif'; break;
		case 'png':        $mimeType='image/png'; break;
		case 'jpeg':
		case 'jpg':
		case 'jpe':
		case 'jfif':       $mimeType='image/jpeg'; break;
		case 'bmp':        $mimeType='image/bmp'; break;
		case 'ico':        $mimeType='image/vnd.microsoft.icon'; break;
		case 'tif':
		case 'tiff':       $mimeType='image/tiff'; break;
		case 'svgz':
		case 'svgz':       header('Content-encoding: gzip');
		case 'svg':        $mimeType='image/svg+xml'; break;
		case 'webp':       $mimeType='image/webp'; break;
		case 'cgm':        $mimeType='image/cgm'; break;
		case 'dpx':        $mimeType='image/dpx'; break;
		case 'g3':         $mimeType='image/fax-g3'; break;
		case 'ief':        $mimeType='image/ief'; break;
		case 'jp2':        $mimeType='image/jpeg2000'; break;
		case 'rle':        $mimeType='image/rle'; break;
		case 'djv':
		case 'djvu':       $mimeType='image/vnd.djvu'; break;
		case 'dwg':        $mimeType='image/vnd.dwg'; break;
		case 'dxf':        $mimeType='image/vnd.dxf'; break;
		case '3ds':        $mimeType='image/x-3ds'; break;
		case 'ag':         $mimeType='image/x-applix-graphics'; break;
		case 'ras':        $mimeType='image/x-cmu-raster'; break;
		case 'bay':
		case 'bmq':
		case 'cr2':
		case 'crw':
		case 'cs1':
		case 'dc2':
		case 'dcr':
		case 'fff':
		case 'k25':
		case 'kdc':
		case 'mos':
		case 'mrw':
		case 'nef':
		case 'orf':
		case 'pef':
		case 'raf':
		case 'rdc':
		case 'srf':
		case 'x3f':
		case 'kdc':        $mimeType='image/x-dcraw'; break;
		case 'eps':
		case 'epsi':
		case 'epsf':       $mimeType='image/x-eps'; break;
		case 'fits':       $mimeType='image/x-fits'; break;
		case 'icb':        $mimeType='image/x-icb'; break;
		case 'iff':        $mimeType='image/x-iff'; break;
		case 'ilbm':       $mimeType='image/x-ilbm'; break;
		case 'jng':        $mimeType='image/x-jng'; break;
		case 'lwo':
		case 'lwob':       $mimeType='image/x-lwo'; break;
		case 'lws':        $mimeType='image/x-lws'; break;
		case 'msod':       $mimeType='image/x-msod'; break;
		case 'pcd':        $mimeType='image/x-photo-cd'; break;
		case 'pict':
		case 'pict1':
		case 'pict2':      $mimeType='image/x-pict'; break;
		case 'pnm':        $mimeType='image/x-portable-anymap'; break;
		case 'pbm':        $mimeType='image/x-portable-bitmap'; break;
		case 'pgm':        $mimeType='image/x-portable-graymap'; break;
		case 'ppm':        $mimeType='image/x-portable-pixmap'; break;
		case 'psd':        $mimeType='image/x-psd'; break;
		case 'rgb':        $mimeType='image/x-rgb'; break;
		case 'sgi':        $mimeType='image/x-sgi'; break;
		case 'sun':        $mimeType='image/x-sun-raster'; break;
		case 'tga':        $mimeType='image/x-tga'; break;
		case 'cur':        $mimeType='image/x-win-bitmap'; break;
		case 'wmf':        $mimeType='image/x-wmf'; break;
		case 'xbm':        $mimeType='image/x-xbitmap'; break;
		case 'xcf':        $mimeType='image/x-xcf'; break;
		case 'fig':        $mimeType='image/x-xfig'; break;
		case 'xpm':        $mimeType='image/x-xpixmap'; break;
		case 'xwd':        $mimeType='image/x-xwindowdump'; break;
		case 'cmx':        $mimeType='image/x-cmx'; break;
		case 'cod':        $mimeType='image/cis-cod'; break;
		case 'wbmp':       $mimeType='image/vnd.wap.wbmp'; break;
	/////////////////////
		case 'btif':       $mimeType='image/prs.btif'; break;
		case 'fbs':        $mimeType='image/vnd.fastbidsheet'; break;
		case 'fh':         $mimeType='image/x-freehand'; break;
		case 'fh4':        $mimeType='image/x-freehand'; break;
		case 'fh5':        $mimeType='image/x-freehand'; break;
		case 'fh7':        $mimeType='image/x-freehand'; break;
		case 'fhc':        $mimeType='image/x-freehand'; break;
		case 'fpx':        $mimeType='image/vnd.fpx'; break;
		case 'fst':        $mimeType='image/vnd.fst'; break;
		case 'ktx':        $mimeType='image/ktx'; break;
		case 'mdi':        $mimeType='image/vnd.ms-modi'; break;
		case 'mmr':        $mimeType='image/vnd.fujixerox.edmics-mmr'; break;
		case 'npx':        $mimeType='image/vnd.net-fpx'; break;
		case 'pct':        $mimeType='image/x-pict'; break;
		case 'pcx':        $mimeType='image/x-pcx'; break;
		case 'pic':        $mimeType='image/x-pict'; break;
		case 'rlc':        $mimeType='image/vnd.fujixerox.edmics-rlc'; break;
		case 'sid':        $mimeType='image/x-mrsid-image'; break;
		case 'sub':        $mimeType='image/vnd.dvb.subtitle'; break;
		case 'uvg':        $mimeType='image/vnd.dece.graphic'; break;
		case 'uvi':        $mimeType='image/vnd.dece.graphic'; break;
		case 'uvvg':       $mimeType='image/vnd.dece.graphic'; break;
		case 'uvvi':       $mimeType='image/vnd.dece.graphic'; break;
		case 'wdp':        $mimeType='image/vnd.ms-photo'; break;
		case 'xif':        $mimeType='image/vnd.xiff'; break;

		//audio
		case 'mp3':        $mimeType='audio/mpeg'; break;
		case 'wav':        $mimeType='audio/x-wav'; break;
		case 'oga':
		case 'ogg':        $mimeType='audio/ogg'; break;
		case 'm4a':
		case 'f4a':
		case 'f4b':        $mimeType='audio/mp4'; break;
		case 'aif':
		case 'aiff':       $mimeType='audio/aiff'; break;
		case 'aifc':       $mimeType='audio/x-aiff'; break;
		case 'au':
		case 'snd':        $mimeType='audio/basic'; break;
		case 'mid':
		case 'rmi':        $mimeType='audio/mid'; break;
		case 'ra':
		case 'ram':        $mimeType='audio/x-pn-realaudio'; break;
		case 'm3u':        $mimeType='audio/x-mpegurl'; break;
		case 'midi':
		case 'kar':        $mimeType='audio/midi'; break;
		case 'mpga':       $mimeType='audio/mpeg'; break;
	/////////////////////
		case 'aac':        $mimeType='audio/x-aac'; break;
		case 'adp':        $mimeType='audio/adpcm'; break;
		case 'caf':        $mimeType='audio/x-caf'; break;
		case 'dra':        $mimeType='audio/vnd.dra'; break;
		case 'dts':        $mimeType='audio/vnd.dts'; break;
		case 'dtshd':      $mimeType='audio/vnd.dts.hd'; break;
		case 'ecelp4800':  $mimeType='audio/vnd.nuera.ecelp4800'; break;
		case 'ecelp7470':  $mimeType='audio/vnd.nuera.ecelp7470'; break;
		case 'ecelp9600':  $mimeType='audio/vnd.nuera.ecelp9600'; break;
		case 'eol':        $mimeType='audio/vnd.digital-winds'; break;
		case 'flac':       $mimeType='audio/x-flac'; break;
		case 'lvp':        $mimeType='audio/vnd.lucent.voice'; break;
		case 'm2a':        $mimeType='audio/mpeg'; break;
		case 'm3a':        $mimeType='audio/mpeg'; break;
		case 'mka':        $mimeType='audio/x-matroska'; break;
		case 'mp2a':       $mimeType='audio/mpeg'; break;
		case 'mp4a':       $mimeType='audio/mp4'; break;
		case 'pya':        $mimeType='audio/vnd.ms-playready.media.pya'; break;
		case 'rip':        $mimeType='audio/vnd.rip'; break;
		case 'rmp':        $mimeType='audio/x-pn-realaudio-plugin'; break;
		case 's3m':        $mimeType='audio/s3m'; break;
		case 'sil':        $mimeType='audio/silk'; break;
		case 'spx':        $mimeType='audio/ogg'; break;
		case 'uva':        $mimeType='audio/vnd.dece.audio'; break;
		case 'uvva':       $mimeType='audio/vnd.dece.audio'; break;
		case 'wax':        $mimeType='audio/x-ms-wax'; break;
		case 'weba':       $mimeType='audio/webm'; break;
		case 'wma':        $mimeType='audio/x-ms-wma'; break;
		case 'xm':         $mimeType='audio/xm'; break;


		//video
		case 'wmv':        $mimeType='video/x-ms-wmv'; break;
		case 'lsf':
		case 'asr':
		case 'lsx':
		case 'asx':        $mimeType='video/x-ms-asf'; break;
		case 'ogv':        $mimeType='video/ogg'; break;
		case 'webm':       $mimeType='video/webm'; break;
		case 'mp2':
		case 'mpa':
		case 'mpv2':
		case 'mpeg':
		case 'mpg':
		case 'mpe':        $mimeType='video/mpeg'; break;
		case 'qt':
		case 'mov':        $mimeType='video/quicktime'; break;
		case 'avi':        $mimeType='video/x-msvideo'; break;
		case 'flv':        $mimeType='video/x-flv'; break;
		case '3gp':        $mimeType='video/3gpp'; break;
		case '3g2':        $mimeType='video/3g2'; break;
		case 'mp4':
		case 'm4v':
		case 'f4v':
		case 'f4p':        $mimeType='video/mp4'; break;
		case 'asf':        $mimeType='video/asf'; break;
		case 'movie':      $mimeType='video/x-sgi-movie'; break;
		case 'mxu':        $mimeType='video/vnd.mpegurl'; break;
	/////////////////////
		case 'dvb':        $mimeType='video/vnd.dvb.file'; break;
		case 'fli':        $mimeType='video/x-fli'; break;
		case 'fvt':        $mimeType='video/vnd.fvt'; break;
		case 'h261':       $mimeType='video/h261'; break;
		case 'h263':       $mimeType='video/h263'; break;
		case 'h264':       $mimeType='video/h264'; break;
		case 'jpgm':       $mimeType='video/jpm'; break;
		case 'jpgv':       $mimeType='video/jpeg'; break;
		case 'jpm':        $mimeType='video/jpm'; break;
		case 'm1v':        $mimeType='video/mpeg'; break;
		case 'm2v':        $mimeType='video/mpeg'; break;
		case 'm4u':        $mimeType='video/vnd.mpegurl'; break;
		case 'mj2':        $mimeType='video/mj2'; break;
		case 'mjp2':       $mimeType='video/mj2'; break;
		case 'mk3d':       $mimeType='video/x-matroska'; break;
		case 'mks':        $mimeType='video/x-matroska'; break;
		case 'mkv':        $mimeType='video/x-matroska'; break;
		case 'mng':        $mimeType='video/x-mng'; break;
		case 'mp4v':       $mimeType='video/mp4'; break;
		case 'mpg4':       $mimeType='video/mp4'; break;
		case 'pyv':        $mimeType='video/vnd.ms-playready.media.pyv'; break;
		case 'smv':        $mimeType='video/x-smv'; break;
		case 'uvh':        $mimeType='video/vnd.dece.hd'; break;
		case 'uvm':        $mimeType='video/vnd.dece.mobile'; break;
		case 'uvp':        $mimeType='video/vnd.dece.pd'; break;
		case 'uvs':        $mimeType='video/vnd.dece.sd'; break;
		case 'uvu':        $mimeType='video/vnd.uvvu.mp4'; break;
		case 'uvv':        $mimeType='video/vnd.dece.video'; break;
		case 'uvvh':       $mimeType='video/vnd.dece.hd'; break;
		case 'uvvm':       $mimeType='video/vnd.dece.mobile'; break;
		case 'uvvp':       $mimeType='video/vnd.dece.pd'; break;
		case 'uvvs':       $mimeType='video/vnd.dece.sd'; break;
		case 'uvvu':       $mimeType='video/vnd.uvvu.mp4'; break;
		case 'uvvv':       $mimeType='video/vnd.dece.video'; break;
		case 'viv':        $mimeType='video/vnd.vivo'; break;
		case 'vob':        $mimeType='video/x-ms-vob'; break;
		case 'wm':         $mimeType='video/x-ms-wm'; break;
		case 'wmx':        $mimeType='video/x-ms-wmx'; break;
		case 'wvx':        $mimeType='video/x-ms-wvx'; break;

		//text
		case '323':        $mimeType='text/h323'; break;
		case 'etx':        $mimeType='text/x-setext'; break;
		case 'stm':
		case 'htm':
		case 'html':       $mimeType='text/html'; break;
		case 'htt':        $mimeType='text/webviewhtml'; break;
		case 'css':        $mimeType='text/css'; break;
		case 'asc':
		case 'bas':
		case 'c':
		case 'csv':
		case 'h':
		case 'txt':        $mimeType='text/plain'; break;
		case 'appcache':
		case 'manifest':   $mimeType='text/cache-manifest'; break;
		case 'rtx':
		case 'ctx':        $mimeType='text/richtext'; break;
		case 'uls':        $mimeType='text/iuls'; break;
		case 'sct':        $mimeType='text/scriptlet'; break;
		case 'htc':        $mimeType='text/x-component'; break;
		case 'tsv':        $mimeType='text/tab-separated-values'; break;
		case 'vcf':        $mimeType='text/x-vcard'; break;
		case 'vtt':        $mimeType='text/vtt'; break;
		case 'ics':
		case 'ifb':        $mimeType='text/calendar'; break;
		case 'wml':        $mimeType='text/vnd.wap.wml'; break;
		case 'wmls':       $mimeType='text/vnd.wap.wmlscript'; break;
		case 'sgml':
		case 'sgm':        $mimeType='text/sgml'; break;
	/////////////////////
		case '3dml':       $mimeType='text/vnd.in3d.3dml'; break;
		case 'asm':        $mimeType='text/x-asm'; break;
		case 'cc':         $mimeType='text/x-c'; break;
		case 'conf':       $mimeType='text/plain'; break;
		case 'cpp':        $mimeType='text/x-c'; break;
		case 'curl':       $mimeType='text/vnd.curl'; break;
		case 'cxx':        $mimeType='text/x-c'; break;
		case 'dcurl':      $mimeType='text/vnd.curl.dcurl'; break;
		case 'def':        $mimeType='text/plain'; break;
		case 'dic':        $mimeType='text/x-c'; break;
		case 'dsc':        $mimeType='text/prs.lines.tag'; break;
		case 'f':          $mimeType='text/x-fortran'; break;
		case 'f77':        $mimeType='text/x-fortran'; break;
		case 'f90':        $mimeType='text/x-fortran'; break;
		case 'flx':        $mimeType='text/vnd.fmi.flexstor'; break;
		case 'fly':        $mimeType='text/vnd.fly'; break;
		case 'for':        $mimeType='text/x-fortran'; break;
		case 'gv':         $mimeType='text/vnd.graphviz'; break;
		case 'hh':         $mimeType='text/x-c'; break;
		case 'in':         $mimeType='text/plain'; break;
		case 'jad':        $mimeType='text/vnd.sun.j2me.app-descriptor'; break;
		case 'java':       $mimeType='text/x-java-source'; break;
		case 'list':       $mimeType='text/plain'; break;
		case 'log':        $mimeType='text/plain'; break;
		case 'mcurl':      $mimeType='text/vnd.curl.mcurl'; break;
		case 'n3':         $mimeType='text/n3'; break;
		case 'nfo':        $mimeType='text/x-nfo'; break;
		case 'opml':       $mimeType='text/x-opml'; break;
		case 'p':          $mimeType='text/x-pascal'; break;
		case 'pas':        $mimeType='text/x-pascal'; break;
		case 's':          $mimeType='text/x-asm'; break;
		case 'scurl':      $mimeType='text/vnd.curl.scurl'; break;
		case 'sfv':        $mimeType='text/x-sfv'; break;
		case 'spot':       $mimeType='text/vnd.in3d.spot'; break;
		case 'sub':        $mimeType='text/vnd.dvb.subtitle'; break;
		case 'text':       $mimeType='text/plain'; break;
		case 'ttl':        $mimeType='text/turtle'; break;
		case 'uri':
		case 'uris':
		case 'urls':       $mimeType='text/uri-list'; break;
		case 'uu':         $mimeType='text/x-uuencode'; break;
		case 'vcard':      $mimeType='text/vcard'; break;
		case 'vcs':        $mimeType='text/x-vcalendar'; break;

		//application
		case 'jsonp':
		case 'js':         $mimeType='application/javascript'; break;
		case 'json':       $mimeType='application/json'; break;
		case 'php':        $mimeType='application/php'; break;
		case 'pdf':        $mimeType='application/pdf'; break;
		case 'zip':        $mimeType='application/zip'; break;
		case 'tar':        $mimeType='application/x-tar'; break;
		case 'gz':         $mimeType='application/x-compressed-tar'; break;
		case 'dot':
		case 'doc':
		case 'docx':       $mimeType='application/msword'; break;
		case 'xls':
		case 'xlt':
		case 'xlm':
		case 'xld':
		case 'xla':
		case 'xlc':
		case 'xlw':
		case 'xll':
		case 'xlsx':       $mimeType='application/vnd.ms-excel'; break;
		case 'ppt':
		case 'pps':
		case 'pot':
		case 'pptx':       $mimeType='application/vnd.ms-powerpoint'; break;
		case 'rtf':        $mimeType='application/rtf'; break;
		case 'rss':
		case 'atom':
		case 'xsl':
		case 'xml':
		case 'rdf':        $mimeType='application/xml'; break;
		case 'swf':        $mimeType='application/x-shockwave-flash'; break;
		case 'eot':        $mimeType='application/vnd.ms-fontobject'; break;
		case 'ttc':
		case 'ttf':        $mimeType='application/x-font-ttf'; break;
		case 'woff':       $mimeType='application/x-font-woff'; break;
		case 'crx':        $mimeType='application/x-chrome-extension'; break;
		case 'oex':        $mimeType='application/x-opera-extension'; break;
		case 'xpi':        $mimeType='application/x-xpinstall'; break;
		case 'webapp':     $mimeType='application/x-web-app-manifest+json'; break;
		case 'acx':        $mimeType='application/internet-property-stream'; break;
		case 'ps':
		case 'ai':         $mimeType='application/postscript'; break;
		case 'axs':        $mimeType='application/olescript'; break;
		case 'bcpio':      $mimeType='application/x-bcpio'; break;
		case 'cat':        $mimeType='application/vnd.ms-pkiseccat'; break;
		case 'cdf':        $mimeType='application/x-cdf'; break;
		case 'cer':        $mimeType='application/x-x509-ca-cert'; break;
		case 'clp':        $mimeType='application/x-msclip'; break;
		case 'cpio':       $mimeType='application/x-cpio'; break;
		case 'crd':        $mimeType='application/x-mscardfile'; break;
		case 'crl':        $mimeType='application/pkix-crl'; break;
		case 'crt':        $mimeType='application/x-x509-ca-cert'; break;
		case 'csh':        $mimeType='application/x-csh'; break;
		case 'der':        $mimeType='application/x-x509-ca-cert'; break;
		case 'dxr':
		case 'dir':        $mimeType='application/x-director'; break;
		case 'dll':        $mimeType='application/x-msdownload'; break;
		case 'dvi':        $mimeType='application/x-dvi'; break;
		case 'evy':        $mimeType='application/envoy'; break;
		case 'fif':        $mimeType='application/fractals'; break;
		case 'gtar':       $mimeType='application/x-gtar'; break;
		case 'hdf':        $mimeType='application/x-hdf'; break;
		case 'hlp':        $mimeType='application/winhlp'; break;
		case 'hqx':        $mimeType='application/mac-binhex40'; break;
		case 'hta':        $mimeType='application/hta'; break;
		case 'iii':        $mimeType='application/x-iphone'; break;
		case 'isp':
		case 'ins':        $mimeType='application/x-internet-signup'; break;
		case 'latex':      $mimeType='application/x-latex'; break;
		case 'm13':
		case 'm14':
		case 'mvb':        $mimeType='application/x-msmediaview'; break;
		case 'mny':        $mimeType='application/x-msmoney'; break;
		case 'man':        $mimeType='application/x-troff-man'; break;
		case 'mdb':        $mimeType='application/x-msaccess'; break;
		case 'me':         $mimeType='application/x-troff-me'; break;
		case 'ms':         $mimeType='application/x-troff-ms'; break;
		case 'mpp':        $mimeType='application/vnd.ms-project'; break;
		case 'oda':        $mimeType='application/oda'; break;
		case 'p10':        $mimeType='application/pkcs10'; break;
		case 'pfx':
		case 'p12':        $mimeType='application/x-pkcs12'; break;
		case 'p7b':
		case 'spc':        $mimeType='application/x-pkcs7-certificates'; break;
		case 'p7c':
		case 'p7m':        $mimeType='application/x-pkcs7-mime'; break;
		case 'p7r':        $mimeType='application/x-pkcs7-certreqresp'; break;
		case 'p7s':        $mimeType='application/x-pkcs7-signature'; break;
		case 'pko':        $mimeType='application/ynd.ms-pkipko'; break;
		case 'pml':
		case 'pmr':
		case 'pmw':
		case 'pmc':
		case 'pma':        $mimeType='application/x-perfmon'; break;
		case 'prf':        $mimeType='application/pics-rules'; break;
		case 'pub':        $mimeType='application/x-mspublisher'; break;
		case 'tr':
		case 't':
		case 'roff':       $mimeType='application/x-troff'; break;
		case 'scd':        $mimeType='application/x-msschedule'; break;
		case 'setpay':     $mimeType='application/set-payment-initiation'; break;
		case 'setreg':     $mimeType='application/set-registration-initiation'; break;
		case 'sh':         $mimeType='application/x-sh'; break;
		case 'shar':       $mimeType='application/x-shar'; break;
		case 'sit':        $mimeType='application/x-stuffit'; break;
		case 'wdb':
		case 'wks':
		case 'wps':
		case 'wcm':        $mimeType='application/vnd.ms-works'; break;
		case 'wri':        $mimeType='application/x-mswrite'; break;
		case 'spl':        $mimeType='application/futuresplash'; break;
		case 'src':        $mimeType='application/x-wais-source'; break;
		case 'sst':        $mimeType='application/vnd.ms-pkicertstore'; break;
		case 'stl':        $mimeType='application/vnd.ms-pkistl'; break;
		case 'sv4cpio':    $mimeType='application/x-sv4cpio'; break;
		case 'sv4crc':     $mimeType='application/x-sv4crc'; break;
		case 'tcl':        $mimeType='application/x-tcl'; break;
		case 'tex':        $mimeType='application/x-tex'; break;
		case 'texi':
		case 'texinfo':    $mimeType='application/x-texinfo'; break;
		case 'tgz':        $mimeType='application/x-compressed'; break;
		case 'trm':        $mimeType='application/x-msterminal'; break;
		case 'ustar':      $mimeType='application/x-ustar'; break;
		case 'z':          $mimeType='application/x-compress'; break;
		case 'cpt':        $mimeType='application/mac-compactpro'; break;
		case 'dtd':        $mimeType='application/xml-dtd'; break;
		case 'ez':         $mimeType='application/andrew-inset'; break;
		case 'gram':       $mimeType='application/srgs'; break;
		case 'mathml':     $mimeType='application/mathml+xml'; break;
		case 'mif':        $mimeType='application/vdn.mif'; break;
		case 'nc':         $mimeType='application/x-netcdf'; break;
		case 'pgn':        $mimeType='application/x-chess-pgn'; break;
		case 'rm':         $mimeType='application/vnd.rn-realmedia'; break;
		case 'skd':
		case 'skm':
		case 'skp':
		case 'skt':        $mimeType='application/x-koan'; break;
		case 'smil':
		case 'smi':        $mimeType='application/smil'; break;
		case 'vcd':
		case 'gvcdram':    $mimeType='application/x-cdlink'; break;
		case 'vxml':       $mimeType='application/voicexml+xml'; break;
		case 'wbxml':      $mimeType='application/vnd.wap.wbxml'; break;
		case 'wmlc':       $mimeType='application/vnd.wap.wmlc'; break;
		case 'wmlsc':      $mimeType='application/vnd.wap.wmlscriptc'; break;
		case 'xht':
		case 'xhtml':      $mimeType='application/xhtml+xml'; break;
		case 'xslt':       $mimeType='application/xslt+xml'; break;
		case 'xul':        $mimeType='application/vnd.mozilla.xul+xml'; break;
		case 'grxml':      $mimeType='application/srgs+xml'; break;
	/////////////////////
		case '123':        $mimeType='application/vnd.lotus-1-2-3'; break;
		case '7z':         $mimeType='application/x-7z-compressed'; break;
		case 'aab':        $mimeType='application/x-authorware-bin'; break;
		case 'aam':        $mimeType='application/x-authorware-map'; break;
		case 'aas':        $mimeType='application/x-authorware-seg'; break;
		case 'abw':        $mimeType='application/x-abiword'; break;
		case 'ac':         $mimeType='application/pkix-attr-cert'; break;
		case 'acc':        $mimeType='application/vnd.americandynamics.acc'; break;
		case 'ace':        $mimeType='application/x-ace-compressed'; break;
		case 'acu':        $mimeType='application/vnd.acucobol'; break;
		case 'acutc':      $mimeType='application/vnd.acucorp'; break;
		case 'aep':        $mimeType='application/vnd.audiograph'; break;
		case 'afm':        $mimeType='application/x-font-type1'; break;
		case 'afp':        $mimeType='application/vnd.ibm.modcap'; break;
		case 'ahead':      $mimeType='application/vnd.ahead.space'; break;
		case 'air':        $mimeType='application/vnd.adobe.air-application-installer-package+zip'; break;
		case 'ait':        $mimeType='application/vnd.dvb.ait'; break;
		case 'ami':        $mimeType='application/vnd.amiga.ami'; break;
		case 'apk':        $mimeType='application/vnd.android.package-archive'; break;
		case 'application':$mimeType='application/x-ms-application'; break;
		case 'apr':        $mimeType='application/vnd.lotus-approach'; break;
		case 'arc':        $mimeType='application/x-freearc'; break;
		case 'aso':        $mimeType='application/vnd.accpac.simply.aso'; break;
		case 'atc':        $mimeType='application/vnd.acucorp'; break;
		case 'atomcat':    $mimeType='application/atomcat+xml'; break;
		case 'atomsvc':    $mimeType='application/atomsvc+xml'; break;
		case 'atx':        $mimeType='application/vnd.antix.game-component'; break;
		case 'aw':         $mimeType='application/applixware'; break;
		case 'azf':        $mimeType='application/vnd.airzip.filesecure.azf'; break;
		case 'azs':        $mimeType='application/vnd.airzip.filesecure.azs'; break;
		case 'azw':        $mimeType='application/vnd.amazon.ebook'; break;
		case 'bat':        $mimeType='application/x-msdownload'; break;
		case 'bdf':        $mimeType='application/x-font-bdf'; break;
		case 'bdm':        $mimeType='application/vnd.syncml.dm+wbxml'; break;
		case 'bed':        $mimeType='application/vnd.realvnc.bed'; break;
		case 'bh2':        $mimeType='application/vnd.fujitsu.oasysprs'; break;
		case 'bin':        $mimeType='application/octet-stream'; break;
		case 'blb':        $mimeType='application/x-blorb'; break;
		case 'blorb':      $mimeType='application/x-blorb'; break;
		case 'bmi':        $mimeType='application/vnd.bmi'; break;
		case 'book':       $mimeType='application/vnd.framemaker'; break;
		case 'box':        $mimeType='application/vnd.previewsystems.box'; break;
		case 'boz':        $mimeType='application/x-bzip2'; break;
		case 'bpk':        $mimeType='application/octet-stream'; break;
		case 'bz':         $mimeType='application/x-bzip'; break;
		case 'bz2':        $mimeType='application/x-bzip2'; break;
		case 'c11amc':     $mimeType='application/vnd.cluetrust.cartomobile-config'; break;
		case 'c11amz':     $mimeType='application/vnd.cluetrust.cartomobile-config-pkg'; break;
		case 'c4d':        $mimeType='application/vnd.clonk.c4group'; break;
		case 'c4f':        $mimeType='application/vnd.clonk.c4group'; break;
		case 'c4g':        $mimeType='application/vnd.clonk.c4group'; break;
		case 'c4p':        $mimeType='application/vnd.clonk.c4group'; break;
		case 'c4u':        $mimeType='application/vnd.clonk.c4group'; break;
		case 'cab':        $mimeType='application/vnd.ms-cab-compressed'; break;
		case 'cap':        $mimeType='application/vnd.tcpdump.pcap'; break;
		case 'car':        $mimeType='application/vnd.curl.car'; break;
		case 'cb7':        $mimeType='application/x-cbr'; break;
		case 'cba':        $mimeType='application/x-cbr'; break;
		case 'cbr':        $mimeType='application/x-cbr'; break;
		case 'cbt':        $mimeType='application/x-cbr'; break;
		case 'cbz':        $mimeType='application/x-cbr'; break;
		case 'cct':        $mimeType='application/x-director'; break;
		case 'ccxml':      $mimeType='application/ccxml+xml'; break;
		case 'cdbcmsg':    $mimeType='application/vnd.contact.cmsg'; break;
		case 'cdkey':      $mimeType='application/vnd.mediastation.cdkey'; break;
		case 'cdmia':      $mimeType='application/cdmi-capability'; break;
		case 'cdmic':      $mimeType='application/cdmi-container'; break;
		case 'cdmid':      $mimeType='application/cdmi-domain'; break;
		case 'cdmio':      $mimeType='application/cdmi-object'; break;
		case 'cdmiq':      $mimeType='application/cdmi-queue'; break;
		case 'cdxml':      $mimeType='application/vnd.chemdraw+xml'; break;
		case 'cdy':        $mimeType='application/vnd.cinderella'; break;
		case 'cfs':        $mimeType='application/x-cfs-compressed'; break;
		case 'chat':       $mimeType='application/x-chat'; break;
		case 'chm':        $mimeType='application/vnd.ms-htmlhelp'; break;
		case 'chrt':       $mimeType='application/vnd.kde.kchart'; break;
		case 'cii':        $mimeType='application/vnd.anser-web-certificate-issue-initiation'; break;
		case 'cil':        $mimeType='application/vnd.ms-artgalry'; break;
		case 'cla':        $mimeType='application/vnd.claymore'; break;
		case 'class':      $mimeType='application/java-vm'; break;
		case 'clkk':       $mimeType='application/vnd.crick.clicker.keyboard'; break;
		case 'clkp':       $mimeType='application/vnd.crick.clicker.palette'; break;
		case 'clkt':       $mimeType='application/vnd.crick.clicker.template'; break;
		case 'clkw':       $mimeType='application/vnd.crick.clicker.wordbank'; break;
		case 'clkx':       $mimeType='application/vnd.crick.clicker'; break;
		case 'cmc':        $mimeType='application/vnd.cosmocaller'; break;
		case 'cmp':        $mimeType='application/vnd.yellowriver-custom-menu'; break;
		case 'com':        $mimeType='application/x-msdownload'; break;
		case 'cryptonote': $mimeType='application/vnd.rig.cryptonote'; break;
		case 'csp':        $mimeType='application/vnd.commonspace'; break;
		case 'cst':        $mimeType='application/x-director'; break;
		case 'cu':         $mimeType='application/cu-seeme'; break;
		case 'cww':        $mimeType='application/prs.cww'; break;
		case 'cxt':        $mimeType='application/x-director'; break;
		case 'daf':        $mimeType='application/vnd.mobius.daf'; break;
		case 'dart':       $mimeType='application/vnd.dart'; break;
		case 'dataless':   $mimeType='application/vnd.fdsn.seed'; break;
		case 'davmount':   $mimeType='application/davmount+xml'; break;
		case 'dbk':        $mimeType='application/docbook+xml'; break;
		case 'dd2':        $mimeType='application/vnd.oma.dd2+xml'; break;
		case 'ddd':        $mimeType='application/vnd.fujixerox.ddd'; break;
		case 'deb':        $mimeType='application/x-debian-package'; break;
		case 'deploy':     $mimeType='application/octet-stream'; break;
		case 'dfac':       $mimeType='application/vnd.dreamfactory'; break;
		case 'dgc':        $mimeType='application/x-dgc-compressed'; break;
		case 'dis':        $mimeType='application/vnd.mobius.dis'; break;
		case 'dist':       $mimeType='application/octet-stream'; break;
		case 'distz':      $mimeType='application/octet-stream'; break;
		case 'dmg':        $mimeType='application/x-apple-diskimage'; break;
		case 'dmp':        $mimeType='application/vnd.tcpdump.pcap'; break;
		case 'dms':        $mimeType='application/octet-stream'; break;
		case 'dna':        $mimeType='application/vnd.dna'; break;
		case 'docm':       $mimeType='application/vnd.ms-word.document.macroenabled.12'; break;
		case 'dotm':       $mimeType='application/vnd.ms-word.template.macroenabled.12'; break;
		case 'dotx':       $mimeType='application/vnd.openxmlformats-officedocument.wordprocessingml.template'; break;
		case 'dp':         $mimeType='application/vnd.osgi.dp'; break;
		case 'dpg':        $mimeType='application/vnd.dpgraph'; break;
		case 'dssc':       $mimeType='application/dssc+der'; break;
		case 'dtb':        $mimeType='application/x-dtbook+xml'; break;
		case 'dump':       $mimeType='application/octet-stream'; break;
		case 'dxp':        $mimeType='application/vnd.spotfire.dxp'; break;
		case 'ecma':       $mimeType='application/ecmascript'; break;
		case 'edm':        $mimeType='application/vnd.novadigm.edm'; break;
		case 'edx':        $mimeType='application/vnd.novadigm.edx'; break;
		case 'efif':       $mimeType='application/vnd.picsel'; break;
		case 'ei6':        $mimeType='application/vnd.pg.osasli'; break;
		case 'elc':        $mimeType='application/octet-stream'; break;
		case 'emf':        $mimeType='application/x-msmetafile'; break;
		case 'emma':       $mimeType='application/emma+xml'; break;
		case 'emz':        $mimeType='application/x-msmetafile'; break;
		case 'epub':       $mimeType='application/epub+zip'; break;
		case 'es3':        $mimeType='application/vnd.eszigno3+xml'; break;
		case 'esa':        $mimeType='application/vnd.osgi.subsystem'; break;
		case 'esf':        $mimeType='application/vnd.epson.esf'; break;
		case 'et3':        $mimeType='application/vnd.eszigno3+xml'; break;
		case 'eva':        $mimeType='application/x-eva'; break;
		case 'exe':        $mimeType='application/x-msdownload'; break;
		case 'exi':        $mimeType='application/exi'; break;
		case 'ext':        $mimeType='application/vnd.novadigm.ext'; break;
		case 'ez2':        $mimeType='application/vnd.ezpix-album'; break;
		case 'ez3':        $mimeType='application/vnd.ezpix-package'; break;
		case 'fcdt':       $mimeType='application/vnd.adobe.formscentral.fcdt'; break;
		case 'fcs':        $mimeType='application/vnd.isac.fcs'; break;
		case 'fdf':        $mimeType='application/vnd.fdf'; break;
		case 'fe_launch':  $mimeType='application/vnd.denovo.fcselayout-link'; break;
		case 'fg5':        $mimeType='application/vnd.fujitsu.oasysgp'; break;
		case 'fgd':        $mimeType='application/x-director'; break;
		case 'flo':        $mimeType='application/vnd.micrografx.flo'; break;
		case 'flw':        $mimeType='application/vnd.kde.kivio'; break;
		case 'fm':         $mimeType='application/vnd.framemaker'; break;
		case 'fnc':        $mimeType='application/vnd.frogans.fnc'; break;
		case 'frame':      $mimeType='application/vnd.framemaker'; break;
		case 'fsc':        $mimeType='application/vnd.fsc.weblaunch'; break;
		case 'ftc':        $mimeType='application/vnd.fluxtime.clip'; break;
		case 'fti':        $mimeType='application/vnd.anser-web-funds-transfer-initiation'; break;
		case 'fxp':        $mimeType='application/vnd.adobe.fxp'; break;
		case 'fxpl':       $mimeType='application/vnd.adobe.fxp'; break;
		case 'fzs':        $mimeType='application/vnd.fuzzysheet'; break;
		case 'g2w':        $mimeType='application/vnd.geoplan'; break;
		case 'g3w':        $mimeType='application/vnd.geospace'; break;
		case 'gac':        $mimeType='application/vnd.groove-account'; break;
		case 'gam':        $mimeType='application/x-tads'; break;
		case 'gbr':        $mimeType='application/rpki-ghostbusters'; break;
		case 'gca':        $mimeType='application/x-gca-compressed'; break;
		case 'geo':        $mimeType='application/vnd.dynageo'; break;
		case 'gex':        $mimeType='application/vnd.geometry-explorer'; break;
		case 'ggb':        $mimeType='application/vnd.geogebra.file'; break;
		case 'ggt':        $mimeType='application/vnd.geogebra.tool'; break;
		case 'ghf':        $mimeType='application/vnd.groove-help'; break;
		case 'gim':        $mimeType='application/vnd.groove-identity-message'; break;
		case 'gml':        $mimeType='application/gml+xml'; break;
		case 'gmx':        $mimeType='application/vnd.gmx'; break;
		case 'gnumeric':   $mimeType='application/x-gnumeric'; break;
		case 'gph':        $mimeType='application/vnd.flographit'; break;
		case 'gpx':        $mimeType='application/gpx+xml'; break;
		case 'gqf':        $mimeType='application/vnd.grafeq'; break;
		case 'gqs':        $mimeType='application/vnd.grafeq'; break;
		case 'gramps':     $mimeType='application/x-gramps-xml'; break;
		case 'gre':        $mimeType='application/vnd.geometry-explorer'; break;
		case 'grv':        $mimeType='application/vnd.groove-injector'; break;
		case 'gsf':        $mimeType='application/x-font-ghostscript'; break;
		case 'gtm':        $mimeType='application/vnd.groove-tool-message'; break;
		case 'gxf':        $mimeType='application/gxf'; break;
		case 'gxt':        $mimeType='application/vnd.geonext'; break;
		case 'hal':        $mimeType='application/vnd.hal+xml'; break;
		case 'hbci':       $mimeType='application/vnd.hbci'; break;
		case 'hpgl':       $mimeType='application/vnd.hp-hpgl'; break;
		case 'hpid':       $mimeType='application/vnd.hp-hpid'; break;
		case 'hps':        $mimeType='application/vnd.hp-hps'; break;
		case 'htke':       $mimeType='application/vnd.kenameaapp'; break;
		case 'hvd':        $mimeType='application/vnd.yamaha.hv-dic'; break;
		case 'hvp':        $mimeType='application/vnd.yamaha.hv-voice'; break;
		case 'hvs':        $mimeType='application/vnd.yamaha.hv-script'; break;
		case 'i2g':        $mimeType='application/vnd.intergeo'; break;
		case 'icc':        $mimeType='application/vnd.iccprofile'; break;
		case 'icm':        $mimeType='application/vnd.iccprofile'; break;
		case 'ifm':        $mimeType='application/vnd.shana.informed.formdata'; break;
		case 'igl':        $mimeType='application/vnd.igloader'; break;
		case 'igm':        $mimeType='application/vnd.insors.igm'; break;
		case 'igx':        $mimeType='application/vnd.micrografx.igx'; break;
		case 'iif':        $mimeType='application/vnd.shana.informed.interchange'; break;
		case 'imp':        $mimeType='application/vnd.accpac.simply.imp'; break;
		case 'ims':        $mimeType='application/vnd.ms-ims'; break;
		case 'ink':        $mimeType='application/inkml+xml'; break;
		case 'inkml':      $mimeType='application/inkml+xml'; break;
		case 'install':    $mimeType='application/x-install-instructions'; break;
		case 'iota':       $mimeType='application/vnd.astraea-software.iota'; break;
		case 'ipfix':      $mimeType='application/ipfix'; break;
		case 'ipk':        $mimeType='application/vnd.shana.informed.package'; break;
		case 'irm':        $mimeType='application/vnd.ibm.rights-management'; break;
		case 'irp':        $mimeType='application/vnd.irepository.package+xml'; break;
		case 'iso':        $mimeType='application/x-iso9660-image'; break;
		case 'itp':        $mimeType='application/vnd.shana.informed.formtemplate'; break;
		case 'ivp':        $mimeType='application/vnd.immervision-ivp'; break;
		case 'ivu':        $mimeType='application/vnd.immervision-ivu'; break;
		case 'jam':        $mimeType='application/vnd.jam'; break;
		case 'jar':        $mimeType='application/java-archive'; break;
		case 'jisp':       $mimeType='application/vnd.jisp'; break;
		case 'jlt':        $mimeType='application/vnd.hp-jlyt'; break;
		case 'jnlp':       $mimeType='application/x-java-jnlp-file'; break;
		case 'joda':       $mimeType='application/vnd.joost.joda-archive'; break;
		case 'jsonml':     $mimeType='application/jsonml+json'; break;
		case 'karbon':     $mimeType='application/vnd.kde.karbon'; break;
		case 'kfo':        $mimeType='application/vnd.kde.kformula'; break;
		case 'kia':        $mimeType='application/vnd.kidspiration'; break;
		case 'kml':        $mimeType='application/vnd.google-earth.kml+xml'; break;
		case 'kmz':        $mimeType='application/vnd.google-earth.kmz'; break;
		case 'kne':        $mimeType='application/vnd.kinar'; break;
		case 'knp':        $mimeType='application/vnd.kinar'; break;
		case 'kon':        $mimeType='application/vnd.kde.kontour'; break;
		case 'kpr':        $mimeType='application/vnd.kde.kpresenter'; break;
		case 'kpt':        $mimeType='application/vnd.kde.kpresenter'; break;
		case 'kpxx':       $mimeType='application/vnd.ds-keypoint'; break;
		case 'ksp':        $mimeType='application/vnd.kde.kspread'; break;
		case 'ktr':        $mimeType='application/vnd.kahootz'; break;
		case 'ktz':        $mimeType='application/vnd.kahootz'; break;
		case 'kwd':        $mimeType='application/vnd.kde.kword'; break;
		case 'kwt':        $mimeType='application/vnd.kde.kword'; break;
		case 'lasxml':     $mimeType='application/vnd.las.las+xml'; break;
		case 'lbd':        $mimeType='application/vnd.llamagraphics.life-balance.desktop'; break;
		case 'lbe':        $mimeType='application/vnd.llamagraphics.life-balance.exchange+xml'; break;
		case 'les':        $mimeType='application/vnd.hhe.lesson-player'; break;
		case 'lha':        $mimeType='application/x-lzh-compressed'; break;
		case 'link66':     $mimeType='application/vnd.route66.link66+xml'; break;
		case 'list3820':   $mimeType='application/vnd.ibm.modcap'; break;
		case 'listafp':    $mimeType='application/vnd.ibm.modcap'; break;
		case 'lnk':        $mimeType='application/x-ms-shortcut'; break;
		case 'lostxml':    $mimeType='application/lost+xml'; break;
		case 'lrf':        $mimeType='application/octet-stream'; break;
		case 'lrm':        $mimeType='application/vnd.ms-lrm'; break;
		case 'ltf':        $mimeType='application/vnd.frogans.ltf'; break;
		case 'lwp':        $mimeType='application/vnd.lotus-wordpro'; break;
		case 'lzh':        $mimeType='application/x-lzh-compressed'; break;
		case 'm21':        $mimeType='application/mp21'; break;
		case 'm3u8':       $mimeType='application/vnd.apple.mpegurl'; break;
		case 'ma':         $mimeType='application/mathematica'; break;
		case 'mads':       $mimeType='application/mads+xml'; break;
		case 'mag':        $mimeType='application/vnd.ecowin.chart'; break;
		case 'maker':      $mimeType='application/vnd.framemaker'; break;
		case 'mar':        $mimeType='application/octet-stream'; break;
		case 'mb':         $mimeType='application/mathematica'; break;
		case 'mbk':        $mimeType='application/vnd.mobius.mbk'; break;
		case 'mbox':       $mimeType='application/mbox'; break;
		case 'mc1':        $mimeType='application/vnd.medcalcdata'; break;
		case 'mcd':        $mimeType='application/vnd.mcd'; break;
		case 'meta4':      $mimeType='application/metalink4+xml'; break;
		case 'metalink':   $mimeType='application/metalink+xml'; break;
		case 'mets':       $mimeType='application/mets+xml'; break;
		case 'mfm':        $mimeType='application/vnd.mfmp'; break;
		case 'mft':        $mimeType='application/rpki-manifest'; break;
		case 'mgp':        $mimeType='application/vnd.osgeo.mapguide.package'; break;
		case 'mgz':        $mimeType='application/vnd.proteus.magazine'; break;
		case 'mie':        $mimeType='application/x-mie'; break;
		case 'mlp':        $mimeType='application/vnd.dolby.mlp'; break;
		case 'mmd':        $mimeType='application/vnd.chipnuts.karaoke-mmd'; break;
		case 'mmf':        $mimeType='application/vnd.smaf'; break;
		case 'mobi':       $mimeType='application/x-mobipocket-ebook'; break;
		case 'mods':       $mimeType='application/mods+xml'; break;
		case 'mp21':       $mimeType='application/mp21'; break;
		case 'mp4s':       $mimeType='application/mp4'; break;
		case 'mpc':        $mimeType='application/vnd.mophun.certificate'; break;
		case 'mpkg':       $mimeType='application/vnd.apple.installer+xml'; break;
		case 'mpm':        $mimeType='application/vnd.blueice.multipass'; break;
		case 'mpn':        $mimeType='application/vnd.mophun.application'; break;
		case 'mpt':        $mimeType='application/vnd.ms-project'; break;
		case 'mpy':        $mimeType='application/vnd.ibm.minipay'; break;
		case 'mqy':        $mimeType='application/vnd.mobius.mqy'; break;
		case 'mrc':        $mimeType='application/marc'; break;
		case 'mrcx':       $mimeType='application/marcxml+xml'; break;
		case 'mscml':      $mimeType='application/mediaservercontrol+xml'; break;
		case 'mseed':      $mimeType='application/vnd.fdsn.mseed'; break;
		case 'mseq':       $mimeType='application/vnd.mseq'; break;
		case 'msf':        $mimeType='application/vnd.epson.msf'; break;
		case 'msi':        $mimeType='application/x-msdownload'; break;
		case 'msl':        $mimeType='application/vnd.mobius.msl'; break;
		case 'msty':       $mimeType='application/vnd.muvee.style'; break;
		case 'mus':        $mimeType='application/vnd.musician'; break;
		case 'musicxml':   $mimeType='application/vnd.recordare.musicxml+xml'; break;
		case 'mwf':        $mimeType='application/vnd.mfer'; break;
		case 'mxf':        $mimeType='application/mxf'; break;
		case 'mxl':        $mimeType='application/vnd.recordare.musicxml'; break;
		case 'mxml':       $mimeType='application/xv+xml'; break;
		case 'mxs':        $mimeType='application/vnd.triscape.mxs'; break;
		case 'n-gage':     $mimeType='application/vnd.nokia.n-gage.symbian.install'; break;
		case 'nb':         $mimeType='application/mathematica'; break;
		case 'nbp':        $mimeType='application/vnd.wolfram.player'; break;
		case 'ncx':        $mimeType='application/x-dtbncx+xml'; break;
		case 'ngdat':      $mimeType='application/vnd.nokia.n-gage.data'; break;
		case 'nitf':       $mimeType='application/vnd.nitf'; break;
		case 'nlu':        $mimeType='application/vnd.neurolanguage.nlu'; break;
		case 'nml':        $mimeType='application/vnd.enliven'; break;
		case 'nnd':        $mimeType='application/vnd.noblenet-directory'; break;
		case 'nns':        $mimeType='application/vnd.noblenet-sealer'; break;
		case 'nnw':        $mimeType='application/vnd.noblenet-web'; break;
		case 'nsc':        $mimeType='application/x-conference'; break;
		case 'nsf':        $mimeType='application/vnd.lotus-notes'; break;
		case 'ntf':        $mimeType='application/vnd.nitf'; break;
		case 'nzb':        $mimeType='application/x-nzb'; break;
		case 'oa2':        $mimeType='application/vnd.fujitsu.oasys2'; break;
		case 'oa3':        $mimeType='application/vnd.fujitsu.oasys3'; break;
		case 'oas':        $mimeType='application/vnd.fujitsu.oasys'; break;
		case 'obd':        $mimeType='application/x-msbinder'; break;
		case 'obj':        $mimeType='application/x-tgif'; break;
		case 'odb':        $mimeType='application/vnd.oasis.opendocument.database'; break;
		case 'odc':        $mimeType='application/vnd.oasis.opendocument.chart'; break;
		case 'odf':        $mimeType='application/vnd.oasis.opendocument.formula'; break;
		case 'odft':       $mimeType='application/vnd.oasis.opendocument.formula-template'; break;
		case 'odg':        $mimeType='application/vnd.oasis.opendocument.graphics'; break;
		case 'odi':        $mimeType='application/vnd.oasis.opendocument.image'; break;
		case 'odm':        $mimeType='application/vnd.oasis.opendocument.text-master'; break;
		case 'odp':        $mimeType='application/vnd.oasis.opendocument.presentation'; break;
		case 'ods':        $mimeType='application/vnd.oasis.opendocument.spreadsheet'; break;
		case 'odt':        $mimeType='application/vnd.oasis.opendocument.text'; break;
		case 'ogx':        $mimeType='application/ogg'; break;
		case 'omdoc':      $mimeType='application/omdoc+xml'; break;
		case 'onepkg':     $mimeType='application/onenote'; break;
		case 'onetmp':     $mimeType='application/onenote'; break;
		case 'onetoc':     $mimeType='application/onenote'; break;
		case 'onetoc2':    $mimeType='application/onenote'; break;
		case 'opf':        $mimeType='application/oebps-package+xml'; break;
		case 'oprc':       $mimeType='application/vnd.palm'; break;
		case 'org':        $mimeType='application/vnd.lotus-organizer'; break;
		case 'osf':        $mimeType='application/vnd.yamaha.openscoreformat'; break;
		case 'osfpvg':     $mimeType='application/vnd.yamaha.openscoreformat.osfpvg+xml'; break;
		case 'otc':        $mimeType='application/vnd.oasis.opendocument.chart-template'; break;
		case 'otg':        $mimeType='application/vnd.oasis.opendocument.graphics-template'; break;
		case 'oth':        $mimeType='application/vnd.oasis.opendocument.text-web'; break;
		case 'oti':        $mimeType='application/vnd.oasis.opendocument.image-template'; break;
		case 'otp':        $mimeType='application/vnd.oasis.opendocument.presentation-template'; break;
		case 'ots':        $mimeType='application/vnd.oasis.opendocument.spreadsheet-template'; break;
		case 'ott':        $mimeType='application/vnd.oasis.opendocument.text-template'; break;
		case 'oxps':       $mimeType='application/oxps'; break;
		case 'oxt':        $mimeType='application/vnd.openofficeorg.extension'; break;
		case 'p8':         $mimeType='application/pkcs8'; break;
		case 'paw':        $mimeType='application/vnd.pawaafile'; break;
		case 'pbd':        $mimeType='application/vnd.powerbuilder6'; break;
		case 'pcap':       $mimeType='application/vnd.tcpdump.pcap'; break;
		case 'pcf':        $mimeType='application/x-font-pcf'; break;
		case 'pcl':        $mimeType='application/vnd.hp-pcl'; break;
		case 'pclxl':      $mimeType='application/vnd.hp-pclxl'; break;
		case 'pcurl':      $mimeType='application/vnd.curl.pcurl'; break;
		case 'pfa':        $mimeType='application/x-font-type1'; break;
		case 'pfb':        $mimeType='application/x-font-type1'; break;
		case 'pfm':        $mimeType='application/x-font-type1'; break;
		case 'pfr':        $mimeType='application/font-tdpfr'; break;
		case 'pgp':        $mimeType='application/pgp-encrypted'; break;
		case 'pkg':        $mimeType='application/octet-stream'; break;
		case 'pki':        $mimeType='application/pkixcmp'; break;
		case 'pkipath':    $mimeType='application/pkix-pkipath'; break;
		case 'plb':        $mimeType='application/vnd.3gpp.pic-bw-large'; break;
		case 'plc':        $mimeType='application/vnd.mobius.plc'; break;
		case 'plf':        $mimeType='application/vnd.pocketlearn'; break;
		case 'pls':        $mimeType='application/pls+xml'; break;
		case 'portpkg':    $mimeType='application/vnd.macports.portpkg'; break;
		case 'potm':       $mimeType='application/vnd.ms-powerpoint.template.macroenabled.12'; break;
		case 'potx':       $mimeType='application/vnd.openxmlformats-officedocument.presentationml.template'; break;
		case 'ppam':       $mimeType='application/vnd.ms-powerpoint.addin.macroenabled.12'; break;
		case 'ppd':        $mimeType='application/vnd.cups-ppd'; break;
		case 'ppsm':       $mimeType='application/vnd.ms-powerpoint.slideshow.macroenabled.12'; break;
		case 'ppsx':       $mimeType='application/vnd.openxmlformats-officedocument.presentationml.slideshow'; break;
		case 'pptm':       $mimeType='application/vnd.ms-powerpoint.presentation.macroenabled.12'; break;
		case 'pqa':        $mimeType='application/vnd.palm'; break;
		case 'prc':        $mimeType='application/x-mobipocket-ebook'; break;
		case 'pre':        $mimeType='application/vnd.lotus-freelance'; break;
		case 'psb':        $mimeType='application/vnd.3gpp.pic-bw-small'; break;
		case 'psf':        $mimeType='application/x-font-linux-psf'; break;
		case 'pskcxml':    $mimeType='application/pskc+xml'; break;
		case 'ptid':       $mimeType='application/vnd.pvi.ptid1'; break;
		case 'pvb':        $mimeType='application/vnd.3gpp.pic-bw-var'; break;
		case 'pwn':        $mimeType='application/vnd.3m.post-it-notes'; break;
		case 'qam':        $mimeType='application/vnd.epson.quickanime'; break;
		case 'qbo':        $mimeType='application/vnd.intu.qbo'; break;
		case 'qfx':        $mimeType='application/vnd.intu.qfx'; break;
		case 'qps':        $mimeType='application/vnd.publishare-delta-tree'; break;
		case 'qwd':        $mimeType='application/vnd.quark.quarkxpress'; break;
		case 'qwt':        $mimeType='application/vnd.quark.quarkxpress'; break;
		case 'qxb':        $mimeType='application/vnd.quark.quarkxpress'; break;
		case 'qxd':        $mimeType='application/vnd.quark.quarkxpress'; break;
		case 'qxl':        $mimeType='application/vnd.quark.quarkxpress'; break;
		case 'qxt':        $mimeType='application/vnd.quark.quarkxpress'; break;
		case 'rar':        $mimeType='application/x-rar-compressed'; break;
		case 'rcprofile':  $mimeType='application/vnd.ipunplugged.rcprofile'; break;
		case 'rdz':        $mimeType='application/vnd.data-vision.rdz'; break;
		case 'rep':        $mimeType='application/vnd.businessobjects'; break;
		case 'res':        $mimeType='application/x-dtbresource+xml'; break;
		case 'rif':        $mimeType='application/reginfo+xml'; break;
		case 'ris':        $mimeType='application/x-research-info-systems'; break;
		case 'rl':         $mimeType='application/resource-lists+xml'; break;
		case 'rld':        $mimeType='application/resource-lists-diff+xml'; break;
		case 'rms':        $mimeType='application/vnd.jcp.javame.midlet-rms'; break;
		case 'rmvb':       $mimeType='application/vnd.rn-realmedia-vbr'; break;
		case 'rnc':        $mimeType='application/relax-ng-compact-syntax'; break;
		case 'roa':        $mimeType='application/rpki-roa'; break;
		case 'rp9':        $mimeType='application/vnd.cloanto.rp9'; break;
		case 'rpss':       $mimeType='application/vnd.nokia.radio-presets'; break;
		case 'rpst':       $mimeType='application/vnd.nokia.radio-preset'; break;
		case 'rq':         $mimeType='application/sparql-query'; break;
		case 'rs':         $mimeType='application/rls-services+xml'; break;
		case 'rsd':        $mimeType='application/rsd+xml'; break;
		case 'saf':        $mimeType='application/vnd.yamaha.smaf-audio'; break;
		case 'sbml':       $mimeType='application/sbml+xml'; break;
		case 'sc':         $mimeType='application/vnd.ibm.secure-container'; break;
		case 'scm':        $mimeType='application/vnd.lotus-screencam'; break;
		case 'scq':        $mimeType='application/scvp-cv-request'; break;
		case 'scs':        $mimeType='application/scvp-cv-response'; break;
		case 'sda':        $mimeType='application/vnd.stardivision.draw'; break;
		case 'sdc':        $mimeType='application/vnd.stardivision.calc'; break;
		case 'sdd':        $mimeType='application/vnd.stardivision.impress'; break;
		case 'sdkd':       $mimeType='application/vnd.solent.sdkm+xml'; break;
		case 'sdkm':       $mimeType='application/vnd.solent.sdkm+xml'; break;
		case 'sdp':        $mimeType='application/sdp'; break;
		case 'sdw':        $mimeType='application/vnd.stardivision.writer'; break;
		case 'see':        $mimeType='application/vnd.seemail'; break;
		case 'seed':       $mimeType='application/vnd.fdsn.seed'; break;
		case 'sema':       $mimeType='application/vnd.sema'; break;
		case 'semd':       $mimeType='application/vnd.semd'; break;
		case 'semf':       $mimeType='application/vnd.semf'; break;
		case 'ser':        $mimeType='application/java-serialized-object'; break;
		case 'sfd-hdstx':  $mimeType='application/vnd.hydrostatix.sof-data'; break;
		case 'sfs':        $mimeType='application/vnd.spotfire.sfs'; break;
		case 'sgl':        $mimeType='application/vnd.stardivision.writer-global'; break;
		case 'shf':        $mimeType='application/shf+xml'; break;
		case 'sig':        $mimeType='application/pgp-signature'; break;
		case 'sis':        $mimeType='application/vnd.symbian.install'; break;
		case 'sisx':       $mimeType='application/vnd.symbian.install'; break;
		case 'sitx':       $mimeType='application/x-stuffitx'; break;
		case 'sldm':       $mimeType='application/vnd.ms-powerpoint.slide.macroenabled.12'; break;
		case 'sldx':       $mimeType='application/vnd.openxmlformats-officedocument.presentationml.slide'; break;
		case 'slt':        $mimeType='application/vnd.epson.salt'; break;
		case 'sm':         $mimeType='application/vnd.stepmania.stepchart'; break;
		case 'smf':        $mimeType='application/vnd.stardivision.math'; break;
		case 'smzip':      $mimeType='application/vnd.stepmania.package'; break;
		case 'snf':        $mimeType='application/x-font-snf'; break;
		case 'so':         $mimeType='application/octet-stream'; break;
		case 'spf':        $mimeType='application/vnd.yamaha.smaf-phrase'; break;
		case 'spp':        $mimeType='application/scvp-vp-response'; break;
		case 'spq':        $mimeType='application/scvp-vp-request'; break;
		case 'sql':        $mimeType='application/x-sql'; break;
		case 'srt':        $mimeType='application/x-subrip'; break;
		case 'sru':        $mimeType='application/sru+xml'; break;
		case 'srx':        $mimeType='application/sparql-results+xml'; break;
		case 'ssdl':       $mimeType='application/ssdl+xml'; break;
		case 'sse':        $mimeType='application/vnd.kodak-descriptor'; break;
		case 'ssf':        $mimeType='application/vnd.epson.ssf'; break;
		case 'ssml':       $mimeType='application/ssml+xml'; break;
		case 'st':         $mimeType='application/vnd.sailingtracker.track'; break;
		case 'stc':        $mimeType='application/vnd.sun.xml.calc.template'; break;
		case 'std':        $mimeType='application/vnd.sun.xml.draw.template'; break;
		case 'stf':        $mimeType='application/vnd.wt.stf'; break;
		case 'sti':        $mimeType='application/vnd.sun.xml.impress.template'; break;
		case 'stk':        $mimeType='application/hyperstudio'; break;
		case 'str':        $mimeType='application/vnd.pg.format'; break;
		case 'stw':        $mimeType='application/vnd.sun.xml.writer.template'; break;
		case 'sus':        $mimeType='application/vnd.sus-calendar'; break;
		case 'susp':       $mimeType='application/vnd.sus-calendar'; break;
		case 'svc':        $mimeType='application/vnd.dvb.service'; break;
		case 'svd':        $mimeType='application/vnd.svd'; break;
		case 'swa':        $mimeType='application/x-director'; break;
		case 'swi':        $mimeType='application/vnd.aristanetworks.swi'; break;
		case 'sxc':        $mimeType='application/vnd.sun.xml.calc'; break;
		case 'sxd':        $mimeType='application/vnd.sun.xml.draw'; break;
		case 'sxg':        $mimeType='application/vnd.sun.xml.writer.global'; break;
		case 'sxi':        $mimeType='application/vnd.sun.xml.impress'; break;
		case 'sxm':        $mimeType='application/vnd.sun.xml.math'; break;
		case 'sxw':        $mimeType='application/vnd.sun.xml.writer'; break;
		case 't3':         $mimeType='application/x-t3vm-image'; break;
		case 'taglet':     $mimeType='application/vnd.mynfc'; break;
		case 'tao':        $mimeType='application/vnd.tao.intent-module-archive'; break;
		case 'tcap':       $mimeType='application/vnd.3gpp2.tcap'; break;
		case 'teacher':    $mimeType='application/vnd.smart.teacher'; break;
		case 'tei':        $mimeType='application/tei+xml'; break;
		case 'teicorpus':  $mimeType='application/tei+xml'; break;
		case 'tfi':        $mimeType='application/thraud+xml'; break;
		case 'tfm':        $mimeType='application/x-tex-tfm'; break;
		case 'thmx':       $mimeType='application/vnd.ms-officetheme'; break;
		case 'tmo':        $mimeType='application/vnd.tmobile-livetv'; break;
		case 'torrent':    $mimeType='application/x-bittorrent'; break;
		case 'tpl':        $mimeType='application/vnd.groove-tool-template'; break;
		case 'tpt':        $mimeType='application/vnd.trid.tpt'; break;
		case 'tra':        $mimeType='application/vnd.trueapp'; break;
		case 'tsd':        $mimeType='application/timestamped-data'; break;
		case 'twd':        $mimeType='application/vnd.simtech-mindmapper'; break;
		case 'twds':       $mimeType='application/vnd.simtech-mindmapper'; break;
		case 'txd':        $mimeType='application/vnd.genomatix.tuxedo'; break;
		case 'txf':        $mimeType='application/vnd.mobius.txf'; break;
		case 'u32':        $mimeType='application/x-authorware-bin'; break;
		case 'udeb':       $mimeType='application/x-debian-package'; break;
		case 'ufd':        $mimeType='application/vnd.ufdl'; break;
		case 'ufdl':       $mimeType='application/vnd.ufdl'; break;
		case 'ulx':        $mimeType='application/x-glulx'; break;
		case 'umj':        $mimeType='application/vnd.umajin'; break;
		case 'unityweb':   $mimeType='application/vnd.unity'; break;
		case 'uoml':       $mimeType='application/vnd.uoml+xml'; break;
		case 'utz':        $mimeType='application/vnd.uiq.theme'; break;
		case 'uvd':        $mimeType='application/vnd.dece.data'; break;
		case 'uvf':        $mimeType='application/vnd.dece.data'; break;
		case 'uvt':        $mimeType='application/vnd.dece.ttml+xml'; break;
		case 'uvvd':       $mimeType='application/vnd.dece.data'; break;
		case 'uvvf':       $mimeType='application/vnd.dece.data'; break;
		case 'uvvt':       $mimeType='application/vnd.dece.ttml+xml'; break;
		case 'uvvx':       $mimeType='application/vnd.dece.unspecified'; break;
		case 'uvvz':       $mimeType='application/vnd.dece.zip'; break;
		case 'uvx':        $mimeType='application/vnd.dece.unspecified'; break;
		case 'uvz':        $mimeType='application/vnd.dece.zip'; break;
		case 'vcg':        $mimeType='application/vnd.groove-vcard'; break;
		case 'vcx':        $mimeType='application/vnd.vcx'; break;
		case 'vis':        $mimeType='application/vnd.visionary'; break;
		case 'vor':        $mimeType='application/vnd.stardivision.writer'; break;
		case 'vox':        $mimeType='application/x-authorware-bin'; break;
		case 'vsd':        $mimeType='application/vnd.visio'; break;
		case 'vsf':        $mimeType='application/vnd.vsf'; break;
		case 'vss':        $mimeType='application/vnd.visio'; break;
		case 'vst':        $mimeType='application/vnd.visio'; break;
		case 'vsw':        $mimeType='application/vnd.visio'; break;
		case 'w3d':        $mimeType='application/x-director'; break;
		case 'wad':        $mimeType='application/x-doom'; break;
		case 'wbs':        $mimeType='application/vnd.criticaltools.wbs+xml'; break;
		case 'wg':         $mimeType='application/vnd.pmi.widget'; break;
		case 'wgt':        $mimeType='application/widget'; break;
		case 'wmd':        $mimeType='application/x-ms-wmd'; break;
		case 'wmz':        $mimeType='application/x-ms-wmz'; break;
		case 'wmz':        $mimeType='application/x-msmetafile'; break;
		case 'wpd':        $mimeType='application/vnd.wordperfect'; break;
		case 'wpl':        $mimeType='application/vnd.ms-wpl'; break;
		case 'wqd':        $mimeType='application/vnd.wqd'; break;
		case 'wsdl':       $mimeType='application/wsdl+xml'; break;
		case 'wspolicy':   $mimeType='application/wspolicy+xml'; break;
		case 'wtb':        $mimeType='application/vnd.webturbo'; break;
		case 'x32':        $mimeType='application/x-authorware-bin'; break;
		case 'xaml':       $mimeType='application/xaml+xml'; break;
		case 'xap':        $mimeType='application/x-silverlight-app'; break;
		case 'xar':        $mimeType='application/vnd.xara'; break;
		case 'xbap':       $mimeType='application/x-ms-xbap'; break;
		case 'xbd':        $mimeType='application/vnd.fujixerox.docuworks.binder'; break;
		case 'xdf':        $mimeType='application/xcap-diff+xml'; break;
		case 'xdm':        $mimeType='application/vnd.syncml.dm+xml'; break;
		case 'xdp':        $mimeType='application/vnd.adobe.xdp+xml'; break;
		case 'xdssc':      $mimeType='application/dssc+xml'; break;
		case 'xdw':        $mimeType='application/vnd.fujixerox.docuworks'; break;
		case 'xenc':       $mimeType='application/xenc+xml'; break;
		case 'xer':        $mimeType='application/patch-ops-error+xml'; break;
		case 'xfdf':       $mimeType='application/vnd.adobe.xfdf'; break;
		case 'xfdl':       $mimeType='application/vnd.xfdl'; break;
		case 'xhvml':      $mimeType='application/xv+xml'; break;
		case 'xlam':       $mimeType='application/vnd.ms-excel.addin.macroenabled.12'; break;
		case 'xlf':        $mimeType='application/x-xliff+xml'; break;
		case 'xlsb':       $mimeType='application/vnd.ms-excel.sheet.binary.macroenabled.12'; break;
		case 'xlsm':       $mimeType='application/vnd.ms-excel.sheet.macroenabled.12'; break;
		case 'xltm':       $mimeType='application/vnd.ms-excel.template.macroenabled.12'; break;
		case 'xltx':       $mimeType='application/vnd.openxmlformats-officedocument.spreadsheetml.template'; break;
		case 'xo':         $mimeType='application/vnd.olpc-sugar'; break;
		case 'xop':        $mimeType='application/xop+xml'; break;
		case 'xpl':        $mimeType='application/xproc+xml'; break;
		case 'xpr':        $mimeType='application/vnd.is-xpr'; break;
		case 'xps':        $mimeType='application/vnd.ms-xpsdocument'; break;
		case 'xpw':        $mimeType='application/vnd.intercon.formnet'; break;
		case 'xpx':        $mimeType='application/vnd.intercon.formnet'; break;
		case 'xsm':        $mimeType='application/vnd.syncml+xml'; break;
		case 'xspf':       $mimeType='application/xspf+xml'; break;
		case 'xvm':        $mimeType='application/xv+xml'; break;
		case 'xvml':       $mimeType='application/xv+xml'; break;
		case 'xz':         $mimeType='application/x-xz'; break;
		case 'yang':       $mimeType='application/yang'; break;
		case 'yin':        $mimeType='application/yin+xml'; break;
		case 'z1':         $mimeType='application/x-zmachine'; break;
		case 'z2':         $mimeType='application/x-zmachine'; break;
		case 'z3':         $mimeType='application/x-zmachine'; break;
		case 'z4':         $mimeType='application/x-zmachine'; break;
		case 'z5':         $mimeType='application/x-zmachine'; break;
		case 'z6':         $mimeType='application/x-zmachine'; break;
		case 'z7':         $mimeType='application/x-zmachine'; break;
		case 'z8':         $mimeType='application/x-zmachine'; break;
		case 'zaz':        $mimeType='application/vnd.zzazz.deck+xml'; break;
		case 'zir':        $mimeType='application/vnd.zul'; break;
		case 'zirz':       $mimeType='application/vnd.zul'; break;
		case 'zmm':        $mimeType='application/vnd.handheld-entertainment+xml'; break;

		//others
		case 'xyz':        $mimeType='chemical/x-xyz'; break;
		case 'pdb':        $mimeType='chemical/x-pdb'; break;
		case 'otf':        $mimeType='font/opentype'; break;
		case 'mhtml':
		case 'nws':
		case 'mht':        $mimeType='message/rfc822'; break;
		case 'wrl':
		case 'xof':
		case 'flr':
		case 'xaf':
		case 'wrz':
		case 'vrml':       $mimeType='x-world/x-vrml'; break;
		case 'mesh':
		case 'msh':
		case 'silo':       $mimeType='x-world/mesh'; break;
		case 'iges':
		case 'igs':        $mimeType='x-world/iges'; break;
		case 'ice':        $mimeType='x-conference/x-cooltalk'; break;
	/////////////////////
		case 'cdx':        $mimeType='chemical/x-cdx'; break;
		case 'cif':        $mimeType='chemical/x-cif'; break;
		case 'cmdf':       $mimeType='chemical/x-cmdf'; break;
		case 'cml':        $mimeType='chemical/x-cml'; break;
		case 'csml':       $mimeType='chemical/x-csml'; break;
		case 'dae':        $mimeType='model/vnd.collada+xml'; break;
		case 'dwf':        $mimeType='model/vnd.dwf'; break;
		case 'gdl':        $mimeType='model/vnd.gdl'; break;
		case 'gtw':        $mimeType='model/vnd.gtw'; break;
		case 'mts':        $mimeType='model/vnd.mts'; break;
		case 'vtu':        $mimeType='model/vnd.vtu'; break;
		case 'eml':        $mimeType='message/rfc822'; break;
		case 'mime':       $mimeType='message/rfc822'; break;
		case 'x3db':       $mimeType='model/x3d+binary'; break;
		case 'x3dbz':      $mimeType='model/x3d+binary'; break;
		case 'x3dv':       $mimeType='model/x3d+vrml'; break;
		case 'x3dvz':      $mimeType='model/x3d+vrml'; break;
		case 'x3dz':       $mimeType='model/x3d+xml'; break;
		case 'x3d':        $mimeType='model/x3d+xml'; break;

		default:           $mimeType=null;
	}
	// End of Mime Type
	
	return $mimeType;
	
}

/*
function fullUpper($str){
	// convert to entities
	$subject=htmlentities($str,ENT_QUOTES);
	$pattern='/&([a-z])(uml|acute|circ|tilde|ring|elig|grave|slash|horn|cedil|th);/e';
	$replace="'&'.strtoupper('\\1').'\\2'.';'";
	$result=preg_replace($pattern, $replace, $subject);
	// convert from entities back to characters
	$htmltable = get_html_translation_table(HTML_ENTITIES);
	foreach($htmltable as $key => $value) {
		$result=preg_replace('#'.$value.'#',$key,$result);
	}
	return(strtoupper($result));
}

function isValidEmail($email, $checkDNS = true) {
	$valid=(function_exists('filter_var')&&filter_var($email,FILTER_VALIDATE_EMAIL))||(strlen($email)<=320&&preg_match_all('/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?))'.'{255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?))'.'{65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|'.'(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))'.'(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|'.'(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|'.'(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})'.'(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126})'.'{1,}'.'(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|'.'(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|'.'(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::'.'(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|'.'(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|'.'(?:(?!(?:.*[a-f0-9]:){5,})'.'(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::'.'(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|'.'(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|'.'(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD',$email));
	if($valid){
		if($checkDNS&&(@$domain=end(explode('@',$email,2)))){
			return checkdnsrr($domain.'.','MX');
		}
		return true;
	}
	return false;
}

function isValidUrl($url){
	return filter_var_url($url);
}




define('FILTER_FLAG_DEFAULT_REQUIRED', 196608); // = 0x30000 ( == FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED)
if(!defined('FILTER_FLAG_SCHEME_REQUIRED'))
	define('FILTER_FLAG_SCHEME_REQUIRED', 65536); // = 0x10000
if(!defined('FILTER_FLAG_HOST_REQUIRED'))
	define('FILTER_FLAG_HOST_REQUIRED', 131072); // = 0x20000
if(!defined('FILTER_FLAG_PATH_REQUIRED'))
	define('FILTER_FLAG_PATH_REQUIRED', 262144); // = 0x40000
if(!defined('FILTER_FLAG_QUERY_REQUIRED'))
	define('FILTER_FLAG_QUERY_REQUIRED', 524288); // = 0x80000

// Émulation de la fnct filter_var($url,FILTER_VALIDATE_URL) + vérif que l'host exite
function filter_var_url($url, $checkDNS=true, $flags=FILTER_FLAG_DEFAULT_REQUIRED) {
	if(function_exists('filter_var')){
		return filter_var($url,FILTER_VALIDATE_URL);
	}

	$urlParsed = parse_url($url);

	if ($urlParsed == NULL) {
		return false;
	}

	if (
		(($flags & FILTER_FLAG_SCHEME_REQUIRED) && $urlParsed['scheme'] == NULL) ||
		(($flags & FILTER_FLAG_HOST_REQUIRED) && $urlParsed['host'] == NULL) ||
		(($flags & FILTER_FLAG_PATH_REQUIRED ) && $urlParsed['path'] == NULL) ||
		(($flags & FILTER_FLAG_QUERY_REQUIRED) && $urlParsed['query'] == NULL)
	){
		return false;
	}

	if($checkDNS&&($flags&FILTER_FLAG_HOST_REQUIRED)){
		return checkdnsrr($urlParsed['host']);
	}
	return true;
}

*/


// http_redirect polyfill
// written by Ajabep
// inspired by the C source-codes

if(!defined('HTTP_REDIRECT'))
	define('HTTP_REDIRECT', 0);

if(!defined('HTTP_REDIRECT_PERM'))
	define('HTTP_REDIRECT_PERM', 301);

if(!defined('HTTP_REDIRECT_FOUND'))
	define('HTTP_REDIRECT_FOUND', 302);

if(!defined('HTTP_REDIRECT_POST'))
	define('HTTP_REDIRECT_POST', 303);

if(!defined('HTTP_REDIRECT_PROXY'))
	define('HTTP_REDIRECT_PROXY', 305);

if(!defined('HTTP_REDIRECT_TEMP'))
	define('HTTP_REDIRECT_TEMP', 307);

if(!function_exists('http_redirect')){
	
	// Polyfill inspired by the C source-codes.
	
	
	// To a good polyfill (use it if you have a http_build_url polyfill) :
	// function http_redirect( $url = null, array $params = array(), session = false, int status = 302 ) {
		// if( empty($url) ) {
			// $url = http_build_url();
		// }
		// if( empty($params) ) {
			// $params = http_build_str();
		// }
		// rest of the code
	
	function http_redirect( $url, array $params = array(), $session = false, $status = HTTP_REDIRECT ) {
		
		if( $session && session_status() != PHP_SESSION_ACTIVE ) {
			$params[session_name()] = session_id();
		}
		
		if( sizeof($params) ) {
			$query = http_build_query($params);
		}
		
		$redirUri = $url.( (empty($query))? '' : '?'.$query);
		
		switch($status) {
			default:
				trigger_error('Unsupported redirection status code: '.$status, E_USER_NOTICE);
				$status = HTTP_REDIRECT;
			
			case HTTP_REDIRECT:
				if( $_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'HEAD' )
					$status = 302;
				else
					$status = 303;
			
			
			case 300:
			case 301:
			case 302:
			case 303:
			case 305:
			case 307:
				http_send_status($status);
		}
		
		header('Location: ' . $redirUri);
		exit('Redirecting to <a href="' . redirUri . '">' . redirUri . '</a>.'."\n");
	}

}



// http_send_status polyfill
// written by Ajabep
// inspired by the C source-codes

if( !function_exists('http_send_status') ) {
	
	// Polyfill inspired by the C source-codes.
	
	function http_send_status( $status ) {
		
		if( !is_numeric($status) || $status < 100 || $status > 510 ) {
				trigger_error('Invalid HTTP status code (100-510): '.$status, E_USER_WARNING);
		}
		
		$status = (int) $status;
		
		switch($status) { // made with the french wikipedia list of http status
			default:
				trigger_error('Unsupported redirection status code: '.$status, E_USER_NOTICE);
			return;
		
			case 100:
			$message = 'Continue';
			break;
		
			case 101:
			$message = 'Switching Protocols';
			break;
		
			case 102:
			$message = 'Processing';
			break;
		
			case 118:
			$message = 'Connection timed out';
			break;
		
			case 200:
			$message = 'OK';
			break;
		
			case 201:
			$message = 'Created';
			break;
		
			case 202:
			$message = 'Accepted';
			break;
		
			case 203:
			$message = 'Non-Authoritative Information';
			break;
		
			case 204:
			$message = 'No Content';
			break;
		
			case 205:
			$message = 'Reset Content';
			break;
		
			case 206:
			$message = 'Partial Content';
			break;
		
			case 207:
			$message = 'Multi-Status';
			break;
		
			case 210:
			$message = 'Content Different';
			break;
		
			case 226:
			$message = 'IM Used';
			break;
		
			case 300:
			$message = 'Multiple Choices';
			break;
		
			case 301:
			$message = 'Moved Permanently';
			break;
		
			case 302:
			$message = 'Moved Temporarily';
			break;
		
			case 303:
			$message = 'See Other';
			break;
		
			case 304:
			$message = 'Not Modified';
			break;
		
			case 305:
			$message = 'Use Proxy';
			break;
		
			case 307:
			$message = 'Temporary Redirect';
			break;
		
			case 308:
			$message = 'Permanent Redirect';
			break;
		
			case 310:
			$message = 'Too many Redirects';
			break;
		
			case 400:
			$message = 'Bad Request';
			break;
		
			case 401:
			$message = 'Unauthorized';
			break;
		
			case 402:
			$message = 'Payment Required';
			break;
		
			case 403:
			$message = 'Forbidden';
			break;
		
			case 404:
			$message = 'Not Found';
			break;
		
			case 405:
			$message = 'Method Not Allowed';
			break;
		
			case 406:
			$message = 'Not Acceptable';
			break;
		
			case 407:
			$message = 'Proxy Authentication Required';
			break;
		
			case 408:
			$message = 'Request Time-out';
			break;
		
			case 409:
			$message = 'Conflict';
			break;
		
			case 410:
			$message = 'Gone';
			break;
		
			case 411:
			$message = 'Length Required';
			break;
		
			case 412:
			$message = 'Precondition Failed';
			break;
		
			case 413:
			$message = 'Request Entity Too Large';
			break;
		
			case 414:
			$message = 'Request-URI Too Long';
			break;
		
			case 415:
			$message = 'Unsupported Media Type';
			break;
		
			case 416:
			$message = 'Requested range unsatisfiable';
			break;
		
			case 417:
			$message = 'Expectation failed';
			break;
		
			case 418:
			$message = 'I’m a teapot';
			break;
		
			case 422:
			$message = 'Unprocessable entity';
			break;
		
			case 423:
			$message = 'Locked';
			break;
		
			case 424:
			$message = 'Method failure';
			break;
		
			case 425:
			$message = 'Unordered Collection';
			break;
		
			case 426:
			$message = 'Upgrade Required';
			break;
		
			case 428:
			$message = 'Precondition Required';
			break;
		
			case 429:
			$message = 'Too Many Requests';
			break;
		
			case 431:
			$message = 'Request Header Fields Too Large';
			break;
		
			case 449:
			$message = 'Retry With';
			break;
		
			case 456:
			$message = 'Unrecoverable Error';
			break;
		
			case 499:
			$message = 'client has closed connection';
			break;
		
			case 500:
			$message = 'Internal Server Error';
			break;
		
			case 501:
			$message = 'Not Implemented';
			break;
		
			case 502:
			$message = 'Bad Gateway ou Proxy Error';
			break;
		
			case 503:
			$message = 'Service Unavailable';
			break;
		
			case 504:
			$message = 'Gateway Time-out';
			break;
		
			case 505:
			$message = 'HTTP Version not supported';
			break;
		
			case 506:
			$message = 'Variant also negociate';
			break;
		
			case 507:
			$message = 'Insufficient storage';
			break;
		
			case 508:
			$message = 'Loop detected';
			break;
		
			case 509:
			$message = 'Bandwidth Limit Exceeded';
			break;
		
			case 510:
			$message = 'Not extended';
			break;
		
		}
		
		header($_SERVER['SERVER_PROTOCOL'].' '.$status.' '.$message, true, $status);
	}

}


/*
function isValidDomain($url){
	return filter_var_url($url, FILTER_FLAG_HOST_REQUIRED);
}

function ucname($string){
	$string=ucwords(strtolower($string));
	foreach(array('-','\'') as $delimiter){
		if(strpos($string,$delimiter)!==false){
			$string=implode($delimiter, array_map('ucfirst',explode($delimiter,$string)));
		}
	}
	return $string;
}
*/

function stopWords( $string ) { // delete the french stop-words, the words which rae not SEO
	$stopWords = array('alors', 'au', 'aucuns', 'aussi', 'autre', 'avant', 'avec', 'avoir', 'bon', 'car', 'ce', 'cela', 'ces', 'ceux', 'chaque', 'ci', 'comme', 'comment', 'dans', 'des', 'du', 'dedans', 'dehors', 'depuis', 'deux', 'devrait', 'doit', 'donc', 'dos', 'droite', 'début', 'elle', 'elles', 'en', 'encore', 'essai', 'est', 'et', 'eu', 'fait', 'faites', 'fois', 'font', 'force', 'haut', 'hors', 'ici', 'il', 'ils', 'je', 'juste', 'la', 'le', 'les', 'leur', 'là', 'ma', 'maintenant', 'mais', 'mes', 'mine', 'moins', 'mon', 'mot', 'même', 'ni', 'nommés', 'notre', 'nous', 'nouveaux', 'ou', 'où', 'par', 'parce', 'parole', 'pas', 'personnes', 'peut', 'peu', 'pièce', 'plupart', 'pour', 'pourquoi', 'quand', 'que', 'quel', 'quelle', 'quelles', 'quels', 'qui', 'sa', 'sans', 'ses', 'seulement', 'si', 'sien', 'son', 'sont', 'sous', 'soyez', 'sujet', 'sur', 'ta', 'tandis', 'tellement', 'tels', 'tes', 'ton', 'tous', 'tout', 'trop', 'très', 'tu', 'valeur', 'voie', 'voient', 'vont', 'votre', 'vous', 'vu', 'ça', 'étaient', 'état', 'étions', 'été', 'être');
	
	foreach($stopWords as $stopWord) {
		$string = preg_replace('#^'.$stopWord.'-#Ui', '', $string);
		$string = preg_replace('#-'.$stopWord.'-#Ui', '-', $string);
		$string = preg_replace('#-'.$stopWord.'$#Ui', '', $string);
	}
	return $string;
}

/**
* TravelloLib
* 
* @package TravelloLib
* @author Ralf Eggert <r.eggert@travello.de>
* @copyright Copyright (c) 2012 Travello GmbH
*/
function stringToUrl($string){
	$search = array(
					'= |\(|\)|\/|\,|\'|´|`|\@|\||&=', // convert blank and special chars to "-"
					'=á|à|â|ã|ą|ă|ā|Â|Á|À|Ã|Ą|Ă|Ā=i',
					'=å|Å=i',
					'=ä|æ|Ä|Æ=i',
					'=ç|ć|č|ċ|ĉ|Ç|Ć|Č|Ċ|Ĉ=i',
					'=ď|Ď=i',
					'=ð|Ð=i',
					'=é|è|ê|ë|ę|ě|ē|ė|Ê|É|È|Ë|Ę|Ě|Ē|Ė=i',
					'=ğ|ġ|ĝ|ģ|Ğ|Ġ|Ĝ|Ģ=i',
					'=ħ|ĥ|Ħ|Ĥ=i',
					'=í|ì|î|ï|ı|ĩ|į|ï|Î|Í|Ì|Ï|İ|Ĩ|Į|Ī=i',
					'=ĵ|Ĵ=i',
					'=ķ|ĸ|Ķ=i',
					'=ł|ľ|ĺ|ļ|Ł|Ľ|Ĺ|Ļ=i',
					'=ñ|ń|ň|ņ|Ñ|Ń|Ň|Ņ=i',
					'=ó|ò|ô|õ|ő|ō|Ô|Ó|Ò|Õ|Ő|Ō=i',
					'=ö|ø|Ö|Ø=i',
					'=ŕ|ř|ŗ|Ŕ|Ř|Ŗ=i',
					'=š|ś|ş|ŝ|Š|Ś|Ş|Ŝ=i',
					'=ß=i',
					'=ť|ţ|ŧ|Ť|Ţ|Ŧ=i',
					'=Þ|þ=i',
					'=ú|ù|û|ů|ű|ŭ|ų|ũ|ū|Û|Ú|Ù|Ů|Ű|Ŭ|Ų|Ũ|Ū=i',
					'=ü|Ü=i',
					'=ý|ÿ|Ý|Ÿ=i',
					'=ź|ž|ż|Ź|Ž|Ż=i',
			);
	// build replace array
	$replace = array(
					'-',
					'a',
					'aa',
					'ae',
					'c',
					'd',
					'dj',
					'e',
					'g',
					'h',
					'i',
					'j',
					'k',
					'l',
					'n',
					'o',
					'oe',
					'r',
					's',
					'ss',
					't',
					'th',
					'u',
					'ue',
					'y',
					'z',
			);
	// replace special characters
	$string = preg_replace($search, $replace, (string) $string);
	
	// delete others specials characters
	$string = preg_replace('=[^a-z0-9._-]*=i', '', $string);
	
	// delete stopwords (SEO)
	$string = stopWords($string);
	
	// replace double -
	$string = preg_replace('=-+=', '-', $string);
	
	// strip out leading and ending "-"
	$string = preg_replace('=^-|-$=', '', $string);

	// convert to lower case
	return strtolower($string);
}






/**
* Affiche la pagination façon bootstrap à l'endroit où cette fonction est appelée
* @param string $url L'URL ou nom de la page appelant la fonction, ex: 'index.php' ou 'http://example.com/'
* @param string $link Le nom du paramètre pour la page affichée dans l'URL, ex: '?page=' ou '?&p='
* @param string $suffix Le suffixe pour la page affichée dans l'URL, ex: '/'
* @param int $total Le nombre total de pages
* @param int $current Le numéro de la page courante
* @param int $adj (facultatif) Le nombre de pages affichées de chaque côté de la page courante (défaut : 3)
* @return La chaîne de caractères permettant d'afficher la pagination
*/
function paginate($url, $link, $suffix, $total, $current, $adj = NUMBER_OF_PAGE_BY_PAGINATION_BY_SIDE, $idAntiScroll = 'stopscroll') {
	// Initialisation des variables
	$prev = $current - 1; // numéro de la page précédente
	$next = $current + 1; // numéro de la page suivante
	$penultimate = $total - 1; // numéro de l'avant-dernière page
	$pagination = ''; // variable retour de la fonction : vide tant qu'il n'y a pas au moins 2 pages

	if ($total > 1) {
		// Remplissage de la chaîne de caractères à retourner
		$pagination .= '<ul class="pagination">';

		/* =================================
		*  Affichage du bouton [précédent]
		* ================================= */
		if ($current == 2) {
			// la page courante est la 2, le bouton renvoie donc sur la page 1, remarquez qu'il est inutile de mettre $url{$link}1{$suffix}
			$pagination .= '<li><a href="' . $url . '">&laquo;</a></li>';
		}
		elseif ($current > 2) {
			// la page courante est supérieure à 2, le bouton renvoie sur la page dont le numéro est immédiatement inférieur
			$pagination .= '<li><a href="' . $url . $link . $prev . $suffix . '">&laquo;</a></li>';
		}
		/**
		* Début affichage des pages, l'exemple reprend le cas de 3 numéros de pages adjacents (par défaut) de chaque côté du numéro courant
		* - CAS 1 : il y a au plus 12 pages, insuffisant pour faire une troncature
		* - CAS 2 : il y a au moins 13 pages, on effectue la troncature pour afficher 11 numéros de pages au total
		*/
		/* ===============================================
		*  CAS 1 : au plus 12 pages -> pas de troncature
		* =============================================== */
		if ($total < 7 + ($adj * 2)) {
			// Ajout de la page 1 : on la traite en dehors de la boucle pour n'avoir que index.php au lieu de index.php?p=1 et ainsi éviter le duplicate content
			$pagination .= ($current == 1) ? '<li class="active"><a href="#' . $idAntiScroll . '">1</a></li>' : '<li><a href="' . $url . '">1</a></li>'; // Opérateur ternaire : (condition) ? 'valeur si vrai' : 'valeur si fausse'
			// Pour les pages restantes on utilise itère
			for ($i=2; $i<=$total; $i++) {
				if ($i == $current) {
					// Le numéro de la page courante est mis en évidence
					$pagination .= '<li class="active"><a href="#' . $idAntiScroll . '">' . $i . '</a></li>';
				}
				else {
					// Les autres sont affichées normalement
					$pagination .= '<li><a href="' . $url . $link . $i . $suffix . '">' . $i . '</a></li>';
				}
			}
		}
		/* =========================================
		*  CAS 2 : au moins 13 pages -> troncature
		* ========================================= */
		else {
			/**
			* Troncature 1 : on se situe dans la partie proche des premières pages, on tronque donc la fin de la pagination.
			* l'affichage sera de neuf numéros de pages à gauche ... deux à droite
			* 1 2 3 4 5 6 7 8 9 … 16 17
			*/
			if ($current < 2 + ($adj * 2)) {
				// Affichage du numéro de page 1
				$pagination .= ($current == 1) ? '<li class="active"><a href="#' . $idAntiScroll . '">1</a></li>' : '<li><a href="' . $url . '">1</a></li>';

				// puis des huit autres suivants
				for ($i = 2; $i < 4 + ($adj * 2); $i++) {
					if ($i == $current) {
						$pagination .= '<li class="active"><a href="#' . $idAntiScroll . '">' . $i . '</a></li>';
					}
					else {
						$pagination .= '<li><a href="' . $url . $link . $i . $suffix . '">' . $i . '</a></li>';
					}
				}
				// ... pour marquer la troncature
				$pagination .= '<li><a href="#' . $idAntiScroll . '">&hellip;</a></li>';
				// et enfin les deux derniers numéros
				$pagination .= '<li><a href="' . $url . $link . $penultimate . $suffix . '">' . $penultimate . '</a></li>';
				$pagination .= '<li><a href="' . $url . $link . $total . $suffix . '">' . $total . '</a></li>';
			}
			/**
			* Troncature 2 : on se situe dans la partie centrale de notre pagination, on tronque donc le début et la fin de la pagination.
			* l'affichage sera deux numéros de pages à gauche ... sept au centre ... deux à droite
			* 1 2 … 5 6 7 8 9 10 11 … 16 17
			*/
			elseif ( (($adj * 2) + 1 < $current) && ($current < $total - ($adj * 2)) ) {
				// Affichage des numéros 1 et 2
				$pagination .= '<li><a href="' . $url . '">1</a></li>';
				$pagination .= '<li><a href="' . $url . $link . '2' . $suffix . '">2</a></li>';
				$pagination .= '<li><a href="#' . $idAntiScroll . '">&hellip;</a></li>';
				// les pages du milieu : les trois précédant la page courante, la page courante, puis les trois lui succédant
				for ($i = $current - $adj; $i <= $current + $adj; $i++) {
					if ($i == $current) {
						$pagination .= '<li class="active"><a href="#' . $idAntiScroll . '">' . $i . '</a></li>';
					}
					else {
						$pagination .= '<li><a href="' . $url . $link . $i . $suffix . '">' . $i . '</a></li>';
					}
				}
				$pagination .= '<li><a href="#' . $idAntiScroll . '">&hellip;</a></li>';
				// et les deux derniers numéros
				$pagination .= '<li><a href="' . $url . $link . $penultimate . $suffix . '">' . $penultimate . '</a></li>';
				$pagination .= '<li><a href="' . $url . $link . $total . $suffix . '">' . $total . '</a></li>';
			}
			/**
			* Troncature 3 : on se situe dans la partie de droite, on tronque donc le début de la pagination.
			* l'affichage sera deux numéros de pages à gauche ... neuf à droite
			* 1 2 … 9 10 11 12 13 14 15 16 17
			*/
			else {
				// Affichage des numéros 1 et 2
				$pagination .= '<li><a href="' . $url . '">1</a></li>';
				$pagination .= '<li><a href="' . $url . $link . '2' . $suffix . '">2</a></li>';
				$pagination .= '<li><a href="#' . $idAntiScroll . '">&hellip;</a></li>';

				// puis des neuf derniers numéros
				for ($i = $total - (2 + ($adj * 2)); $i <= $total; $i++) {
					if ($i == $current) {
						$pagination .= '<li class="active"><a href="#' . $idAntiScroll . '">' . $i . '</a></li>';
					}
					else {
						$pagination .= '<li><a href="' . $url . $link . $i . $suffix . '">' . $i . '</a></li>';
					}
				}
			}
		}
		/* ===============================
		*  Affichage du bouton [suivant]
		* =============================== */
		if ($current != $total)
			$pagination .= '<li><a href="' . $url . $link . $next . $suffix . '">&raquo;</a></li>';
		
		$pagination .= '</ul>';
	}
	return ($pagination);
}
?>