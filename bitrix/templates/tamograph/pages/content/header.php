<?php

/**
 * Created by Evgenii Ioffe
 * @author Evgenii Ioffe <ioffe@umispec.ru>
 * @copyright Copyright (c) 2023, Evgenii Ioffe
 */

$h1 = trim($APPLICATION->GetPageProperty('arfoto_h1'));
?>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-content">
                    <?php if($h1):?>
                        <h1><?php echo $h1;?></h1>
                    <?php endif;?>