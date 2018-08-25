jQuery(document).ready(function($) {

  $('.finley-wc-sidebar-toggle').on('click', function(){
    var wrapper = $('#page');
    var sidebar = $('#finley-wc-sidebar');

    wrapper.toggleClass('offcanvas-visible');
    sidebar.toggleClass('visible');
  });

});