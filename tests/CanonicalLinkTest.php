<?php

require_once dirname(dirname(__file__)) . '/CanonicalLink.php';
require_once dirname(dirname(__file__)) . '/HttpClient.php';
require_once dirname(dirname(__file__)) . '/HttpCache.php';
require_once dirname(dirname(__file__)) . '/HttpRequest.php';
require_once dirname(dirname(__file__)) . '/HttpResponse.php';
require_once dirname(dirname(__file__)) . '/HttpUtils.php';

class CanonicalLinkTest extends PHPUnit_Framework_TestCase {
	var $canon;
	
	public function setUp() {
		$this->canon = new CanonicalLink();
	}

	public function testInit() {
	
	
	}
	
	/**
		Frame-based tinyurls:

	
		* http://ow.ly/ddvW
		* http://twurl.nl/26tc7d
		* http://migre.me/207l
		* http://tumblr.com/xcg1zx6jw
		* http://tr.im/nX5J
	
		* cli.gs
		
		URL shorteners:
* http://2tu.us/mbi
* http://ad.vu/ius7
* http://bit.ly/bD5sm
* http://budurl.com/usid9
* http://cli.gs/MPt1t
* http://chilp.it/?de477f
* http://digg.com/d3z0gC?t
* http://ff.im/5QPgf
* http://is.gd/1R6Xd
* http://kl.am/1LMT
* http://migre.me/4Hv7
* http://ow.ly/15J4VF
* http://ping.fm/Oty04
* http://shar.es/z1G3
* http://short.to/lcj3
* http://shortna.me/26797
* http://snipr.com/o4zii
* http://su.pr/28KrB9
* http://tcrn.ch/1V4Q
* http://tiny.cc/ZcH0D
* http://tinyurl.com/n3t4h6
* http://tr.im/utgz
* http://tumblr.com/xac2il097
* http://TwitPWR.com/mP0/
* http://twitthis.com/qiaex4)
* http://twitzap.com/u/VmA
* http://twurl.nl/3xv6kx
* http://url.ie/25u7
* http://url4.eu/9aZb
* http://vimeo.com/5810449.
* http://yfrog.com/6wg8tj
* http://zz.gd/396381

		
	**/

/****
	public function testNormalUrl() {
		$url = 'http://www.isolani.co.uk/';
		$canonUrl = $this->canon->getCanonicalLink($url);
		$this->assertEquals($url, $canonUrl);
	}
****/
	
	public function testTinyUrl() {
		$url      = 'http://tinyurl.com/qyx9uu';
		$endUrl   = 'http://www.isolani.co.uk/blog/web/YahooOpenHackLondon2009';
		$canonUrl = $this->canon->getCanonicalLink($url);
		$this->assertEquals($endUrl, $canonUrl);
	}
	
	public function testPingFmUrl() {
		$url      = 'http://ping.fm/dAqfu';
		$endUrl   = 'http://www.selectbooks.com/t_disabilityland.html';
		$canonUrl = $this->canon->getCanonicalLink($url);
		$this->assertEquals($endUrl, $canonUrl);
	}

	public function testBitLyUrl() {
		$url      = 'http://bit.ly/EbnV4';
		$endUrl   = 'http://apiwiki.twitter.com/Streaming-API-Documentation';
		$canonUrl = $this->canon->getCanonicalLink($url);
		$this->assertEquals($endUrl, $canonUrl);
	}

	public function testIsGdUrl() {
		$url      = 'http://is.gd/12zij';
		$endUrl   = 'http://www.flickr.com/photos/formfromfunction/170650901/';
		$canonUrl = $this->canon->getCanonicalLink($url);
		$this->assertEquals($endUrl, $canonUrl);
	}

/****
	public function testMultipleRedirectUrl() {
		$url      = 'http://ping.fm/lzYNA';
		$endUrl   = 'http://web.me.com/abrightman/DisabilityLand/About.html';
		$canonUrl = $this->canon->getCanonicalLink($url);
		$this->assertEquals($endUrl, $canonUrl);
	}
****/

}


?>