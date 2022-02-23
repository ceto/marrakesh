


        $('.button--yithwcwladd').on( 'click', function( ev ) {
            ev.preventDefault();
            var t = $(this),
                product_id = t.attr( 'data-product-id' ),
                el_wrap = t.parent(),
                data = {
                    action: yith_wcwl_l10n.actions.add_to_wishlist_action,
                    nonce: yith_wcwl_l10n.nonce.add_to_wishlist_nonce,
                    add_to_wishlist: product_id,
                };
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
                    if( response_result === 'true' || response_result === 'exists' ) {
                        el_wrap.find('.button--yithwcwladd').css( "display", "none" );
                        el_wrap.find('.button--yithwcwlremove').css( "display", "block" );
                    }
                }

            });

            return false;
        } );

        $('.button--yithwcwlremove').on( 'click', function( ev ) {
            ev.preventDefault();
            var t = $(this),
                product_id = t.attr( 'data-product-id' ),
                item_id = t.attr( 'data-item-id' ),
                el_wrap = t.parent(),
                data = {
                    action: yith_wcwl_l10n.actions.remove_from_wishlist_action,
                    nonce: yith_wcwl_l10n.nonce.remove_from_wishlist_nonce,
                    remove_from_wishlist: product_id,
                };
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
                    if( response_result === 'true' || response_result === 'not_exists' ) {
                        el_wrap.find('.button--yithwcwlremove').css( "display", "none" );
                        el_wrap.find('.button--yithwcwladd').css( "display", "block" );
                    }
                }

            });

            return false;
        } );


