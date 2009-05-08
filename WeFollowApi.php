<?php

class WeFollowApi {
	var $http;
	var $parser;
	
	var $tagBaseUrl = 'http://wefollow.com/tags/';

	// Iterator methods
	var $nextUrl;
	var $prevUrl;
	
	public function getTaggedPeople($tag) {
		$html = $this->_getRawData($tag); 
		//echo "TaggedPeople: "; print_r($html);
		$pageData = $this->_scrapeTagPage($html);
		print_r($pageData);

		return $pageData->people;
	}
	
	
	
	protected function _scrapeTagPage($html) {
		$dom = $this->_parseHtml($html);
		
		$pagedata = (object) NULL;
		$pagedata->people = array();
		
		$tweeters = $dom->find('#column-main div.tweeters-list');
		if(!empty($tweeters)) {
			foreach($tweeters as $tweeter) {
				$person = (object) NULL;
				//echo "Tweeter: {$tweeter->innertext}\n\n";

				// Grab the twitter username				
				$nameLink = $tweeter->find('h3 a.fn', 0);
				$person->username = $nameLink->plaintext;
				
				// Grab the bio
				$bioData  = $tweeter->find('p', 0);
				if($bioData->plaintext) {
					$person->bio      = $bioData->plaintext;
				}
				
				// Grab the userimage
				$imageData = $tweeter->find('img.user-image', 0);
				$person->image = $imageData->src;
				
				// Followers
				$followerData = $tweeter->find('.follower-number', 0);
				$person->followers = $followerData->plaintext;
				
				// Latest Tweet
				$tweetInfo = $tweeter->find('.latest-tweet p', 0);
				if ($tweetInfo->plaintext) {
					$person->latestTweet = $tweetInfo->plaintext;
				}

				// Full name
				$nameInfo = $tweeter->find('.other-details p', 0);
				if ($nameInfo->plaintext) {
					$person->fullname = $nameInfo->plaintext;
				}
				
				// Website
				$siteInfo = $tweeter->find('.other-details a', 0);
				if ($siteInfo->href) {
					$person->website = $siteInfo->href;
				}
				
				// Tags
				$tagInfo = $tweeter->find('.other-details p a');
				if (count($tagInfo)>0) {
					$person->tags = array();
					foreach($tagInfo as $tagLink) {
						$person->tags[] = $tagLink->plaintext;
					}
				}
				
				

				// Grab the rank
				$rankInfo = $tweeter->find('.rank', 0);
				if ($rankInfo->plaintext) {
					$person->rank     = $rankInfo->plaintext;
				}
			
			
				$pagedata->people[] = $person;

			}		
		}
		
		$dom->clear();
		return $pagedata;
	}	

	protected function _parseHtml($html) {
		if (empty($this->parser)) {
			$this->_initParser();
		}
		return $this->parser->parseHtml($html);
	}	
	
	protected function _getRawData($tag) {
		$this->nextUrl = NULL;
		$this->prevUrl = NULL;
		if (preg_match('/^\w+$/', $tag)) {
			echo "It's a URL\n";
			return $this->_getTagPage($tag);
		} elseif (file_exists($tag)) {
			echo "It's a file";
			return file_get_contents($tag);
		} else {
			echo "ERROR: Cannot determine {$tag}\n";
		}
	}
	
	protected function _getTagPage($tag) {
		$url = $this->tagBaseUrl . $tag;
		return $this->_getUrl($url);
	}

	protected function _getUrl($url) {
		if (empty($this->http)) {
			$this->http = new HttpClient();
		}
		return $this->http->getUrl($url);
	}
	
	protected function _initParser() {
		$this->parser = new HtmlParser();
	}
}

?>