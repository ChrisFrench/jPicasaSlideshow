<?php 
// This is the default output file
defined('_JEXEC') or die;

//JHTML::_('script', 'jquery.min.js', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/');
JHTML::_('script', 'fadeSlideShow.js', 'modules/mod_jpicasaslideshow/js/');
$document = &JFactory::getDocument();
$noConflict = " jQuery.noConflict(); ";
$document->addScriptDeclaration( $noConflict );

$js = " jQuery(document).ready(function() {
    jQuery('#Slideshow').delay(2000).fadeSlideShow({
        width: {$slideshow->width},
        height: {$slideshow->height},
        ListElement: '',
        PrevElement: 'Prev',
        NextElement: 'Next',
        PlayPauseElement: 'Pause',
		PlayPauseElement: 'Play',
		allowKeyboardCtrl: 0,
        interval: 5000
    });
  }); ";
  
  
  $css ="
  .slideshow li,
.slideshow ul{
    list-style:none;
}
.slideshow li.image {
	width: 400px ;
	text-align: center;
	background-color: #FFFFFF;
}

}    
.slideshow li.image img {
	max-height:288px;
	margin: 0 auto;
  
}
 
.slideshow .caption h3,
.slideshow .caption,
.slideshow .caption a {
    color: #FFFFFF;
    text-decoration: none;
}

.slideshow .caption {
    padding: 5px 10px;
}

.slideshow #Prev, .slideshow #Next, .slideshow #Pause, .slideshow #Play { margin-left: 4px; padding: 4px;}

";
$document->addScriptDeclaration( $js );
$document->addStyleDeclaration($css);
?>


<h1><?php echo $slideshow->gallery->channel->title; ?></h1>

<div class="slideshow">
	<ul id="Slideshow">
		<?php 
		$images = array();
		$html = '';
				// we need to flip the array because it is in reverse. So build the array full of HTML, flip the array and output it. 
				foreach ($slideshow->gallery->channel->item as $image) {
					$li = '<li class="image">';
					$li .= '<img src="' . $image -> enclosure['url'] . '"' .'height="'. $slideshow->height .'"'.'  ref="" title="" />';
					$li .= '<div class="schoolcaption">';
					$li .= '<span class="caption_text">' . trim(substr(stripslashes($image -> description), 0, 145)) . '</span>';
					$li .= '</div></li>';
					$images [] = $li;
				}
				$images = array_reverse ($images);
				foreach($images as $image) {
					$html .= $image;
					
				}
				echo $html;
		?>
		
		</ul>
		</div>