var initPhotoSwipeFromWorksDOM = function(gallerySelector) {

    // parse slide data (url, title, size ...) from DOM elements 
    // (children of gallerySelector)
    var parseThumbnailElements = function(el) {
        var griditemElements = el.childNodes,
            numNodes = griditemElements.length,
            items = [],
            griditemEl,
            figureEl,
            linkEl,
            size,
            caption,
            item,
            additem,
            addgimages,
            addgimagesizes,
            addgimgsize;

        for(var i = 0; i < numNodes; i++) {
            griditemEl = griditemElements[i];
            if(griditemEl.nodeType !== 1) {
                continue;
            }
            articleEl = griditemEl.children[0];
            figureEl = articleEl.children[0].children[0];

            linkEl = figureEl.children[0]; // <a> element

            size = linkEl.getAttribute('data-size').split('x');

            item = {
                src: linkEl.getAttribute('data-imagetarget'),
                w: parseInt(size[0], 10),
                h: parseInt(size[1], 10)
            };
  


            caption = articleEl.querySelectorAll('.referencecard__title')[0].textContent;
            if ( articleEl.querySelectorAll('.referencecard__quickinfo').length > 0 ) {
                item.title = '<h3>'+ caption + '<small>' + articleEl.querySelectorAll('.referencecard__quickinfo')[0].textContent + '</small></h3>'; 
            } else {
                item.title =' <h3>'+ caption + '</h3>'; 
            }

            if(linkEl.children.length > 0) {
                // <img> thumbnail element, retrieving thumbnail url
                item.msrc = linkEl.children[0].getAttribute('src');
            } 

            item.el = griditemEl; // save link to element for getThumbBoundsFn
            items.push(item);

            //ha gallery tipusu az elem felveszem azokat is
            if (linkEl.getAttribute('data-type') === 'gallery') {
                addgimages = linkEl.getAttribute('data-gallery').split('|');
                addgimagesizes = linkEl.getAttribute('data-gimagesizes').split('|');
                
                for (var iter=0; iter<addgimages.length; iter++) {
                    addgimgsize=addgimagesizes[iter].split('x');
                    additem = {
                        src: addgimages[iter],
                        msrc: addgimages[iter],
                        w:  parseInt(addgimgsize[0], 10),
                        h:  parseInt(addgimgsize[1], 10),
                        el: item.el,
                        title: item.title
                    };
                    items.push(additem);
                }
            }

        }
        return items;
    };

    // find nearest parent element
    var closest = function closest(el, fn) {
        return el && ( fn(el) ? el : closest(el.parentNode, fn) );
    };

    var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
        var pswpElement = document.querySelectorAll('.pswp')[0],
            gallery,
            options,
            items;

        items = parseThumbnailElements(galleryElement);


        // define options (if needed)
        options = {
            //history: false,
            // define gallery index (for URL)

            galleryUID: galleryElement.getAttribute('data-pswp-uid'),
            
            //closeEl:false,
            //fullscreenEl: false,
            zoomEl: false,
            //shareEl: false,
            counterEl: false,
            //arrowEl: false,

            // Share buttons
            // 
            // Available variables for URL:
            // {{url}}             - url to current page
            // {{text}}            - title
            // {{image_url}}       - encoded image url
            // {{raw_image_url}}   - raw image url

            shareButtons: [
                {id:'facebook', label:'Share on Facebook', url:'https://www.facebook.com/sharer/sharer.php?u='+items[index].el.getElementsByTagName('a')[0].getAttribute('href') },
                {id:'twitter', label:'Tweet', url:'https://twitter.com/intent/tweet?text=' + items[index].el.querySelectorAll('.referencecard__title')[0].innerText /*+ ' - ' + items[index].el.querySelectorAll('.referencecard__quickinfo')[0].innerText*/ + '&url='+items[index].el.getElementsByTagName('a')[0].getAttribute('href') },
                {id:'pinterest', label:'Pin it', url:'http://www.pinterest.com/pin/create/button/?url='+items[index].el.getElementsByTagName('a')[0].getAttribute('href')+'&media={{image_url}}&description=' + items[index].el.querySelectorAll('.referencecard__title')[0].innerText /*+ ' - ' + items[index].el.querySelectorAll('.referencecard__quickinfo')[0].innerText*/},
                {id:'download', label:'Download image', url:'{{raw_image_url}}', download:true}
            ],



            getThumbBoundsFn: function(index) {
                // See Options -> getThumbBoundsFn section of documentation for more info
                var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect(); 

                return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
            }

        };

        // PhotoSwipe opened from URL
        if(fromURL) {
            if(options.galleryPIDs) {
                // parse real index when custom PIDs are used 
                // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                for(var j = 0; j < items.length; j++) {
                    if(items[j].pid === index) {
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
        if( isNaN(options.index) ) {
            return;
        }

        if(disableAnimation) {
            options.showAnimationDuration = 0;
        }

        // Pass data to PhotoSwipe and initialize it
        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);

        
        gallery.init();

        //switch off menu
        document.querySelectorAll('.headroom').forEach(function(el){
            el.classList.remove('headroom--pinned');
            el.classList.add('headroom--unpinned');
        });
        //document.querySelectorAll('.banner__top')[0].classList.add('headroom--unpinned');


        gallery.listen('gettingData', function(index,item) {
            $('.vimeoembed iframe').each( function(i,element) {
                var jqueryPlayer = new Vimeo.Player($(element));
                $(element).on('inview', function(event, isInView) {
                  if (isInView) {
                    //console.log('bejött: ' + $(element).attr('title'));
                    jqueryPlayer.play();
                  } else {
                    //console.log('kiment: ' + $(element).attr('title'));
                    jqueryPlayer.pause();
                  }
                });
            });

        });


        gallery.listen('destroy', function() {
            //document.querySelectorAll('.banner__top')[0].classList.remove('headroom--unpinned');
            // if ( $('.orbit--hero').length ) {
            //     $('.orbit--hero').foundation('_reset');
            // }
                
        });




    };

    // triggers when user clicks on thumbnail
    var onThumbnailsClick = function(e) {
        e = e || window.event;
        if (e.preventDefault) { e.preventDefault(); } else { e.returnValue = false; }

        var eTarget = e.target || e.srcElement;

      

        // find root element of slide
        var clickedListItem = closest(eTarget, function(el) {
            return (el.tagName && el.tagName.toUpperCase() === 'DIV');
        });


        if(!clickedListItem) {
            return;
        }

        // find index of clicked item by looping through all child nodes
        // alternatively, you may define index via data- attribute
        var clickedGallery = clickedListItem.parentNode,
            childNodes = clickedListItem.parentNode.childNodes,
            numChildNodes = childNodes.length,
            nodeIndex = 0,
            numGItems = 0,
            linkEl,
            index;


        for (var i = 0; i < numChildNodes; i++) {
            if(childNodes[i].nodeType !== 1) { 
                continue; 
            }


            if(childNodes[i] === clickedListItem) {
                index = nodeIndex + numGItems;
                break;
            }

            nodeIndex++;

            linkEl = childNodes[i].children[0].children[0].children[0].children[0];
            if(linkEl.getAttribute('data-type') === 'gallery') {
                //console.log(linkEl.getAttribute('data-gallery').split('|').length );
                numGItems+=(linkEl.getAttribute('data-gallery').split('|').length);
            }

        }


        if(index >= 0) {
            // open PhotoSwipe if valid index found
            openPhotoSwipe( index, clickedGallery );
        }
        return false;
    };

    // parse picture index and gallery index from URL (#&pid=1&gid=2)
    var photoswipeParseHash = function() {
        var hash = window.location.hash.substring(1),
        params = {};

        if(hash.length < 5) {
            return params;
        }

        var vars = hash.split('&');
        for (var i = 0; i < vars.length; i++) {
            if(!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');  
            if(pair.length < 2) {
                continue;
            }           
            params[pair[0]] = pair[1];
        }

        if(params.gid) {
            params.gid = parseInt(params.gid, 10);
        }

        return params;
    };



    // loop through all gallery elements and bind events
    var galleryElements = document.querySelectorAll( gallerySelector );

    for(var i = 0, l = galleryElements.length; i < l; i++) {
        galleryElements[i].setAttribute('data-pswp-uid', i+1);
        galleryElements[i].onclick = onThumbnailsClick;
    }

    // Parse URL and open gallery if it contains #&pid=3&gid=1
    var hashData = photoswipeParseHash();
    if(hashData.pid && hashData.gid) {
        openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
    }
};

// execute above function
initPhotoSwipeFromWorksDOM('.referencegrid');












var isIsotopeInit = false;
var $referencegrid = $('.referencegrid');
if ($referencegrid.length ) {
    var portelement = new Foundation.Magellan($referencegrid, {offset: 0} );
}
$referencegrid.isotope({
    itemSelector: '.referencegrid__item',
    percentPosition: true,
    initLayout: false,
    transitionDuration: 400,
    hiddenStyle: {
        opacity: 0,
        transform: 'scale(0.333)'
    },
    visibleStyle: {
        opacity: 1,
        transform: 'scale(1)'
    }
});

// $referencegrid.on( 'arrangeComplete', function( event, filteredItems ) {
//     AOS.refresh();
// });


function getHashFilter() {
    // get filter=filterName
    var matches = location.hash.match( /category=([^&]+)/i );
    var hashFilter = matches && matches[1];
    return hashFilter && decodeURIComponent( hashFilter );
}

$('.menu--portfolio').on('click', 'a', function(e){
    e.preventDefault();

    if ( $('.menu--portfolio').hasClass('js-activate-filter') ) {
        $(this).parent().addClass('is-active');
        var cleanfilt="*";
        if  ( !$(this).parent().hasClass('menu-all') ) {
            var filterAttr = $( this ).attr('href').split('/');
            cleanfilt = filterAttr[2];
        }
        //$referencegrid.foundation('scrollToLoc', '#main');
        setTimeout(function(){
            location.hash = 'category=' + encodeURIComponent(cleanfilt);
        },400);
    } else {
        var targeturl=$(this).attr('href');
        var pathArray = targeturl.split('/');
        if (pathArray.length === 4 ) {
            window.location.href = brick_globals.portfoliourl + '#' + pathArray[1]+'='+pathArray[2];
        } else {
            window.location.href = brick_globals.portfoliourl;
        }
    }
});


function onHashchange() {
    if ( $('.post-type-archive-reference').length ) {
      writeCanonical();
    }

    var hashFilter = getHashFilter();
    if (hashFilter && (hashFilter !== '*')) {
        hashFilter = '.' + hashFilter;
    }    
    //console.log(hashFilter);
    if ( !hashFilter && isIsotopeInit ) {
        return;
    }
    isIsotopeInit = true;
    // filter isotope
    $referencegrid.isotope({
        filter:  hashFilter
    });
    $referencegrid.isotope();

    // set selected class on button
    if ( hashFilter ) {
        $('.menu--portfolio').find('.is-active').removeClass('is-active');
        if (hashFilter==='*') {
            $('.menu--portfolio').find('.menu-all').addClass('is-active');
            //$('.orbit--hero').foundation('_reset');
        } else {
            $targi=hashFilter.split('.');
           
            
            if ($targi[1]){
                $('.menu--portfolio').find('[href*="references/'+ $targi[1] + '"]').parent().addClass('is-active');
                //$('.orbit--hero').foundation('changeSlide', false, $('#'+$targi[1]+'-catslide'), 0);
            } 
        }
    }
}

$(window).on( 'hashchange', onHashchange );

// trigger event handler to init Isotope
onHashchange();