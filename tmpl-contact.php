<?php
/**
 * Template Name: Contact Template with Map
 */
?>
<?php use Roots\Sage\Titles; ?>
<?php while (have_posts()) : the_post(); ?>
<div class="masthead">
    <div class="grid-container">
        <div class="grid-x grid-margin-x align-right">
            <div class="cell large-9 xxlarge-9">
                <?php if ($localnav = get_field('localnav')) :  ?>
                <?php
                        $themenu = wp_get_nav_menu_object($localnav);
                        $menuitems = wp_get_nav_menu_items($localnav);
                    ?>
                <select class="taxchooser" name="taxchooser" id="taxchooser"
                    onChange="window.location.href=this.value;">
                    <option value="#" disabled><?= $themenu->name; ?>&hellip;</option>
                    <?php foreach( $menuitems as $item ): ?>
                    <option value="<?= $item->url ?>" <?= ($item->url==get_permalink())?'selected':'';  ?>>
                        <?= $item->title ?></option>
                    <?php endforeach; ?>
                </select>
                <a class="js-taxchooserstart"><?= $themenu->name; ?> &#9662;</a>
                <?php endif; ?>
                <h1 id="#content" class="page__title"><?= Titles\title(); ?></h1>
            </div>
        </div>
    </div>
    <figure class="masthead__bg">
        <?php
        if ( !( $mastheadbg = get_field('masthead-bg') ) )  {
            $mastheadbg = get_field('mhbg', 'option');
        };
            echo wp_get_attachment_image( $mastheadbg['ID'], 'xlarge' );
         ?>
    </figure>
</div>

<div class="grid-container">
    <div class="grid-x grid-margin-x">
        <div class="cell tablet-9 xlarge-7 xxlarge-6 tablet-order-2">
            <div class="ps ps--narrow">
                <?php if (has_excerpt()) : ?>
                <div class="lead"><?php the_excerpt(); ?></div>
                <?php endif; ?>
                <?php the_content(); ?>
                <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
                <?php get_template_part('/templates/dlcage' ); ?>
            </div>
        </div>
        <div class="cell tablet-3 xxlarge-3 tablet-order-1">
            <div class="ps ps--narrow">
                <aside class="sidebar sidebar--page">
                    <?php dynamic_sidebar('sidebar-page'); ?>
                </aside>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>
<div id="map" class="mapcanvas"></div>

<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtnKZlzItFYvs7X9kN8p26rvnrtWxeNT8&sensor=false"></script>
<script type="text/javascript">
//   var map;
//   var map2;
function initialize() {
    var latlngwarehouse = new google.maps.LatLng(47.443153, 18.932294);
    var latlngshowroom = new google.maps.LatLng(47.493006, 19.067229);
    var myOptions = {
        zoom: 12,
        disableDefaultUI: false,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: [{
            "featureType": "administrative",
            "elementType": "labels",
            "stylers": [
                // { "visibility": "off" }
            ]
        }, {
            "featureType": "landscape",
            "elementType": "labels",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "featureType": "transit",
            "elementType": "labels",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "featureType": "landscape",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#ececec"
            }]
        }, {
            "featureType": "water",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#dadada"
            }]
        }, {
            "featureType": "poi",
            "elementType": "geometry.fill",
            "stylers": [{
                    "color": "#c6c6c6"
                },
                {
                    "visibility": "on"
                }
            ]
        }, {
            "featureType": "poi",
            "elementType": "labels",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "elementType": "labels.text",
            "stylers": [{
                    "weight": 0.1
                },
                {
                    "color": "#606060"
                }
            ]
        }, {
            "featureType": "administrative.locality",
            "elementType": "labels.text",
            "stylers": [{
                "color": "#4e4e4e"
            }]
        }, {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [{
                    "color": "#df542a"
                },
                {
                    "weight": 0.25
                }
            ]
        }, {
            "featureType": "road.highway",
            "elementType": "labels.icon",
            "stylers": [
                // { "visibility": "off" }
            ]
        }]
    };
    myOptions["center"] = latlngshowroom;
    var map = new google.maps.Map(document.getElementById('map'), myOptions);
    var markerwarehouse = new google.maps.Marker({
        position: latlngwarehouse,
        map: map,
        title: "Marrakesh raktár és átvevőpont"
        //shadow:shadow
    });
    infowarehouse = new google.maps.InfoWindow({
        content: '<h6>Bemutatóterem</h6>' +
        '<p>Törökbálint Depó</p>' +
        '<p><a href="_target="_blank">Útvonaltervezés</a></p>'
    });
    infowarehouse.open(map, markerwarehouse);


    var markershowroom = new google.maps.Marker({
        position: latlngshowroom,
        map: map,
        title: "Marrakesh bemutatóterem"
        //shadow:shadow
    });
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
