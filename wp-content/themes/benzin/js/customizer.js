/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

  //Header Topbar Bg
  wp.customize("benzin_header_topbar_color", function (value) {
    value.bind(function (to) {
      $(".header_style_2 .toolbar-area").css("background", to);
    });
  });

  //Header menubar Bg
  wp.customize("benzin_header_menubar_color", function (value) {
    value.bind(function (to) {
      $(".header_style_2 .header-menu-area .header-main-menu").css("background", to);
    });
  });
  

  //Primary button background Bg
  wp.customize("benzin_button_background_color", function (value) {
    value.bind(function (to) {
      $("body .main-btn-blue, .blog-post-sidebar .search-form .search-submit, .wp-block-search__button, .back-blue, .header_style_2 .navbar-menu ul li .sub-menu li:hover::before, .header_style_2 .home-slider .slick-dots li.slick-active button, .page-numbers.current, a.page-numbers:hover, .header_style_2 .navbar-menu ul li.current_page_parent .sub-menu li.current_page_item a").css("background", to);
    });
  });


  //Header background Bg
  wp.customize("benzin_header_background", function (value) {
    value.bind(function (to) {
      $(".breadcrumbs_section::before").css("background", to);
    });
  });
  //body background Bg
  wp.customize("benzin_body_color", function (value) {
    value.bind(function (to) {
      $("body").css("background", to);
    });
  });

  //Slider Bg
  wp.customize("benzin_slide_color", function (value) {
    value.bind(function (to) {
      $(".header_style_2 .home-slider .single-slider::before").css("background", to);
    });
  });


  //Blog Bg
  wp.customize("benzin_blog_color", function (value) {
    value.bind(function (to) {
      $(".blog_style2").css("background", to);
    });
  });

  //Footer Bg
  wp.customize("benzin_footer_color", function (value) {
    value.bind(function (to) {
      $(".footer_style2").css("background", to);
    });
  });

  //Footer bottom Bg
  wp.customize("benzin_footer_bottom_color", function (value) {
    value.bind(function (to) {
      $(".footer_style2 .footer-copyright").css("background", to);
    });
  });

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					clip: 'auto',
					position: 'relative',
				} );
				$( '.site-title a, .site-description' ).css( {
					color: to,
				} );
			}
		} );
	} );
}( jQuery ) );
