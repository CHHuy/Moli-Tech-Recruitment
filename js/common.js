/*!--------------------------------------------------------------------------------

 Theme Name: Frontend Seed 4
 Author:     trungnghia112 <trungnghia112@gmail.com>

 -----------------------------------------------------------------------------------*/

if (Modernizr.touch === true && $(window).width() <= 767) {
  //alert('Touch Screen');
} else {

}

(function ($) {
  'use strict';


  /* ==================================================
  # Get scroll bar width
  ===================================================*/
  function getBarwidth() {
    // Create the measurement node
    let scrollDiv = document.createElement('div');
    scrollDiv.className = 'scrollbar-measure';
    document.body.appendChild(scrollDiv);

    // Get the scrollbar width
    let scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
    //console.warn(scrollbarWidth); // Mac:  15

    // Delete the DIV
    document.body.removeChild(scrollDiv);
    return scrollbarWidth;
  }

  /* ==================================================
  # Smooth Scroll
  ===================================================*/
  function scrollToAnchor() {
    $('.js-scroll-to').on('click', function (event) {
      let $anchor = $(this);
      let headerH = '0';
      $('html, body')
        .stop()
        .animate(
          {
            scrollTop: $($anchor.attr('href')).offset().top - headerH + 'px'
          },
          1000
        );
      event.preventDefault();
    });
  }
  function contact_form() {
    $('#section-contact-form').submit(function(e) {
      e.preventDefault();
      var name = $('#name').val();
      var email = $('#email').val();
      var phone = $('#phone').val();
      var message = $('#message').val();

      var params = {
        name : name,
        email : email,
        phone : phone,
        message : message,
      }
      $.ajax({
        type: 'post',
        url: 'send-contact.php',
        data: params,
        dataType: 'json',
        success: function(json){
          if (json['res'] == 0) {
            $('#success').html('<div class="alert alert-danger" role="alert">'+json['msg']+'</div>');
          } else {
            $('#success').html('<div class="alert alert-info" role="alert">'+json['msg']+'</div>');
            $('#name').val('');
            $('#email').val('');
            $('#phone').val('');
            $('#message').val('');
          }
        }
      });
    });
  }

  function init() {
    scrollToAnchor();
    getBarwidth();
    contact_form()
  }

  $(document).ready(function () {
    init();
  }); // end document ready function

  $(window).on('scroll', function () {
  });

  // if ($('.x-toTop').length) {
  //   let scrollTrigger = 100, // px
  //     backToTop = function () {
  //       let scrollTop = $(window).scrollTop();
  //       if (scrollTop > scrollTrigger) {
  //         $('.x-toTop').addClass('active');
  //       } else {
  //         $('.x-toTop').removeClass('active');
  //       }
  //     };
  //   backToTop();
  //   $(window).on('scroll', function () {
  //     backToTop();
  //   });
  // }

})(jQuery); // End jQuery
