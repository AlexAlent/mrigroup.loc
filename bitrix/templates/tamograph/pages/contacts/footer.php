<?php

/**
 * Created by Evgenii Ioffe
 * @author Evgenii Ioffe <ioffe@umispec.ru>
 * @copyright Copyright (c) 2023, Evgenii Ioffe
 */

$data = MrigroupHelper::getCityData();
$mapCoordinates = isset($data['PROPERTY_REGION_MAP_COORDINATES_VALUE']) ? explode(',', $data['PROPERTY_REGION_MAP_COORDINATES_VALUE']) : [];

global $APPLICATION;
?>
    </div>
</div>

<?php if(count($mapCoordinates) == 2):?>
    <div class="section contacts">
        <div class="container">
            <div class="contacts-map" data-lat="<?php echo trim($mapCoordinates[0]);?>" data-lng="<?php echo trim($mapCoordinates[1]);?>" data-zoom="16"></div>
        </div>
    </div>
<?php endif;?>