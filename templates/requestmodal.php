<?php global $datafromprod, $datafromcat, $product; ?>
<div class="reveal requestmodal" id="requestmodal" data-reveal data-animation-in="scale-in-down fast"
    data-animation-out="scale-out-up fast">
    <header class="requestmodal__head">
        <div class="grid-container">
            <figure>
                <?php echo wp_get_attachment_image( get_field('singleimg',false,false), 'tiny' ); ?>
            </figure>
            <h2 class="singleproduct__title entry-title"><?php the_title(); ?></h2>
            <p class="singleproduct__price">
                <?php wc_get_template_part( 'loop/price'); ?>
            </p>
            <div style="font-size:1.25rem">
                <?php echo wc_get_stock_html( $product ); ?>
            </div>
        </div>
    </header>
    <div class="grid-container">
        <h3><?= __('Ajánlat kérése', 'marrakesh'); ?></h3>
        <?php
            $showroomlink ='<a target="_blank" href="'.get_permalink(get_field('pageforcontact', 'option')).'">'.__('belvárosi bemutatótermünkben','marrakesh').'</a>';
            $emaillink = '<a href="mailto:'.get_field('cemail', 'option').'">'.get_field('cemail', 'option').'</a>';
            $phonelink = '<a href="tel: '.preg_replace("/[^\+0-9]/", "", get_field('cphone', 'option')).'">'.get_field('cphone', 'option').'</a>';
        ?>
        <p><?php printf( __( 'Örömmel vesszük megkeresésedet, személyesen a %1s, telefonon a %2s telefonszámon. az %3s email címen, vagy töltsd ki kapcsolati űrlapunkat rád szabott, egyedi ajánlatért.' , 'marrakesh' ), $showroomlink, $phonelink, $emaillink ); ?></p>
        <form id="request_form" class="contactform" action="<?= get_template_directory_uri(); ?>/lib/contact.php"
            method="post" data-abide novalidate>
            <div data-abide-error class="alert callout" style="display: none;">
                <p><?= __('Hiba történt, ellenőrizd az űrlapot','marrakesh' ); ?></p>
            </div>
            <ul class="inputgrid">
                <li>
                    <label class="speci"><?= __('Név', 'marrakesh'); ?>*
                        <input id="r_name" name="r_name" type="text" required>
                        <span class="form-error">
                            <?= __('Megadása kötelező','marrakesh'); ?>
                        </span>
                    </label>
                </li>
                <li>
                    <label class="speci"><?= __('E-mail', 'marrakesh'); ?>*
                        <input id="r_email" name="r_email" type="email" required>
                        <span class="form-error">
                            <?= __('Megadása kötelező','marrakesh'); ?>
                        </span>
                    </label>
                </li>
                <li>
                    <label class="speci"><?= __('Telefon', 'marrakesh'); ?>*
                        <input id="r_tel" name="r_tel" type="text" required>
                        <span class="form-error">
                            <?= __('Megadása kötelező','marrakesh'); ?>
                        </span>
                    </label>
                </li>
                <li>
                    <label class="speci"><?= __('Mennyiség', 'marrakesh'); ?> <?= ($datafromprod['_isboxed']=='yes')?'(m<sup>2</sup>)':__('(db.)','marrakesh'); ?>
                        <input id="r_amount" name="r_amount" type="text">
                    </label>
                </li>
            </ul>
            <ul class="inputgrid">
                <li>
                    <label><?= __('Megjegyzés vagy kérdés', 'marrakesh'); ?>
                        <textarea id="r_message" name="r_message" rows="3"></textarea>
                    </label>
                </li>
            </ul>
            <ul class="inputgrid">
                <li>
                    <label class="accept" for="r_acceptgdpr"><input id="r_acceptgdpr" name="r_acceptgdpr"  type="checkbox" required>
                    <?= __('Elolvastam és elfogadom az','marrakesh'); ?> <a target="_blank" href="<?= get_privacy_policy_url(); ?>"><?= __('adatvédelmi tákékoztatóban foglaltakat.','marrakesh'); ?></a>
                    <span class="form-error"><?= __('Elfogadása kötelező', 'marrakesh'); ?></span>
                    </label>
                </li>
            </ul>
            <div class="formactions text-center">
                <div id="result"></div>
                <input type="hidden" name="ap_id" value="<?php echo $subjecto; ?>">
                <input type="hidden" id="r_amount" name="r_amount" value="">
                <input type="hidden" id="r_product" name="r_product" value="<?= get_the_id(); ?>">
                <input type="hidden" name="message_human" value="2">
                <input type="hidden" name="submitted" value="1">
                <button id="contact_submit" type="submit" class="button accent large expanded"><?php _e('Küldés','marrakesh'); ?></button>
            </div>
        </form>
        <button class="requestmodal__close" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
