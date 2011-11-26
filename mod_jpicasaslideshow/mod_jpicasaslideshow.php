<?php 

defined( '_JEXEC' ) or die( 'Restricted access' ); // no direct access allowed


require_once dirname(__FILE__).DS.'helper.php'; 


$slideshow = New modjPicasaSlideshowHelper($params);

require JModuleHelper::getLayoutPath('mod_jpicasaslideshow', $params->get('layout', 'jsslides'));


