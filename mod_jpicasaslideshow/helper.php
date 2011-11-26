
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
	
	
	
	
	// added this because server requires we load remote files via CURL
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
   
   
   
   
   
   
	function getPicasa($var, $attribs = array()) {
		
		$html = '';

		if (!empty($item -> picasa_code)) {

			// is it a URL?
			if ($this -> isValidURL($item -> picasa_code)) {
				$gallery = load_file($item -> picasa_code);
				$config = SchoolsConfig::getInstance();
				$width = !empty($attribs['picasa_width']) ? $attribs['picasa_width'] : $config -> get('picasa_width', '400');
				$height = !empty($attribs['picasa_height']) ? $attribs['picasa_height'] : $config -> get('picasa_height', '267');
				//$this->url_encoded = urlencode( $item->picasa_code );

	
				$images = array();
				
				// we need to flip the array because it is in reverse. So build the array full of HTML, flip the array and output it. 
				foreach ($slideshow->gallery->channel->item as $image) {
					$li = '<li class="image">';
					$li .= '<img src="' . makethumbnailURL($image -> title, $image -> enclosure['url'], $width) . '" height="300px"; ref="" title="" />';
					$li .= '<div class="schoolcaption">';
					$li .= '<span class="caption_text">' . trim(substr(stripslashes($image -> description), 0, 145)) . '</span>';
					$li .= '</div></li>';
					$images [] = $li;
				}
				$images = array_reverse ($images);
				foreach($images as $image) {
					$html .= $image;
					
				}
				
				$html .= '</ul></div>';

			}
			// or is it embed code (HTML)?
			else {
				$html .= $item -> picasa_code;
			}

		}

		return $html;
	}
	
	
}