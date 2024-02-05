<?php global $product, $product_id, $cats, $datafromprod, $attributes; ?>
<dl class="singleproduct__catattributes">
    <!-- <dt><?= __('Azonosító', 'marrakesh'); ?></dt>
    <dd><?php the_title(); ?></dd>
    <dt><?= __('Bruttó ár', 'marrakesh'); ?></dt>
    <dd><?php wc_get_template_part( 'loop/price'); ?></dd> -->
    <?php /* if ($datafromprod['_tileweight']) : ?>
    <dt><?= __('Súly (1db lap)','marrakesh'); ?></dt>
    <dd><?= $datafromprod['_tileweight']; ?>&nbsp;kg</dd>
    <?php endif; */?>
    <?php if ($datafromprod['_tilewidth']) : ?>
    <dt><?= __('Lapméret','marrakesh'); ?></dt>
    <dd><?= $datafromprod['_tilewidth']; ?>&nbsp;&times;&nbsp;<?= $datafromprod['_tileheight']; ?>&nbsp;cm
    </dd>
    <?php endif; ?>
    <?php /* if ($datafromprod['_tilethickness']) : ?>
    <dt><?= __('Vastagság','marrakesh'); ?></dt>
    <dd><?= $datafromprod['_tilethickness']; ?>&nbsp;cm</dd>
    <?php endif; */?>
    <?php if ($datafromprod['_isboxed']=='yes') : ?>
    <!-- <dt><?= __('Kiszerelés','marrakesh'); ?></dt>
    <dd><?= __('dobozban','marrakesh'); ?></dd> -->
    <dt><?= __('Kiszerelés','marrakesh'); ?></dt>
    <dd><?= $datafromprod['_tilesperbox']; ?>&nbsp;<?= __('lap','marrakesh'); ?>&nbsp;/&nbsp;<?= $datafromprod['_sizeperbox']; ?>&nbsp;m<sup>2</sup>&nbsp;/&nbsp;<?= __('doboz','marrakesh'); ?>
    </dd>
    <dt><?= __('Doboz ár (bruttó)','marrakesh'); ?></dt>
    <dd><?= $product->get_price_html() ?></dd>
    <?php else: ?>
    <dt><?= __('Kiszerelés','marrakesh'); ?></dt>
    <dd><?= __('darab','marrakesh'); ?></dd>
    <?php endif; ?>
</dl>
