$('.yith-wcwl-add-button .button').on( 'click', function( ev ) {
    ev.preventDefault();
    var t = $(this),
        product_id = t.attr( 'data-product-id' ),
        el_wrap = t.parent(),
        switchaction = 'remove_from_wishlist';
        switchtext = 'Eltávolítás a személyes listából';
    var data = {
        action: yith_wcwl_l10n.actions.add_to_wishlist_action,
        nonce: yith_wcwl_l10n.nonce.add_to_wishlist_nonce,
        add_to_wishlist: product_id,
    };
    if (t.attr('data-action') === 'remove_from_wishlist') {
        switchaction = 'add_to_wishlist';
        switchtext = 'Hozzáadás a személyes listához';
        data = {
            action: yith_wcwl_l10n.actions.remove_from_wishlist_action,
            nonce: yith_wcwl_l10n.nonce.remove_from_wishlist_nonce,
            remove_from_wishlist: product_id,
        };
    }

    $.ajax({
        type: 'POST',
        url: yith_wcwl_l10n.ajax_url,
        data: data,
        dataType: 'json',
        beforeSend: function(){
            // block( t );

        },
        complete: function(){
            // unblock( t );

        },
        success: function( response ) {
            var response_result = response.result,
                response_message = response.message;
            console.log(response);

            if (t.attr('data-action') === 'remove_from_wishlist') {
                $('.banner__actions__wishlist span').text(parseInt($('.banner__actions__wishlist span').text()) - 1);
            } else {
                $('.banner__actions__wishlist span').text(parseInt($('.banner__actions__wishlist span').text()) + 1);
            }

            t.toggleClass( 'is-on' );
            t.blur();
            t.attr('data-action', switchaction);
            t.attr('data-tip-text', switchtext);
            t.data().zfPlugin.template.text( t.attr('data-tip-text'));
            if ($('body').hasClass('wishlist')) {
                t.closest('.prodcard').remove();
            }



            if( response_result === 'true' || response_result === 'exists' ) {
                // el_wrap.find('.button').toggleClass( "is-on" );
                // el_wrap.find('.button--yithwcwlremove').css( "display", "block" );
            }
        }

    });

    return false;
} );



