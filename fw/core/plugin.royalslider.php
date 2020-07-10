<?php
/* Royal Slider support functions
------------------------------------------------------------------------------- */

// Check if Royal Slider installed and activated
if ( !function_exists( 'themerex_exists_royalslider' ) ) {
	function themerex_exists_royalslider() {
		return class_exists("NewRoyalSliderMain");
	}
}
?>