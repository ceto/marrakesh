<?php global $product_id; ?>
<?php if ( defined( 'YITH_WCWL' ) ) : ?>
    <div class="yith-wcwl-add-button">
        <?php if (! YITH_WCWL()->is_product_in_wishlist( $product_id ) ):  //add button ?>
        <a
            href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'add_to_wishlist', $product_id, get_permalink() ), 'add_to_wishlist' ) ); ?>"
            class="button button--yithwcwladd"
            data-product-id="<?= $product_id; ?>"
            data-title="<?= __('Hozzáadás a személyes listához') ?>"
            rel="nofollow"
        >
            <svg class="icon"><use xlink:href="#icon-star-outline"></use></svg>
        </a>
        <?php else : //remove button ?>
            <a
                    href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'remove_from_wishlist', $product_id, get_permalink() ), 'remove_from_wishlist' ) ); ?>"
                    class="button button--yithwcwlremove"
                    data-product-id="<?php echo esc_attr( $product_id ); ?>"
                    data-title="<?= __('Eltávolítás a személyes listából') ?>"
                    rel="nofollow"
            >
                <svg class="icon"><use xlink:href="#icon-star-checked"></use></svg>
                </a>
        <?php endif; ?>
    </div>
<?php endif; //van telepitve yitwcwl?>
