/* jshint ignore:start */
define(['jquery', 'block_news_slider_plus/slick', 'core/log'], function($, slick, log) {

    "use strict"; // ... jshint ;_;.
    return {
        init: function(showdots, numSlides) {
            $(document).ready(function($) {
                // Style 2
                $('.style2 .multiple-items').slick({
                    dots: showdots,
                    speed: 300,
                    slidesToShow: numSlides,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    swipe: 1,
                    responsive: [
                      {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: numSlides-1,
                                slidesToScroll: 1
                            }
                    },
                      {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: numSlides-2,
                                slidesToScroll: 1
                            }
                    },
                      {
                            breakpoint: 550,
                            settings: {
                                slidesToShow: numSlides-3,
                                slidesToScroll: 1,
                                mobileFirst: true
                            }
                    }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object.
                    ]
                  });

                // Style 3
                $('.style3 .multiple-items').slick({
                    dots: showdots,
                    speed: 300,
                    slidesToShow: numSlides,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    swipe: 1,
                    responsive: [
                    {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: numSlides-1,
                                slidesToScroll: 1
                            }
                    },
                      {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: numSlides-2,
                                slidesToScroll: 1
                            }
                    },
                      {
                            breakpoint: 700,
                            settings: {
                                slidesToShow: numSlides-3,
                                slidesToScroll: 1
                            }
                    },
                      {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: numSlides-1,
                                slidesToScroll: 1
                            }
                    }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object.
                    ]
                  });

                // Style 4
                $('.style4 .multiple-items').slick({
                    dots: showdots,
                    speed: 300,
                    slidesToShow: numSlides,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    swipe: 1,
                    responsive: [
                      {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: numSlides-1,
                                slidesToScroll: 1
                            }
                    },
                      {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: numSlides-2,
                                slidesToScroll: 1
                            }
                    },
                      {
                            breakpoint: 550,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                mobileFirst: true
                            }
                    }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object.
                    ]
                  });

                // Style 5
                $('.style5 .multiple-items').slick({
                    dots: showdots,
                    speed: 300,
                    slidesToShow: numSlides,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    swipe: 1,
                    responsive: [
                    {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: numSlides-1,
                                slidesToScroll: 1
                            }
                    },
                      {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: numSlides-2,
                                slidesToScroll: 1
                            }
                    },
                      {
                            breakpoint: 700,
                            settings: {
                                slidesToShow: numSlides-3,
                                slidesToScroll: 1
                            }
                    },
                      {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                    }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object.
                    ]
                  });

                $('.responsive').slick({
                    dots: showdots,
                    speed: 300,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    responsive: [
                      {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                    },
                      {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                    },
                      {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                    }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object.
                    ]
                  });
                
            });
        }
    };
});

/* jshint ignore:end */
