jQuery(document).ready(function($) {

  
  // Hide Header on on scroll down
  var didScroll;
  var lastScrollTop = 0;
  var delta = 0;
  var navbar = $('#wrapper-navbar');
  var navbarHeight = navbar.outerHeight();
  var announcement = $('.fj-announcement');
  var announcementHeight = $('.fj-announcement').outerHeight();

  navbar.css({
    'top' : -Math.abs(navbarHeight),
    'margin-bottom' : -Math.abs(navbarHeight)
  });
  navbar.next().css('margin-top', navbarHeight);

  $(window).scroll(function(event){
      didScroll = true;
  });

  setInterval(function() {
      if (didScroll) {
          hasScrolled();
          didScroll = false;
      }
  }, 250);

  function hasScrolled() {
    var st = $(this).scrollTop();
    
    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta){
      return;
    }

    if ( $( window ).width() >= 768 ) {
      // If they are at the very top of the page
      if ( st === 0 ) {
        setTimeout(function(){
          if ( !navbar.hasClass('top') ) { navbar.addClass('top'); }
          navbar.css('top', -Math.abs(navbarHeight));
        }, 400);
      }

      // If they scrolled down and are past the navbar, change top position.
      // This is necessary so you never see what is "behind" the navbar.
      if (st > lastScrollTop && st > announcementHeight){
        // Scroll Down
        if ( navbar.hasClass('top') ) { navbar.removeClass('top'); }
        navbar.css('top', -Math.abs(announcementHeight) );
      }
      else if (st < announcementHeight && !navbar.hasClass('top')) {
        // Scroll up
        navbar.css('top', '0' );
      } 
      else if ( !navbar.hasClass('top') ){
        // Scroll Up
        if(st + $(window).height() < $(document).height()) {
            navbar.css('top', -Math.abs(announcementHeight) );
        }
      }
      
      lastScrollTop = st;
    }
    else if ( $( window ).width() < 768 ) {
      // If they are at the very top of the page
      if ( st === 0 ) {
        setTimeout(function(){
          if ( !navbar.hasClass('top') ) { navbar.addClass('top'); }
          navbar.css('top', -Math.abs(navbarHeight));
        }, 500);
      }

      // If they scrolled down and are past the navbar, change top position.
      // This is necessary so you never see what is "behind" the navbar.
      if (st > lastScrollTop && st > navbarHeight){
        // Scroll Down
        if ( navbar.hasClass('top') ) { navbar.removeClass('top'); }
        navbar.css('top', -Math.abs(navbarHeight) );
      }
      else if (st < announcementHeight && !navbar.hasClass('top')) {
        // Scroll up
        navbar.css('top', '0' );
      } 
      else if ( !navbar.hasClass('top') ){
        // Scroll Up
        if(st + $(window).height() < $(document).height()) {
            navbar.css('top', -Math.abs(announcementHeight) );
        }
      }
      
      lastScrollTop = st;
    }
  }

  $('.fj-offcanvas-toggle').on('click', function(){
    var toggleClass = $(this).attr('data-toggle');
    var targetClass = $(this).attr('data-target');
    var overlay = $('.fj-offcanvas-overlay');
    var offcanvasWrapper = $(targetClass);

    if ( offcanvasWrapper.hasClass('hide') && $('body').hasClass('noscroll') && overlay.hasClass('fj-offcanvas-overlay--visible') ) {
      offcanvasWrapper.toggleClass(toggleClass);
    } else if ( ! offcanvasWrapper.hasClass('hide') && ! $(this).hasClass('fj-offcanvas-toggle--close') && $('body').hasClass('noscroll') && overlay.hasClass('fj-offcanvas-overlay--visible') ) {
      offcanvasWrapper.toggleClass(toggleClass);
    }
    else {
      $('body').toggleClass('noscroll');
      overlay.toggleClass('fj-offcanvas-overlay--visible');
      offcanvasWrapper.toggleClass(toggleClass);
    }

  });

  $('.fj-offcanvas-overlay').on('click', function(){
    var overlay = $(this);
    var activeOffcanvasWrapper = $('.fj-offcanvas-wrapper:not(".hide")');
    var mobileNavLevelTwo = $('.fj-mobile-nav__level-two:not(".hide")');

    if ( ! activeOffcanvasWrapper.hasClass('hide') ){
      $('body').toggleClass('noscroll');
      overlay.toggleClass('fj-offcanvas-overlay--visible');
      activeOffcanvasWrapper.toggleClass('hide');    
      if ( mobileNavLevelTwo ) {
        setTimeout( function(){ mobileNavLevelTwo.toggleClass('hide'); }, 500);
      }
    }
  });

  $('.fj-toggle').on('click', function(){
    var toggleClass = $(this).attr('data-toggle');
    var targetClass = $(this).attr('data-target');
    var targetClassCleaned = targetClass.replace(/\./g,'');

    var currentPrimaryItem = $('.fj-quick-nav__item--primary.active');
    var currentSecondaryMenu = $('.fj-quick-nav__level-two:not(.hide)');
    var currentSecondaryMenuItems = $('.fj-quick-nav__level-two:not(.hide)').find('.fj-quick-nav__item');

    var selectedPrimaryItem = $(this).parent();
    var selectedSecondaryMenu = $(targetClass);
    var selectedSecondaryMenuItems = $(targetClass).find(".fj-quick-nav__item");

    var time = 0;
    var interval = 50;

    // Checks if the clicked primary menu item is already active
    if ( selectedPrimaryItem.hasClass('active') ){
      currentPrimaryItem.toggleClass('active');
      currentSecondaryMenu.toggleClass(toggleClass);

      currentSecondaryMenuItems.each(function(){
        var currentItem = $(this);
        setTimeout( function(){ currentItem.toggleClass(toggleClass); }, time);
        time += interval;
      });
    } else if ( !selectedPrimaryItem.hasClass('active') && !currentPrimaryItem) {
      selectedPrimaryItem.toggleClass('active');
      selectedSecondaryMenu.toggleClass(toggleClass);

      selectedSecondaryMenuItems.each(function(){
        var selectedItem = $(this);
        setTimeout( function(){ selectedItem.toggleClass(toggleClass); }, time);
        time += interval;
      });
    } else {
      currentPrimaryItem.toggleClass('active');
      currentSecondaryMenu.toggleClass(toggleClass);

      currentSecondaryMenuItems.each(function(){
        var currentItem = $(this);
        setTimeout( function(){ currentItem.toggleClass(toggleClass); }, time);
        time += interval;
      });

      selectedPrimaryItem.toggleClass('active');
      selectedSecondaryMenu.toggleClass(toggleClass);

      selectedSecondaryMenuItems.each(function(){
        var selectedItem = $(this);
        setTimeout( function(){ selectedItem.toggleClass(toggleClass); }, time);
        time += interval;
      });
    }
  });

  //
  // Smooth Scroll to Anchors
  //

  // Select all links with hashes
  $('a[href*="#"]')
    // Remove links that don't actually link to anything
    .not('[href="#"]')
    .not('[href="#0"]')
    .click(function(event) {
      // On-page links
      if (
        location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
        && 
        location.hostname == this.hostname
      ) {
        // Figure out element to scroll to
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        // Does a scroll target exist?
        if (target.length) {
          // Only prevent default if animation is actually gonna happen
          event.preventDefault();
          $('html, body').animate({
            scrollTop: target.offset().top
          }, 1000, function() {
            // Callback after animation
            // Must change focus!
            var $target = $(target);
            $target.focus();
            if ($target.is(":focus")) { // Checking if the target was focused
              return false;
            } else {
              $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
              $target.focus(); // Set focus again
            };
          });
        }
      }
    });

  // pre-select size 3 to activate YTIH swatches in loop
  $('li.product [id=pa_ring-size]').find('option:nth-child(2)').prop('selected',true).trigger('change'); //trigger a change instead of click

  //
  // Select2
  //

  $('select').select2({minimumResultsForSearch: -1});

  $( ".variations_form" ).on( "check_variations.wc-variation-form", function () {
    var variations = $('.fj-product-summary .variations');
    var resetVariationsWrapper = $( '.reset-variations__wrapper' );
    var resetVariations = $( '.reset_variations' );

    if ( resetVariations.css( 'visibility' ) === 'hidden' ) {
      variations.css('margin-bottom', '1em');
      resetVariationsWrapper.css({
        'margin-top' : '0',
        'height' : '0'
      });
    } else {
      variations.css('margin-bottom', '0.5em');
      resetVariationsWrapper.css({
        'margin-top' : '1em',
        'height' : 'auto'
      });
    }
  });

  //
  //Slick
  //

  $('.fj-related-products-wrapper').slick({
    mobileFirst : true,
    lazyLoad: 'progressive',
    centerMode: true,
    slidesToShow: 1,
    arrows: false,
    centerPadding: '30px',
    responsive: [
      {
        breakpoint: 434,
        settings: {
          arrows: false,
          centerMode: true,
          slidesToShow: 2
        }
      },
      {
        breakpoint: 992,
        settings: "unslick"
      }
    ]
  });

  slickSlider = $('.fj-slick-products').slick({
    // dots: true,
    mobileFirst : true,
    lazyLoad: 'progressive',
    infinite: false,
    slidesToShow: 1,
    arrows: false,
    centerPadding: '40px',
    centerMode: true,
    responsive: [
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 2,
          centerMode: false,
          slidesToShow: 2.1
        }
      },
      {
        breakpoint: 992,
        settings: "unslick"
      }
    ]
  });

  $(window).on('orientationchange', function() {
    slickSlider.slick('resize');
  });

});

AOS.init({
  offset: 80,
  delay: 150,
  easing: 'ease-out',
});