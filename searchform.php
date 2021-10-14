<?php
/*
 * Generate a unique ID for each form and a string containing an aria-label if
 * one was passed to get_search_form() in the args array.
 */
$unique_id = sanitize_title(get_the_title()).'-'.rand(0,120);

$aria_label = ! empty( $args['label'] ) ? 'aria-label="' . esc_attr( $args['label'] ) . '"' : '';
?>
<form role="search" <?php echo $aria_label; ?> method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="input-group">
        <input id="<?php echo esc_attr( $unique_id ); ?>" class="input-group-field" type="search" placeholder="<?php echo esc_attr_x( 'Keresés a teljes katalógusban &hellip;', 'placeholder', 'marrakesh' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
        <div class="input-group-button">
            <input type="submit" class="button" value="<?php echo esc_attr_x( 'Keresés', 'submit button', 'marrakesh' ); ?>">
        </div>
    </div>
</form>
