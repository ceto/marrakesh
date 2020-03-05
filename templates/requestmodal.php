<?php //global $datafromprod, $datafromcat, $product; ?>
<div class="reveal requestmodal" id="requestmodal" data-reveal data-animation-in="scale-in-down fast"
    data-animation-out="scale-out-up fast">

    <header class="requestmodal__head">
        <figure>
            <?php echo wp_get_attachment_image( get_field('singleimg',false,false), 'tiny' ); ?>
        </figure>
        <h2>Ajánlat kérése</h2>
        <p>Vedd fel velünk a kapcsolatot, hogy munkatársunk rád szabott, egyedi ajánlattal tudjon megkeresni a megadott elérhetőségeiden.</p>
        <h3 class="singleproduct__title entry-title"><?php the_title(); ?></h3>
    </header>

    <div class="requestmodal__inner">
        <form id="contact_form" class="contactform" action="<?= get_template_directory_uri(); ?>/lib/contact.php"
            method="post" data-abide novalidate>
            <div class="grid-container">
                <div class="grid-x grid-margin-x">
                    <div class="cell small-12 text-center">
                        <div data-abide-error class="alert callout" style="display: none;">
                            <p style="font-size:1rem; font-weight: bold; color:#c10017">Ejnye no. Valami hiba történt</p>
                        </div>
                    </div>
                    <div class="cell small-12">
                        <label class="speci">Név*
                            <input id="r_name" name="r_name" type="text" required>
                            <span class="form-error">
                                Meagadása kötelező
                            </span>
                        </label>
                    </div>
                    <div class="cell small-12">
                        <label class="speci">E-mail*
                            <input id="r_email" name="r_email" type="email" required>
                            <span class="form-error">
                                Meagadása kötelező
                            </span>
                        </label>
                    </div>
                    <div class="cell small-12">
                        <label class="speci">Telefon*
                            <input id="r_tel" name="r_tel" type="text" required>
                            <span class="form-error">
                                Meagadása kötelező
                            </span>
                        </label>
                    </div>
                    <fieldset class="cell small-12">
                        <legend>Mennyire sürgős az ügy?</legend>
                        <label for="r_timeShort"><input type="radio" name="r_time" value="Azonnal kellene"
                                id="r_timeShort">Azonnal kellene</label>
                        <label for="r_timeMed"><input type="radio" name="r_time" value="Max. egy hónapot kivárok" id="r_timeMed"
                                required>Pár hét várakozás belefér</label>
                        <label for="r_timeLong"><input type="radio" name="r_time" value="Tudok várni 2-3 hónapot egyedi gyártásra" id="r_timeLong"
                                required>Tudok várni 2-3 hónapot hogy legyártsátok</label>
                    </fieldset>
                    <div class="cell small-12">
                        <label>Megjegyzés vagy kérdés
                            <textarea id="r_message" name="r_message" rows="3"></textarea>
                        </label>
                    </div>
                    <div class="cell small-12">
                        <label class="accept" for="r_acceptgdpr"><input id="r_acceptgdpr" name="r_acceptgdpr"  type="checkbox" required>
                        Elolvastam és elfogadom az <a target="_blank" href="<?= get_privacy_policy_url(); ?>">adatvédelmi tákékoztatóban foglaltakat.</a></label>
                    </div>
                </div>
            </div>

            <div class="grid-container">
                <div class="grid-x grid-margin-x">
                    <fieldset class="cell small-12">
                        <div class="formactions text-center">
                            <div id="result"></div>
                            <input type="hidden" name="ap_id" value="<?php echo $subjecto; ?>">
                            <input type="hidden" id="r_vehicle" name="r_vehicle" value="">
                            <input type="hidden" name="message_human" value="2">
                            <input type="hidden" name="submitted" value="1">
                            <button id="contact_submit" type="submit" class="button accent large expanded"><?php _e('Küldés','marrakesh'); ?></button>
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
        <button class="requestmodal__close" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
</div>
