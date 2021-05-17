$headerHeight = '';
$headerHeight = '';
$headerHeightscroll = '';

jQuery(document).ready(function($) {

    /* For author published Article text change */
    $('.wpuf-dashboard-content table td').each(function() {
        var pub_text = $(this).text();
        if ($(this).text() == 'Publish') {
            $(this).text('Published');
        }
    });

    if ((screen.width < 992 && screen.height < 480) || (screen.width < 480 && screen.height < 992)) {
        //console.log('mobile');
        //var nav_clone = jQuery(".nav_menu").clone().addClass("");
        //jQuery(".mobile_menu .inner").append(nav_clone);
        $(".navbar-toggle").click(function() {
            if ($(this).hasClass("active")) {
                $(this).removeClass("active");
                $('.mobile_menu').animate({
                    'right': '-100%'
                }, 500);
            } else {
                $(this).addClass("active");
                $('.mobile_menu').animate({
                    'right': '0'
                }, 500);
            }
        });
        $(".mobile_menu ul li").find("ul").parents("li").prepend("<span></span>");
        $(".mobile_menu ul li ul").addClass("first-sub");
        $(".mobile_menu ul li ul").prev().prev("span").addClass("first-em");
        $(".mobile_menu ul li ul ul").removeClass("first-sub");
        $(".mobile_menu ul li ul ul").addClass("second-sub");
        $(".mobile_menu ul li ul ul").prev().prev("span").addClass("second-em");
        $(".mobile_menu ul li ul ul").prev().prev("span").removeClass("first-em");
        $(".mobile_menu ul li span.first-em").click(function(e) {
            $(".mobile_menu ul li span.first-em").removeClass('active');
            $(".mobile_menu ul li span.second-em").removeClass('active');
            if ($(this).parent("li").hasClass("active")) {
                $(this).parent("li").removeClass("active");
                $(this).next().next("ul.first-sub").slideUp();
                $(".mobile_menu ul li ul.second-sub li").removeClass("active");
                $(".mobile_menu ul li ul.second-sub").slideUp();
            } else {
                $(this).addClass('active');
                $(".mobile_menu ul li").removeClass("active");
                $(this).parent("li").addClass("active");
                $(".mobile_menu ul li ul.first-sub").slideUp();
                $(this).next().next("ul.first-sub").slideDown();
                $(".mobile_menu ul li ul.second-sub li").removeClass("active");
                $(".mobile_menu ul li ul.second-sub").slideUp();
            }
        });
        $(".mobile_menu ul li ul.first-sub li span.second-em").click(function(e) {
            $(".mobile_menu ul li span.second-em").removeClass('active');
            if ($(this).parent("li").hasClass("active")) {
                $(this).parent("li").removeClass("active");
                $(this).next().next("ul.second-sub").slideUp();
            } else {
                $(this).addClass('active');
                $(".mobile_menu ul li ul li").removeClass("active");
                $(this).parent("li").addClass("active");
                $(".mobile_menu ul li ul.second-sub").slideUp();
                $(this).next().next("ul.second-sub").slideDown();
            }
        });
        $(".close-btn").click(function() {
            $('.mobile_menu').animate({
                'right': '-100%'
            }, 500);
            $(" .navbar-toggle").removeClass("active");
        });
    }
   

    /* stop past date selection in ninja form date picker */
    if(typeof Marionette !== 'undefined') {
        new(Marionette.Object.extend( {
            initialize: function() {
                this.listenTo( Backbone.Radio.channel( 'pikaday' ), 'init', this.modifyDatepicker );
            },
            modifyDatepicker: function( dateObject, fieldModel ) {
                dateObject.pikaday._o.minDate = moment().subtract(1, 'day');
            }
        }));
    }


    $('.article-section ul.article-list').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        autoplay: true,
        adaptiveHeight: true,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 640,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
    
    $('.location-therapists-section ul.staff-list').slick({
        infinite: true,
        slidesToShow: 2,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        autoplay: true,
        adaptiveHeight: true,
        nextArrow: '<span class="slick-next"> &#10095; </span>',
        prevArrow: '<span class="slick-prev"> &#10094; </span>',
        responsive: [{
            breakpoint: 580,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }]
    });
    
//    jQuery('.wpuf-dashboard-navigation li:first-child a').addClass('active');
    
    jQuery(function(){
        var current = "http://articlebeast.seoweblogistics.com/account/";
        if (window.location.href==current) {
          jQuery('.wpuf-dashboard-navigation li:first-child a').addClass('active');
        }else {
            jQuery('.wpuf-dashboard-navigation li:first-child a').removeClass('active');
        }
    });
    
    
    jQuery(function(){
        var current = window.location.href;
        jQuery('.wpuf-dashboard-navigation li a').each(function(){
            var $this = jQuery(this);
            // if the current path is like this link, make it active
            if($this.attr('href')==current){
                $this.addClass('active');
            }
        })
    });  
    
});



jQuery(window).on('load resize ready', function($) {

    setTimeout(function(){
        $headerHeight = jQuery('header').outerHeight();
        jQuery('#wrapper').css('padding-top', $headerHeight);
        jQuery('.banner-section').css('padding-top', $headerHeight);
    },500);
    if( jQuery(window).scrollTop() > 50 ){
        setTimeout(function(){
            stickyHeader();
        },500);
    }

});

jQuery(window).scroll(function(event) {
    stickyHeader();
});


//----- sticky header script -----//
function stickyHeader() {
    var sticky = jQuery('header'),
        scroll = jQuery(window).scrollTop();

    if (scroll >= 50) {
        sticky.addClass('sticky');
        $headerHeightscroll = jQuery('header.sticky').outerHeight();
    } else sticky.removeClass('sticky');
}


/* function for Lazyload and set image to background in InternetExplorer 11 Only */
var userAgent, ieReg, ie;
userAgent = window.navigator.userAgent;
ieReg = /msie|Trident.*rv[ :]*11\./gi;
ie = ieReg.test(userAgent);
if (ie) {
    jQuery(".innbaner").each(function() {
        var $container = jQuery(this),
            imgUrl = $container.find("img").prop("src");
        if (imgUrl) {
            $container.css({
                "background-image": 'url(' + imgUrl + ')',
                "background-size": "cover",
                "background-position": "center center"
            }).addClass("custom-object-fit");
            jQuery(".innbaner img").css("display", "none");
        }
    });
}

// Populate images from data attributes.
  var scrolled = jQuery(window).scrollTop()
  jQuery('.parallax').each(function(index) {
      var imageSrc = jQuery(this).data('image-src')
      var imageHeight = jQuery(this).data('height')
      jQuery(this).css('background-image','url(' + imageSrc + ')')
      jQuery(this).css('height', imageHeight)

      // Adjust the background position.
      var initY = jQuery(this).offset().top
      var height = jQuery(this).height()
      var diff = scrolled - initY
      var ratio = Math.round((diff / height) * 100)
      jQuery(this).css('background-position','center ' + parseInt(-(ratio * 1.5)) + 'px')
  })

  // Attach scroll event to window. Calculate the scroll ratio of each element
  // and change the image position with that ratio.
  // https://codepen.io/lemagus/pen/RWxEYz
  jQuery(window).scroll(function() {
    var scrolled = jQuery(window).scrollTop()
    jQuery('.parallax').each(function(index, element) {
      var initY = jQuery(this).offset().top
      var height = jQuery(this).height()
      var endY  = initY + jQuery(this).height()

      // Check if the element is in the viewport.
      var visible = isInViewport(this)
      if(visible) {
        var diff = scrolled - initY
        var ratio = Math.round((diff / height) * 100)
        $(this).css('background-position','center ' + parseInt(-(ratio * 1.5)) + 'px')
      }
    })
  })


// Check if the element is in the viewport.
// http://www.hnldesign.nl/work/code/check-if-element-is-visible/
function isInViewport(node) {
  // Am I visible? Height and Width are not explicitly necessary in visibility
  // detection, the bottom, right, top and left are the essential checks. If an
  // image is 0x0, it is technically not visible, so it should not be marked as
  // such. That is why either width or height have to be > 0.
  var rect = node.getBoundingClientRect()
  return (
    (rect.height > 0 || rect.width > 0) &&
    rect.bottom >= 0 &&
    rect.right >= 0 &&
    rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.left <= (window.innerWidth || document.documentElement.clientWidth)
  )
}
