<?php 
/*  http://slidesjs.com/
 *  If you really like this  version of the slideshow, you should  check the url and send them a donation
 * */

// This is the default output file
defined('_JEXEC') or die;
if($params->get('mod_jpicasaslideshow_jquery')) {
 JHTML::_('script', 'jquery.min.js', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/');
}

//
JHTML::_('script', 'slides.min.jquery.js', 'modules/mod_jpicasaslideshow/js/');
//JHTML::_('stylesheet', 'slides.css', 'modules/mod_jpicasaslideshow/css/');
$document = &JFactory::getDocument();
$noConflict = " jQuery.noConflict(); ";
$document->addScriptDeclaration( $noConflict );

$js = " jQuery(function(){
			jQuery('#slides').slides({
				preload: true,
				preloadImage: '/modules/mod_jpicasaslideshow/img/loading.gif',
				play: 5000,
				pause: 2500,
				hoverPause: true,
				animationStart: function(current){
					jQuery('.caption').animate({
						bottom:-35
					},100);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationStart on slide: ', current);
					};
				},
				animationComplete: function(current){
					jQuery('.caption').animate({
						bottom:0
					},200);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationComplete on slide: ', current);
					};
				},
				slidesLoaded: function() {
					jQuery('.caption').animate({
						bottom:0
					},200);
				}
			});
		}); ";
		
		
$document->addScriptDeclaration( $js );		

$bigwidth = $slideshow->width + 139;
$examplewidth = $slideshow->width ;
$containwidth = $slideshow->width + 20;		
$leftwidth = $slideshow->width + 10;
$captionwidth = $slideshow->width - 40 ;	

$nextheight = $slideshow->height /2 - 21.5;

		
$css ="
	#container {
	width:{$containwidth}px;
	padding:10px;
	margin:0 auto;
	position:relative;
	z-index:0;
}

#example {
	width:{$slideshow->width}px;
	height:{$slideshow->height}px;
	position:relative;
	background-color: #FFF;
	padding:10px;
}


#frame {
	position:absolute;
	z-index:0;
	width:{$bigwidth}px;
	height:341px;
	top:-3px;
	left:-65px;
}

/*
	Slideshow
*/

#slides {
	position:absolute;
	top:10px;
	left:10px;
	z-index:100;
}

/*
	Slides container
	Important:
	Set the width of your slides container
	Set to display none, prevents content flash
*/

.slides_container {
	width:{$slideshow->width}px;
	overflow:hidden;
	position:relative;
	display:none;
}

/*
	Each slide
	Important:
	Set the width of your slides
	If height not specified height will be set by the slide content
	Set to display block
*/

.slides_container div.slide {
	width:{$slideshow->width}px;
	height:{$slideshow->height}px;
	display:block;
}


/*
	Next/prev buttons
*/

#slides .next,#slides .prev {
	position:absolute;
	top:{$nextheight}px;
	left:-34px;
	width:24px;
	height:43px;
	display:block;
	z-index:101;
}

#slides .next {
	left:{$leftwidth}px;
}

/*
	Pagination
*/

.pagination {
	margin:26px auto 0;
	width:200px;
}

.pagination li {
	float:left;
	margin:0 1px;
	list-style:none;
}

.pagination li a {
	display:block;
	width:12px;
	height:0;
	padding-top:12px;
	background-image:url(../img/pagination.png);
	background-position:0 0;
	float:left;
	overflow:hidden;
}

.pagination li.current a {
	background-position:0 -12px;
}

/*
	Caption
*/

.caption {
	z-index:500;
	position:absolute;
	bottom:-35px;
	left:0;
	height:50px;
	padding:5px 20px 0 20px;
	background:#067AB7;
	background:rgba(6,122,183,.5);
	width:{$captionwidth}px;
	font-size:1em;
	line-height:1;
	color:#fff;
	border-top:1px solid #000;
	text-shadow:none;
}


/*
	Anchors
*/

a:link,a:visited {
	color:#599100;
	text-decoration:none;
}

a:hover,a:active {
	color:#599100;
	text-decoration:underline;
}
	
	
	
	";	
		
	$document->addStyleDeclaration($css);	
		
		
		
		?>
		


<div id="container">
		<div id="example">
			<div id="slides">
				<div class="slides_container">
					
					<?php 
		$images = array();
		$html = '';
				// we need to flip the array because it is in reverse. So build the array full of HTML, flip the array and output it. 
				foreach ($slideshow->gallery->channel->item as $image) {
					$div = '<div class="slide">';
					$div .=	'<a href="'.$image -> link.'" title="'. $image -> title.'" target="_blank"><img src="'.$image -> enclosure['url'].'" width="'.$slideshow->width.'" height="'.$slideshow->height.'" alt="'.$image->description.'"></a>';
							
				    if(strlen($image->description)) {
					$div .= '<div class="caption" style="bottom:0">';
					$div .= '' . trim(substr(stripslashes($image->description), 0, 145)) . '';
					$div .= '</div>'; //caption
					}
					$div .= '</div>'; //slide
					$images [] = $div;
				}
				$images = array_reverse ($images);
				foreach($images as $image) {
					$html .= $image;
					
				}
				echo $html;
		?>
					
					
			
				</div>
				<a href="#" class="prev"><img src="/modules/mod_jpicasaslideshow/img/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
				<a href="#" class="next"><img src="/modules/mod_jpicasaslideshow/img/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>
			</div>
			
		</div>

	</div>