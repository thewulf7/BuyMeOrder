<?php foreach($params["ITEMS"] as $arItem):?>
    <paper-card orderid="<?=$arItem["ID"]?>">

        <h2><?= $arItem["NAME"]?></h2>
        <p><?= $arItem["DESCR"]?></p>
        <h1><?= number_format($arItem["PRICE"],2,"."," ")." ".$CONFIG["main"]["currency"];?></h1>
        <h3><?= number_format($arItem["NEW_PRICE"],2,"."," ")." ".$CONFIG["main"]["currency"];?></h3>
    </paper-card>

<?php endforeach; ?>
