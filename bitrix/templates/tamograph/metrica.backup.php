<?php
$metriks = [
'ekb' => '90772206',
'kzn' => '90772237',
'krd' => '90772220',
'msk' => '90772172',
'nn' => '90772248',
'rnd' => '90772267',
'spb' => '90772292',
'chlb' => '90772190',
'nsk' => '90772260',
'smr' => '90772278',

];


$a = explode( '.', $_SERVER['HTTP_HOST'] );
$m = '';

if ( !empty( $metriks[ $a[0] ] ) ){
$m = $metriks[ $a[0] ];
}else{
$m = '88017604';
}

echo '
<!— Yandex.Metrika counter —>
<script type="text/javascript" >
(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
ym(' . $m . ', "init", {
clickmap:true,
trackLinks:true,
accurateTrackBounce:true,
webvisor:true
});
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/53693806" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!— /Yandex.Metrika counter —>
';

?>
