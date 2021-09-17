/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {
    // Use this variable to set up the common and page specific functions. If you
    // rename this variable, you will also need to rename the namespace below.
    var Sage = {
        // All pages
        common: {
            init: function() {
                // JavaScript to be fired on all pages
            },
            finalize: function() {
                // JavaScript to be fired on all pages, after page specific JS is fired
            }
        },
        // Home page
        home: {
            init: function() {
                // JavaScript to be fired on the home page
            },
            finalize: function() {
                // JavaScript to be fired on the home page, after the init JS
            }
        },
        // About us page, note the change from about-us to about_us.
        about_us: {
            init: function() {
                // JavaScript to be fired on the about us page
            }
        }
    };

    // The routing fires all common scripts, followed by the page specific scripts.
    // Add additional events for more control over timing e.g. a finalize event
    var UTIL = {
        fire: function(func, funcname, args) {
            var fire;
            var namespace = Sage;
            funcname = funcname === undefined ? "init" : funcname;
            fire = func !== "";
            fire = fire && namespace[func];
            fire = fire && typeof namespace[func][funcname] === "function";

            if (fire) {
                namespace[func][funcname](args);
            }
        },
        loadEvents: function() {
            // Fire common init JS
            UTIL.fire("common");

            // Fire page-specific init JS, and then finalize JS
            $.each(
                document.body.className.replace(/-/g, "_").split(/\s+/),
                function(i, classnm) {
                    UTIL.fire(classnm);
                    UTIL.fire(classnm, "finalize");
                }
            );

            // Fire common finalize JS
            UTIL.fire("common", "finalize");
        }
    };

    // Load Events
    $(document).ready(UTIL.loadEvents);
})(jQuery); // Fully reference jQuery after this point.

$(document).foundation();

$(document).ready(function() {});

$("#instockyesno").on("click", function(e) {
    // e.preventDefault();

    window.location = $(".wc-availability-in-stock a").attr("href");
});

//photoswipe things
var initPhotoSwipeFromDOM = function(gallerySelector) {
    // parse slide data (url, title, size ...) from DOM elements
    // (children of gallerySelector)
    var parseThumbnailElements = function(el) {
        var thumbElements = el.childNodes,
            numNodes = thumbElements.length,
            items = [],
            figureEl,
            linkEl,
            size,
            item;

        for (var i = 0; i < numNodes; i++) {
            figureEl = thumbElements[i]; // <figure> element

            // include only element nodes
            if (figureEl.nodeType !== 1) {
                continue;
            }

            linkEl = figureEl.children[0]; // <a> element

            size = linkEl.getAttribute("data-size").split("x");

            // create slide object
            item = {
                src: linkEl.getAttribute("href"),
                w: parseInt(size[0], 10),
                h: parseInt(size[1], 10)
            };

            if (linkEl.getAttribute("data-title")) {
                item.title =
                    "<h3>" + linkEl.getAttribute("data-title") + "</h3>";
                item.caption = linkEl.getAttribute("data-caption");
            } else {
                item.title = "";
            }

            if (figureEl.children.length > 1) {
                item.title = "<h3>" + figureEl.children[1].innerHTML + "</h3>";
            }

            if (linkEl.children.length > 0) {
                // <img> thumbnail element, retrieving thumbnail url
                item.msrc = linkEl.children[0].getAttribute("src");
            }

            item.el = figureEl; // save link to element for getThumbBoundsFn
            items.push(item);
        }

        return items;
    };

    // find nearest parent element
    var closest = function closest(el, fn) {
        return el && (fn(el) ? el : closest(el.parentNode, fn));
    };

    var openPhotoSwipe = function(
        index,
        galleryElement,
        disableAnimation,
        fromURL
    ) {
        var pswpElement = document.querySelectorAll(".pswp")[0],
            gallery,
            options,
            items;

        items = parseThumbnailElements(galleryElement);

        // define options (if needed)
        options = {
            history: false,

            // define gallery index (for URL)
            galleryUID: galleryElement.getAttribute("data-pswp-uid"),

            getThumbBoundsFn: function(index) {
                // See Options -> getThumbBoundsFn section of documentation for more info
                var thumbnail = items[index].el.getElementsByTagName("img")[0], // find thumbnail
                    pageYScroll =
                        window.pageYOffset ||
                        document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect();

                return {
                    x: rect.left,
                    y: rect.top + pageYScroll,
                    w: rect.width
                };
            }
        };

        // PhotoSwipe opened from URL
        if (fromURL) {
            if (options.galleryPIDs) {
                // parse real index when custom PIDs are used
                // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                for (var j = 0; j < items.length; j++) {
                    if (items[j].pid === index) {
                        options.index = j;
                        break;
                    }
                }
            } else {
                // in URL indexes start from 1
                options.index = parseInt(index, 10) - 1;
            }
        } else {
            options.index = parseInt(index, 10);
        }

        // exit if index not found
        if (isNaN(options.index)) {
            return;
        }

        if (disableAnimation) {
            options.showAnimationDuration = 0;
        }

        // Pass data to PhotoSwipe and initialize it
        gallery = new PhotoSwipe(
            pswpElement,
            PhotoSwipeUI_Default,
            items,
            options
        );
        gallery.init();
    };

    // triggers when user clicks on thumbnail
    var onThumbnailsClick = function(e) {
        e = e || window.event;
        // e.preventDefault ? e.preventDefault() : e.returnValue = false;
        if (e.preventDefault) {
            e.preventDefault();
        } else {
            e.returnValue = false;
        }
        var eTarget = e.target || e.srcElement;

        // find root element of slide
        var clickedListItem = closest(eTarget, function(el) {
            return el.tagName && el.tagName.toUpperCase() === "FIGURE";
        });

        if (!clickedListItem) {
            return;
        }

        // find index of clicked item by looping through all child nodes
        // alternatively, you may define index via data- attribute
        var clickedGallery = clickedListItem.parentNode,
            childNodes = clickedListItem.parentNode.childNodes,
            numChildNodes = childNodes.length,
            nodeIndex = 0,
            index;

        for (var i = 0; i < numChildNodes; i++) {
            if (childNodes[i].nodeType !== 1) {
                continue;
            }

            if (childNodes[i] === clickedListItem) {
                index = nodeIndex;
                break;
            }
            nodeIndex++;
        }

        if (index >= 0) {
            // open PhotoSwipe if valid index found
            openPhotoSwipe(index, clickedGallery);
        }
        return false;
    };

    // parse picture index and gallery index from URL (#&pid=1&gid=2)
    var photoswipeParseHash = function() {
        var hash = window.location.hash.substring(1),
            params = {};

        if (hash.length < 5) {
            return params;
        }

        var vars = hash.split("&");
        for (var i = 0; i < vars.length; i++) {
            if (!vars[i]) {
                continue;
            }
            var pair = vars[i].split("=");
            if (pair.length < 2) {
                continue;
            }
            params[pair[0]] = pair[1];
        }

        if (params.gid) {
            params.gid = parseInt(params.gid, 10);
        }

        return params;
    };

    // loop through all gallery elements and bind events
    var galleryElements = document.querySelectorAll(gallerySelector);

    for (var i = 0, l = galleryElements.length; i < l; i++) {
        galleryElements[i].setAttribute("data-pswp-uid", i + 1);
        galleryElements[i].onclick = onThumbnailsClick;
    }

    // Parse URL and open gallery if it contains #&pid=3&gid=1
    var hashData = photoswipeParseHash();
    if (hashData.pid && hashData.gid) {
        openPhotoSwipe(
            hashData.pid,
            galleryElements[hashData.gid - 1],
            true,
            true
        );
    }
};

// execute above function
if ($(".psgallery").length) {
    initPhotoSwipeFromDOM(".psgallery");
}

///////////////////////////////////////////////////////
// Calculator on single product detail pages
//////////////////////////////////////////////////////


function formatNumber (num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ");
}

var $form = $("form.order");
var origForm = $form.serialize();

function updateOrderBox($changed) {
    var $boxes = $("#boxes");
    var $sqft = $("#sqft");
    var $boxesInput = $boxes.val();
    var $sqftInput = $sqft.val();
    var $totalSqftText = $(".sqft-total");
    var $totalBoxText = $(".box-total");
    var $submitbtn = $(".order-submit button");
    var $priceText = $(".order-submit__price .price");
    var $orderButton = $(".order-submit__actions .order-button");
    var $buttonCount = $(".order-submit__actions .order-button strong");
    var pricePerBox = $(".pricePerBox").val();
    var sqftPerBox = $(".sqftPerBox").val();
    var pricePerSqft = $(".pricePerSqft").val();
    var orderQuantity = $(".orderQuantity");
    var numberOfBoxes;

    //if change happened on tile order box
    if ($changed.is("#sqft") || $changed.is("#boxes")) {
        if ($changed.is("#sqft")) {
            numberOfBoxes = Math.ceil($sqftInput / sqftPerBox); //sqft multiplier
        } else if ($changed.is("#boxes")) {
            numberOfBoxes = Math.ceil($boxesInput);
        }

        var sqftText = numberOfBoxes * sqftPerBox;
        $totalSqftText.text(sqftText.toFixed(2));
        $("#r_amount").val(sqftText.toFixed(0));
        $totalBoxText.text(numberOfBoxes);

        //update price
        var newPrice = numberOfBoxes * pricePerBox;
        var priceText = formatNumber(newPrice.toFixed(0));
        $priceText.html(
            "<small>" + $(".order-submit__price .price small").text() + "</small>" + priceText + marrakesh_globals.currency_symbol
        );

        //update button text
        $buttonCount.html(sqftText.toFixed(2) + " m<sup>2</sup>");

        //update button url
        orderQuantity.val(numberOfBoxes);
        // if (numberOfBoxes > 0) {
        //     $submitbtn.removeAttr("disabled");
        // } else {
        //     $submitbtn.setAttribute("disabled");
        // }

        if ($changed.is("#sqft")) {
            //update the boxes value
            $boxes.val(numberOfBoxes);
        } else if ($changed.is("#boxes")) {
            //update sqft value
            $sqft.val(sqftText.toFixed(2));
        }
    } /*else if ($changed.is("#quantity")) {
        //else if other order box changed
        var $qty = $("#quantity");
        var $qtyInput = $qty.val();
        numberOfProduct = Math.ceil($qtyInput);

        //update price
        var newPrice = numberOfProduct * sqftPerBox;
        var priceText = newPrice.toFixed(2);
        $priceText.text("€ " + priceText);

        //update button text
        $buttonCount.text(numberOfProduct);

        //update button url
        orderQuantity.val(numberOfProduct);
    }*/
}

$("form.order :input").on("change input", function() {
    if (
        $form.serialize() !== origForm &&
        $(this).attr("id") !== "yith-wcwtl-email"
    ) {
        origForm = $form.serialize();
        updateOrderBox($(this));
    }
});
// $("form.order").on("submit", function(e) {
//     e.preventDefault();
//     return false;
// });

$(".scroller").on("click", ".js-scrollright", function(e) {
    e.preventDefault();
    var el = document.querySelector(
        "." +
            $(this)
                .parent()
                .attr("data-target")
    );
    el.scrollLeft = el.scrollLeft + 216;
});

$(".scroller").on("click", ".js-scrollleft", function(e) {
    e.preventDefault();
    var el = document.querySelector(
        "." +
            $(this)
                .parent()
                .attr("data-target")
    );
    el.scrollLeft = el.scrollLeft - 216;
});


$(".tmplcard").swipe( {
    allowPageScroll: 'vertical',
    swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
        if ( direction === 'right' || direction === 'left' ) {
            $(this).find('.tmplcard__fulllink').toggleClass('swiped');
        }
    },


  });

  const $heroslider = $('.heroslider');
  $heroslider
      .slick({
          arrows: false,
          dots: true,
          // prevArrow: '<button type="button" class="slick-prev"><svg class="icon"><use xlink:href="#icon-caret-left"></use></svg></button>',
          // nextArrow: '<button type="button" class="slick-next"><svg class="icon"><use xlink:href="#icon-caret-right"></use></svg></button>',
          // appendArrows: '.carouselwrap',
          infinite: true,
          slidesToShow: 1,
          fade: true,
          cssEase: 'linear',
          speed: 500,
          adaptiveHeight: true,
          autoplay:true
  });

  //Set some options later
//   $(".tmplcard").swipe( {fingers:2} );
