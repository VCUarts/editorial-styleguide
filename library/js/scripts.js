/*
 * Bones Scripts File
 * Author: Eddie Machado
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 *
 * There are a lot of example functions and tools in here. If you don't
 * need any of it, just remove it. They are meant to be helpers and are
 * not required. It's your world baby, you can do whatever you want.
*/


/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
function updateViewportDimensions() {
	var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
	return { width:x,height:y };
}
// setting the viewport width
var viewport = updateViewportDimensions();


/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
		if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();

// how long to wait before deciding the resize has stopped, in ms. Around 50-100 should work ok.
var timeToWaitForLast = 100;

/*
 * Put all your regular jQuery in here.
*/

jQuery(document).ready(function($) {

  //Mobile menu
  $('.show-nav').click(function(e) {
    e.preventDefault();  
    $('body').toggleClass('active-mobile');        
  });

  // Initialize all .smoothScroll links
  jQuery(function($) { 
    $.localScroll({ filter: '.smoothScroll' }); 
  });


// scrollspy init function
function initScrollSpy() {
  $('article').each(function(i) {
  var position = $(this).position();

    $(this).scrollspy({
      min: position.top - 10,
      max: position.top - 10 + $(this).height(),
      onEnter: function(element, position) {
        $('.page_item').each(function(i){
          $(this).removeClass('current');
        });
        
        $('.'+element.id).addClass('current');
      }
    });
  });
}

// actually init scrollspy
initScrollSpy();

// on resize clear current, wait for resize to complete and then init scrollspy again
$(window).resize(function () {
  $('.page_item').each(function(i) {
    $(this).removeClass('current');
  });

 waitForFinalEvent( function() {
  initScrollSpy();     
 }, timeToWaitForLast, "setup that scrollspy again but not until we are done resizing that window"); 
});



$('.children .page_item').on('click', function() {
  $self = $(this);
  $('.children .page_item').each(function(i) {
    $(this).removeClass('current');
  });
  $self.addClass('current');
  $self.parents().filter('li').addClass('current');
});

$('.page_item').click(function(e) {
  $(e.target).next('ul').slideToggle();
});
  


}); /* end of as page load scripts */
