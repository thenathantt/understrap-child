jQuery(document).ready(function($) {

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
          centerPadding: '50px',
          slidesToShow: 3
        }
      },
      {
        breakpoint: 992,
        settings: "unslick"
      }
    ]
  });

});

AOS.init({
  offset: 80,
  delay: 200,
  easing: 'ease-in-out-quad',
});