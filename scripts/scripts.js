/* 
	Custom Scripts
*/
jQuery(document).ready(function($) {
	/*================================================================================================================*/
    /*                                                                                                                */
    /*                                                    GLOBAL                                                      */
    /*                                                                                                                */             
    /*================================================================================================================*/
	// --------------- Fancybox --------------- //
		$("a.fancybox").fancybox({
			openEffect	: 'elastic',
			closeEffect	: 'elastic',
			helpers : {
				title : {
					type : 'outside'
				},
				media: true
			}
		});

	// --------------- Superfish --------------- //
		$('.primary-nav ul').superfish({ 
			delay: 200,
			animation: {opacity:'show', height:'show'},
			speed: 'fast',
			autoArrows: false,
			dropShadows: false
		});

	// --------------- Mobile Nav --------------- //
	    $('#mobile_nav').mmenu({
            offCanvas: {
               "position" : "left",
               "zposition" : "next"
            }
        });

    // -------------- Footer Accordion -------------- //
        var winIsSmall;
        $(window).on('load resize', footerAccordion);

        function footerAccordion() {
            winIsSmall = window.innerWidth < 769;
            $('.column1st .footer-accordion-content').toggle(!winIsSmall);
        }

        $('.column1st').find('h5').click(function () {
            if(winIsSmall){
                $(this).toggleClass('active');
                $(this).children().toggleClass('icon-plus icon-close');
                $(this).parent().find('.footer-accordion-content').stop().slideToggle(100);
            }
        });

    /* ------------- Main Tabs ------------- */
        // Tabs Content
        $(".tab-content").hide(); //Hide all content
        $("ul.tabs li:first").addClass("active").show(); //Activate first tab
        $(".tab-content:first").show(); //Show first tab content

        // Tab links
        $("ul.tabs li").click(function() {
            $("ul.tabs li").removeClass("active"); //Remove any "active" class
            $(this).addClass("active"); //Add "active" class to selected tab
            $(".tab-content").hide(); //Hide all tab content
            var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
            $(activeTab).fadeIn(); //Fade in the active content
            return false;
        });

    /* -------------- Accordion -------------- */
        $('h3.toggle').click(function() { // Accoridon button action (on click do the following)
            $('h3.toggle').children().attr('class', 'icon-plus');
            $('h3.toggle').removeClass('active'); // Remove the .active class on all toggle buttons

            $('.accordion-content').slideUp('fast'); // Close all other accordions

            if($(this).next().is(':hidden') === true) { // If the next slide wasn't opened, open it
                $(this).addClass('active'); // Add .active class to clicked accordion
                $(this).children().attr('class', 'icon-close');
                $(this).next().slideDown('fast');// Open accordion
            }
        });
        $('.accordion-content').hide(); // Close all accordions on page load       

    // --------------- Smooth scroll --------------- //
        $('.scroll').click(function() {
           var elementClicked = $(this).attr("href");
           var destination = $(elementClicked).offset().top;
           $("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-100}, 500 );
           return false;
        });


    /*================================================================================================================*/
    /*                                                                                                                */
    /*                                                     HOME                                                       */
    /*                                                                                                                */             
    /*================================================================================================================*/
    // --------------- Home Banners --------------- //
        $("#home_banners").owlCarousel({
            navigation : false,
            pagination : true,
            slideSpeed : 200,
            singleItem : true,
            autoPlay   : 6000

            // "singleItem:true" is a shortcut for:
            // items : 1, 
            // itemsDesktop : false,
            // itemsDesktopSmall : false,
            // itemsTablet: false,
            // itemsMobile : false
        });

    // Apply height of tallest .proList to all children
	    /*var maxHeight = 0;
	    $('.featured.home ul li').each(function() { maxHeight = Math.max(maxHeight, $(this).height()); }).height(maxHeight);*/

    // --------------- Gallery --------------- //
        $('.lightGallery').lightGallery({

        }); 

});