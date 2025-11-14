<?php

/**
 * Created by Evgenii Ioffe
 * @author Evgenii Ioffe <ioffe@umispec.ru>
 * @copyright Copyright (c) 2023, Evgenii Ioffe
 */

global $APPLICATION;

$content = $APPLICATION->GetProperty('arfoto_services_content');
?>
    </div>
</div>

<?php if($content):?>
    <div class="section">
        <div class="container">
            <div class="section-content">
                <?php echo $content;?>
            </div>
        </div>
    </div>
<?php endif;?>