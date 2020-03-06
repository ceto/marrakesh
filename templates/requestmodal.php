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
        <h3>Ajánlat kérése</h3>
        <p>Örömmel vesszük megkeresésedet, személyesen a <a href="<?php the_permalink(get_field('pageforcontact', 'option')) ?>">belvárosi bemutatótermünkben,</a> telefonon a
        <a href="tel:<?= preg_replace("/[^\+0-9]/", "", get_field('cphone', 'option')); ?>"><?php the_field('cphone', 'option'); ?></a> telefonszámon, a <a
            href="mailto:<?php the_field('cemail', 'option'); ?>"><?php the_field('cemail', 'option'); ?></a> email címen, vagy töltsd ki kapcsolati űrlapunkat rád szabott, egyedi ajánlatért.</p>
        <form id="request_form" class="contactform" action="<?= get_template_directory_uri(); ?>/lib/contact.php"
            method="post" data-abide novalidate>
            <div data-abide-error class="alert callout" style="display: none;">
                <p>Hiba történt, ellenőrizd az űrlapot</p>
            </div>
            <ul class="inputgrid">
                <li>
                    <label class="speci">Név*
                        <input id="r_name" name="r_name" type="text" required>
                        <span class="form-error">
                            Megadása kötelező
                        </span>
                    </label>
                </li>
                <li>
                    <label class="speci">E-mail*
                        <input id="r_email" name="r_email" type="email" required>
                        <span class="form-error">
                            Megadása kötelező
                        </span>
                    </label>
                </li>
                <li>
                    <label class="speci">Telefon*
                        <input id="r_tel" name="r_tel" type="text" required>
                        <span class="form-error">
                            Megadása kötelező
                        </span>
                    </label>
                </li>
            </ul>
            <fieldset>
                <legend>Mennyire sürgős az ügy?</legend>
                <ul class="inputgrid">
                    <li><label for="r_timeShort"><input type="radio" name="r_time" value="Azonnal kellene"
                        id="r_timeShort">Azonnal kellene</label></li>
                    <li><label for="r_timeMed"><input type="radio" name="r_time" value="Max. egy hónapot kivárok" id="r_timeMed">Pár hét várakozás belefér</label></li>
                    <li><label for="r_timeLong"><input type="radio" name="r_time" value="Tudok várni 2-3 hónapot egyedi gyártásra" id="r_timeLong">Tudok várni 2-3 hónapot egyedi gyártásra</label></li>
                </ul>
            </fieldset>
            <ul class="inputgrid">
                <li>
                    <label>Megjegyzés vagy kérdés
                        <textarea id="r_message" name="r_message" rows="3"></textarea>
                    </label>
                </li>
            </ul>
            <ul class="inputgrid">
                <li>
                    <label class="accept" for="r_acceptgdpr"><input id="r_acceptgdpr" name="r_acceptgdpr"  type="checkbox" required>
                    Elolvastam és elfogadom az <a target="_blank" href="<?= get_privacy_policy_url(); ?>">adatvédelmi tákékoztatóban foglaltakat.</a>
                    <span class="form-error">Elfogadása kötelező</span>
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
