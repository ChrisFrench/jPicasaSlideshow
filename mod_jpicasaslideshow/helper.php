<?php

class modjPicasaSlideshowHelper {
	
	var $url = NULL;
	var $conn = NULL;
	var $width = NULL;
	var $height = NULL;
	var $title = NULL;
	var $gallery = NULL;
	
	function __construct( $params )
    {
        $this->_params = $params;
		$this->url = str_replace("/data/feed/base/", "/data/feed/api/", $this->_params->get('mod_jpicasaslideshow_url'));
		$this->conn = $this->_params->get('mod_jpicasaslideshow_conn');
		$this->width = $this->_params->get('mod_jpicasaslideshow_width');
		$this->gallery = $this->createGallery();
		$this->height = $this->_params->get('mod_jpicasaslideshow_height');
		
		foreach ($this->gallery->channel->item as $item) {
			$replace = 's' . $this->width . '/' . $item->title;
			$item -> enclosure['url'] = str_replace($item->title, $replace, $item -> enclosure['url']);
		}
    }
	
	function echoURL()
	{
		return $this->url;
	}

	// added this because many  servers require we load remote files via CURL
	function load_file( ) {
		switch ($this->conn) {
			case 'simplexml':
			$xml = simplexml_load_file($this->url);
				break;
			case 'CURL':
			$ch = curl_init($this->url);
			#Return http response in string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$xml = simplexml_load_string(curl_exec($ch));
				break;
			default:
				$xml = simplexml_load_file($this->url);
				break;	
		}	
		return $xml;
	}
		
   function createGallery(){
	$gallery = $this->load_file();
	return $gallery;
	
   }
 
}