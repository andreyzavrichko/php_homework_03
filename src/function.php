<?php
function task1(string $fileName)
{
    $fileData = file_get_contents($fileName);
    $purchaseOrderData = new SimpleXMLElement($fileData);
    $orderNumber = $purchaseOrderData->attributes()->PurchaseOrderNumber;
    $orderDate = $purchaseOrderData->attributes()->OrderDate;
    $deliveryNotes = $purchaseOrderData->DeliveryNotes->__toString();
    echo "<h2> Purchase order №$orderNumber</h2>";
    echo "<p>Order date: $orderDate</p>";
    echo "<p><b>DeliveryNotes:</b> <i>$deliveryNotes</i></p>";
    echo '<table border="1" bordercolor="#ccc" cellspacing="0" cellpadding="12" width="600">' .
        '<tr height="30">' .
        '<th align="center">Product name</th>' .
        '<th align="center">Quantity</th>' .
        '<th align="center">US price</th>' .
        '<th align="center">Comment</th>' .
        '</tr>';
    foreach ($purchaseOrderData->Items->Item as $item) {
        echo '<tr>' .
            '<td>' . $item->ProductName->__toString() . '</td>' .
            '<td>' . $item->Quantity->__toString() . '</td>' .
            '<td>' . $item->USPrice->__toString() . '</td>' .
            '<td>' . $item->Comment->__toString() . '</td>' .
            '</tr>';
    }
    echo '</table>';
    echo '<div style="display: flex; margin-top: 20px;" >';
    foreach ($purchaseOrderData->Address as $address) {
        echo '<table cellpadding="8" border="1" bordercolor="#ccc" cellspacing="0">'.
            '<tr>' .
            '<td colspan="2">' . '<b>' . $address->attributes()->Type . '</b>' . '</td>' .
            '</tr>' .
            '<tr>' .
            '<td width="60">' . 'Name:' . '</td>' .
            '<td width="200">' . $address->Name->__toString() . '</td>' .
            '</tr>' .
            '<tr>' .
            '<td width="60">' . 'Street:' . '</td>' .
            '<td width="200">' . $address->Street->__toString() . '</td>' .
            '</tr>' .
            '<tr>' .
            '<td width="60">' . 'City:' . '</td>' .
            '<td width="200">' . $address->City->__toString() . '</td>' .
            '</tr>' .
            '<tr>' .
            '<td width="60">' . 'State:' . '</td>' .
            '<td width="200">' . $address->State->__toString() . '</td>' .
            '</tr>' .
            '<tr>' .
            '<td width="60">' . 'Zip:' . '</td>' .
            '<td width="200">' . $address->Zip->__toString() . '</td>' .
            '</tr>' .
            '<tr>' .
            '<td width="60">' . 'Country:' . '</td>' .
            '<td width="200">' . $address->Country->__toString() . '</td>' .
            '</tr>' .
            '</table>';
    }
    echo '</div>';
}