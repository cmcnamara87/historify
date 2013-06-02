<?php


App::uses('Component', 'Controller');

class TroveComponent extends Component {

	var $theurl = '/result?key=qfqm6uvtu6ttpihh&zone=picture&q=war&include=tags&encoding=json';
	var $baseurl = 'http://api.trove.nla.gov.au';
	
	function warphotos() {
		return file_get_contents($this->baseurl.$this->theurl);
	}
	
	function museum() {
		ini_set('memory_limit','512M');
		$url = '../../app/webroot/files/vernon-browser.xml';
		
		$fileContents= file_get_contents($url);

		$fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);

		$fileContents = trim(str_replace('"', "'", $fileContents));

		$simpleXml = simplexml_load_string($fileContents);

		$json = json_encode($simpleXml);
		
		echo '<pre>'; 
		print_r(json_decode($json));
		die();
	}
	
	function getCollections() {
		ini_set('memory_limit','512M');
		$url = '../../app/webroot/files/myouseum150-collections-fixed.csv';
		$data = file_get_contents($url);
		//print_r($data);
		$collections = $this->csvToJson($data);
		return $collections;
	}
	
	function getfulltext($article_id) {
		$forcerefresh = false;
		$cachefile = '/var/www/historify.ensense.net/app/tmp/fulltext_z_'.$article_id;
		if(!file_exists($cachefile) || $forcerefresh) {
			$fulldata = 'http://api.trove.nla.gov.au/newspaper/'.$article_id.'?key=qfqm6uvtu6ttpihh&reclevel=full&encoding=json&include=articletext';
			$fulldata = json_decode(file_get_contents($fulldata));
			$fulltext = '';
			if(isset($fulldata->article->articleText)) {
		  		$fulltext = $this->riptags($fulldata->article->articleText);
		  	}
		  	file_put_contents($cachefile,$fulltext);
		}
		$fulltext = array();
		$fulltext['text'] = file_get_contents($cachefile);
		return $fulltext;
	}
	
	function riptags($text) {
		return str_replace("&nbsp;","",trim(stripslashes(strip_tags($text, '<p><br>'))));
	}
	
	function image($article_id) {
		$forcerefresh = true;
		$cachefile = '/var/www/historify.ensense.net/app/tmp/image_'.$article_id;
		if(!file_exists($cachefile) || $forcerefresh) {
			$articleurl = 'http://trove.nla.gov.au/ndp/del/printArticleJpg/'.$article_id.'/3?print=n';
			$articledata = file_get_contents($articleurl);
			$articledata = substr($articledata,strpos($articledata, "<div><img id='articleImg' src='")+31);
			file_put_contents($cachefile,substr($articledata, 0, strpos($articledata, "'/>")));
		}
		$imageurl = 'http://trove.nla.gov.au'.file_get_contents($cachefile);
		return $imageurl; 
	}
	
	function search($searchterm,$page=1,$forcerefresh=false) {
		$alldata = array();
		$cachefile = '/var/www/historify.ensense.net/app/tmp/datazz_'.$searchterm.'_'.$page;
		if(!file_exists($cachefile) || $forcerefresh) {
			$extra = '';
			if($page > 1) {
			    $extra = '&s='.($page-1)*20;
			}
			$savepage = false;
			$thesearchterms = str_replace("_", "%20", $searchterm);
			$url = 'http://api.trove.nla.gov.au/result?key=qfqm6uvtu6ttpihh&zone=newspaper&reclevel=full&encoding=json&q='.$thesearchterms.$extra;
			$url = str_replace(" ", "%20", $url);
			$data = json_decode(file_get_contents($url));
			foreach($data->response->zone[0]->records->article as $article) {
			    $savepage = true;
			    $article->imageurl = 'http://historify.ensense.net/api/image/'.$article->id;
			    $article->fulltexturl = 'http://historify.ensense.net/api/fulltext/'.$article->id;
			    $article->title = $article->title->value;
			    $article->location = $this->getGeo($article->title);
			    unset($article->url);
			    unset($article->category);
			    unset($article->page);
			    unset($article->pageSequence);
			    unset($article->relevance);
			    $article->snippet = $this->riptags($article->snippet);
			}
			if($savepage) {
			    $alldata = array_merge($data->response->zone[0]->records->article,$alldata);
			} else {
			    echo 'Error loading data';
			    die();
			}
			file_put_contents($cachefile, json_encode($alldata));
			
		}
		$alldata = json_decode(file_get_contents($cachefile));
		return $alldata;
	}
	
	function getGeo($titlename) {
		$forcerefresh = true;
		$cachefile = '/var/www/historify.ensense.net/app/tmp/geom_'.$titlename;
		if(!file_exists($cachefile) || $forcerefresh) {
			$input = $titlename;
			$start = strpos($input, '(') + 1;
			$end = strpos($input, ':');
			$string = substr($input, $start, $end - $start);
			$string = str_replace(" ", "+", urlencode($string));
			
			$details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$string."&sensor=false";
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $details_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = json_decode(curl_exec($ch), true);
			
			$array = array(
			    'latitude' => '-27.4667',
			    'longitude' => '153.03333',
			    'location_type' => 'cats',
			);
			
			if ($response['status'] != 'OK') {
				$array['location_type'] = 'bad';
			    return $array;
			}
			
			$geometry = $response['results'][0]['geometry'];
			 
			$latitude = $geometry['location']['lat'];
			$longitude = $geometry['location']['lng'];
			
			 
			$array = array(
			    'latitude' => $geometry['location']['lat'],
			    'longitude' => $geometry['location']['lng'],
			    'location_type' => $geometry['location_type'],
			);
			
			file_put_contents($cachefile,json_encode($array));
		}
		$data = file_get_contents($cachefile);
		return array('latitude'=>$data->latitude,'longitude'=>$data->longitude);
	}
	
	function getPhotos() {
		ini_set('memory_limit','512M');
		$url = '../../app/webroot/files/myouseum150-photos.csv';
		$data = file_get_contents($url);
		//print_r($data);
		$photos = $this->csvToJson($data);
		return $photos;
	}
	
	function csvToJson($csv) {
		$csv = str_replace("\r", "\n", $csv);
		$csv = str_replace("\N", "\n", $csv);
    	$rows = explode("\n", trim($csv));
    	$csvarr = array();
    	foreach($rows as $row) {
	    	$rowdata = array();
	    	$rowdata = explode(",", trim($row));
	    	$csvarr[] = $rowdata;
    	}
    	return $csvarr;
    }

}
