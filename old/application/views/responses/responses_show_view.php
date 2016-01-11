<?php if ($element->exists()) : ?>
    <ul class="thumbnails">
        <?php foreach ($element as $item) : ?>
            <li  class="span2" id="<?php echo $ctrlr ?>_<?php echo $item->id ?>">
                <div class="thumbnail">
                    <h3 itemprop="name">
                      <?php echo anchor($ctrlr.'/view/' . $item->id, $item->label, array('itemprop' => 'url')) ?></h3>
                    <p>
                        <span itemprop="label"><?php echo $item->label ?></span><br>
                    </p>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
