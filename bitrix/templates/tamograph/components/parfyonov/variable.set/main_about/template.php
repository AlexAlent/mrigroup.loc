<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

$title = isset($arParams['TITLE']) ? trim($arParams['TITLE']) : '';
$linkHref = isset($arParams['LINK_HREF']) ? trim($arParams['LINK_HREF']) : '';
$linkText = isset($arParams['LINK_TEXT']) ? trim($arParams['LINK_TEXT']) : '';
$statsText = isset($arParams['STATS_TEXT']) ? trim($arParams['STATS_TEXT']) : '';

$tg = tplvar(MrigroupHelper::tplvar_index_social_tg);
$vk = tplvar(MrigroupHelper::tplvar_index_social_vk);
$ok = false; //tplvar(MrigroupHelper::tplvar_index_social_ok);
?>
<div class="section main-about">
    <div class="container">
        <div class="main-about__row row">
            <div class="main-about__col col-12 col-md-6">
                <?php if($title):?>
                    <h2 class="section-title"><?php echo $title;?></h2>
                <?php endif;?>
                <div class="main-about-text">
                    <div class="section-content">
                        <?php $APPLICATION->IncludeFile(
                                str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__) . '/content.php',
                                [],
                                [
                                    'SHOW_BORDER' => true,
                                    'MODE' => 'html'
                                ]
                        );?>
                    </div>
                </div>
                <?php if($linkHref && $linkText):?>
                    <div class="main-about-button">
                        <a href="<?php echo $linkHref;?>" class="btn btn-outline-primary"><?php echo $linkText;?></a>
                    </div>
                <?php endif;?>
            </div>
            <div class="main-about__col col-12 col-md-6">
                <a href="/360/" class="main-about-stats" target="_blank">
                    <div class="main-about-stats__number">
                        <img src="/images/360.jpg" alt="Виртуальный тур по мобильному комплексу" />
                    </div>
                    <?php if($statsText):?>
                        <div class="main-about-stats__text"><?php echo $statsText;?></div>
                    <?php endif;?>
                </a>
                <?php if($tg || $vk || $ok):?>
                    <ul class="main-about-social social nav">
                        <?php if($tg):?>
                            <li class="nav-item">
                                <a href="<?php echo $tg;?>" class="nav-link" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path fill-rule="evenodd" clip-rule="evenodd" d="M2.145 9.135c4.08-1.772 6.796-2.949 8.16-3.52 3.882-1.62 4.698-1.9 5.223-1.912.116 0 .373.023.547.163.14.117.175.268.199.385.023.117.046.361.023.548-.21 2.215-1.12 7.588-1.586 10.06-.198 1.049-.582 1.399-.955 1.434-.816.07-1.434-.537-2.215-1.05-1.236-.804-1.924-1.305-3.124-2.098-1.387-.909-.49-1.41.303-2.226.21-.21 3.788-3.474 3.858-3.765.012-.035.012-.175-.07-.245-.081-.07-.198-.047-.291-.024-.128.024-2.087 1.33-5.898 3.905-.56.385-1.061.572-1.516.56-.501-.012-1.457-.28-2.18-.513-.874-.28-1.573-.431-1.515-.92.035-.257.385-.514 1.037-.782z"/></svg>
                                </a>
                            </li>
                        <?php endif;?>
                        <?php if($vk):?>
                            <li class="nav-item">
                                <a href="<?php echo $vk;?>" class="nav-link" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M10.815 15.585c-5.74 0-9.015-3.935-9.15-10.483h2.874c.095 4.806 2.215 6.842 3.894 7.261v-7.26h2.707v4.145c1.658-.179 3.4-2.068 3.988-4.145h2.707c-.45 2.56-2.34 4.45-3.683 5.226 1.343.63 3.495 2.277 4.313 5.257h-2.98c-.64-1.994-2.235-3.536-4.345-3.746v3.746h-.325z"/></svg>
                                </a>
                            </li>
                        <?php endif;?>
                        <?php if($ok):?>
                            <li class="nav-item">
                                <a href="<?php echo $ok;?>" class="nav-link" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9674 11.7188C13.752 11.6115 12.6928 11.0929 12.4953 11.0212C12.2978 10.9497 12.1542 10.914 12.0106 11.1285C11.8669 11.3432 11.4541 11.8262 11.3284 11.9693C11.2027 12.1123 11.0771 12.1303 10.8616 12.0229C10.6462 11.9156 9.952 11.6892 9.12911 10.9587C8.48867 10.3902 8.05627 9.68806 7.93063 9.47341C7.80495 9.25875 7.91719 9.14272 8.02505 9.03583C8.122 8.93976 8.24053 8.78538 8.34823 8.66017C8.45597 8.53501 8.49185 8.44552 8.56367 8.3025C8.63548 8.15936 8.59959 8.0342 8.54568 7.92689C8.49185 7.81958 8.06098 6.76417 7.88147 6.33483C7.70659 5.91679 7.52898 5.97341 7.39673 5.96678C7.27121 5.96057 7.12742 5.95925 6.98384 5.95925C6.84021 5.95925 6.60679 6.01291 6.4093 6.22752C6.21185 6.44217 5.65529 6.96093 5.65529 8.01621C5.65529 9.07162 6.42724 10.0911 6.53498 10.2342C6.64272 10.3774 8.05412 12.543 10.2153 13.4717C10.7293 13.6927 11.1306 13.8246 11.4435 13.9234C11.9596 14.0866 12.4293 14.0635 12.8005 14.0083C13.2144 13.9468 14.0751 13.4897 14.2547 12.9889C14.4342 12.4879 14.4342 12.0587 14.3803 11.9693C14.3265 11.8798 14.1828 11.8262 13.9674 11.7188ZM10.0365 17.0605H10.0336C8.7476 17.06 7.48632 16.7161 6.38602 16.0663L6.12432 15.9117L3.41199 16.6198L4.13594 13.988L3.96557 13.7181C3.24819 12.5826 2.86929 11.2701 2.86986 9.92246C2.87144 5.99011 6.08633 2.79084 10.0393 2.79084C11.9535 2.7915 13.7528 3.53433 15.1059 4.88249C16.4589 6.23056 17.2036 8.02251 17.2029 9.92822C17.2013 13.8609 13.9864 17.0605 10.0365 17.0605ZM16.1357 3.8581C14.5078 2.23613 12.3429 1.3425 10.0364 1.34155C5.28391 1.34155 1.41597 5.19075 1.41406 9.92193C1.41344 11.4343 1.81046 12.9105 2.565 14.2119L1.3418 18.6584L5.91257 17.4652C7.17195 18.1488 8.58988 18.5092 10.0329 18.5096H10.0365C14.7885 18.5096 18.6567 14.6601 18.6587 9.9288C18.6596 7.63595 17.7635 5.48004 16.1357 3.8581Z" />
                                    </svg>
                                </a>
                            </li>
                        <?php endif;?>
                    </ul>
                <?php endif;?>

                <div class="btn-know-more reasontobuy-swiper-btn-container">
                    <div class="btn-border-container">
                        <div class="btn-border-bg">
                            <div class="btn-border-bg-item">

                            </div>
                        </div>
                    </div>
                    <div class="btn-border-shodow-container">
                        <div class="btn-shodow-bg">
                            <div class="btn-shodow-bg-item"></div>
                        </div>
                    </div>
                    <div class="reasontobuy-swiper-btns call_form">
                        Узнай требования к помещениям МРТ, КТ
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>