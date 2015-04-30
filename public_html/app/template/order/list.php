<?php foreach($params["ITEMS"] as $arItem):?>
    <paper-card on-buy-tap="{{handleBuy}}" orderid="<?=$arItem["ID"]?>" button="true" id="card_order_<?=$arItem["ID"]?>">

        <h2><?= $arItem["NAME"]?></h2>
        <p><?= $arItem["DESCR"]?></p>
        <h1><?= number_format($arItem["PRICE"],0,""," ")." ".$CONFIG["main"]["currency"];?></h1>
        <h3><?= number_format($arItem["NEW_PRICE"],0,""," ")." ".$CONFIG["main"]["currency"];?></h3>
        <form id="order_<?=$arItem["ID"]?>" method="post" action="/order/close" is="ajax-form">
            <input type="hidden" name="data[orderId]" value="<?=$arItem["ID"]?>"/>
            <input type="hidden" name="data[seller]" value="<?=$arItem["SELLER"]?>"/>
            <input type="hidden" name="data[buyer]" value="<?=$USER["ID"]?>"/>
            <input type="hidden" name="data[price]" value="<?=$arItem["PRICE"]?>"/>
            <input type="hidden" name="data[csrf_token]" value="<?=$arItem["csrf_token"]?>"/>
        </form>
    </paper-card>
    <div class="content_order_<?=$arItem["ID"]?>"></div>
<?php endforeach; ?>
<core-animation id="fadeout" duration="500">
    <core-animation-keyframe>
        <core-animation-prop name="opacity" value="1"></core-animation-prop>
    </core-animation-keyframe>
    <core-animation-keyframe>
        <core-animation-prop name="opacity" value="0"></core-animation-prop>
    </core-animation-keyframe>
</core-animation>