<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
?>
<html>
<head>

</head>
<body>
    <div class="container">
        <table class="tg" style="width: 100%">
            <tr>
                <td class="tg-yw4l">ИНН <?= $details->detailsParam2 ?></td>
                <td class="tg-yw4l">КПП <?= $details->detailsParam3 ?></td>
                <td class="tg-yw4l" rowspan="2">Сч. №</td>
                <td class="tg-yw4l" rowspan="2"><?= $details->detailsParam19 ?></td>
            </tr>
            <tr>
                <td class="tg-yw4l" colspan="2">Получатель<br /><?= $details->detailsFullName ?></td>
            </tr>
            <tr>
                <td class="tg-yw4l" colspan="2" rowspan="2">Банк получателя<br /> <?= $details->detailsParam12 ?></td>
                <td class="tg-yw4l">БИК</td>
                <td class="tg-yw4l" rowspan="2"><?= $details->detailsParam15 ?><br /><br /><?= $details->detailsParam14 ?></td>
            </tr>
            <tr>
                <td class="tg-yw4l">Сч. №</td>
            </tr>
        </table>
        <h1>Счет № <?= $order->orderNum ?> от <?= $order->date ?></h1>
        <hr />
        <br />
        <table class = "t2">
            <tr>
                <td style="width: 120px">Поставщик:</td>
                <td>ИНН <?= $details->detailsParam2 ?>/<?= $details->detailsParam3 ?> КПП <?= $details->detailsShortName ?>, <?= $details->detailsParam8 ?>, <?= $details->detailsParam16 ?></td>
            </tr>
            <tr>
                <td>Покупатель:</td>
                <td>ИНН <?= $order->company->companyParam2 ?>/<?= $order->company->companyParam3 ?> КПП <?= $order->company->shortName ?>, <?= $order->company->companyParam6 ?>, <?= $order->company->companyParam17 ?> </td>
            </tr>
        </table>
        <br />
        <br />
        <table class="t3" style="width: 100%">
            <thead>
                <tr>
                    <td class="ca"  style="width: 50px">№</td>
                    <td class="ca">Наименование<br />товара</td>
                    <td class="ca"  style="width: 50px">Единица<br />изме-<br />рения</td>
                    <td class="ca"  style="width: 50px">Коли-<br />чество</td>
                    <td class="ca"  style="width: 130px">Цена</td>
                    <td class="ca"  style="width: 130px">Сумма</td>
                </tr>
            </thead>
            <tfoot>
            <tr>
                <td class="nb"></td>
                <td class="nb"></td>
                <td class="nb"></td>
                <td class="nb"></td>
                <td class="nb ra"><b>Итого:</b></td>
                <td class="ra"><?= Yii::$app->formatter->asDecimal($order->total, 2) ?></td>
            </tr>
            <tr>
                <td class="nb"></td>
                <td class="nb"></td>
                <td class="nb"></td>
                <td class="nb"></td>
                <td class="nb ra"><b>Итого НДС:</b></td>
                <td class="ra"><?= Yii::$app->formatter->asDecimal($order->tax, 2) ?></td>
            </tr>
            <tr>
                <td class="nb"></td>
                <td class="nb"></td>
                <td class="nb"></td>
                <td class="nb"></td>
                <td class="nb ra"><b>Всего к оплате:</b></td>
                <td class="ra"><?= Yii::$app->formatter->asDecimal($order->total, 2) ?></td>
            </tr>
            <tr>
                <? if ($empty): ?>
                    <td colspan="6" class="nb">
                <? else: ?>
                    <td colspan="6" class="nb sign">
                <? endif ?>
                    <p>Всего наименований <?= count($order->goods) ?>, на сумму <?= Yii::$app->formatter->asDecimal($order->total, 2) ?></p><br />
                    <p>Руководитель предприятия_____________________________________(<?= $details->detailsParam11 ?>)</p><br />
                    <p>Главный бухгалтер_____________________________________________(<?= $details->detailsParam18 ?>)</p><br /><br /><br /><br /><br /><br /><br />
                </td>
            </tr>
            </tfoot>
            <tbody>
            <? foreach($order->goods as $key => $item): ?>
                <tr>
                    <td class="ra"><?= $key + 1 ?></td>
                    <td><?= $item->name ?></td>
                    <td class="ca"><?= $item->unitArr[$item->unit] ?></td>
                    <td class="ra"><?= $item->quantity ?></td>
                    <td class="ra"><?= Yii::$app->formatter->asDecimal($item->cost, 2) ?></td>
                    <td class="ra"><?= Yii::$app->formatter->asDecimal($item->total, 2) ?></td>
                </tr>
            <? endforeach ?>
            </tbody>
        </table>
    </div>
</body>
</html>