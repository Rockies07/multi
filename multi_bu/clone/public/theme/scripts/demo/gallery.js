/* ==========================================================
 * AdminPlus v2.0
 * charts.js
 * 
 * http://www.mosaicpro.biz
 * Copyright MosaicPro
 * 
 * Built exclusively for sale @Envato Marketplaces
 * ========================================================== */ 

function masonryGallery()
{
	var $container = $('.gallery ul');
	$container
		.imagesLoaded( function(){
			$container.masonry({
				gutterWidth: 14,
		    	itemSelector : 'li',
		    	columnWidth: $('.gallery li:first').width()
		  	});
		});
}
$(function()
{
	masonryGallery();

	$(window).resize(function(e){
		masonryGallery();
	});
});