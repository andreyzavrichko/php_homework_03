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

function task2()
{
    echo '<pre>';


    $outputArray = [
        'users' => [
            [
                'id' => '01',
                'name' => 'Vasya',
                'email' => 'vasia@mail.ru',
                'phone' => '+4564523154',
                'addFriend' => false,
            ],
            [
                'id' => '02',
                'name' => 'Dima',
                'email' => 'dima@mail.ru',
                'phone' => '+85642154',
                'addFriend' => false,
            ],
            [
                'id' => '03',
                'name' => 'Marina',
                'email' => 'marina@mail.ru',
                'phone' => '+9655421321',
                'addFriend' => false,
            ],
        ]
    ];

    file_put_contents('output.json', json_encode($outputArray));

    $fileJsonOutput = file_get_contents('output.json');
    $outputData = json_decode($fileJsonOutput, true);

    $outputArray2['users'] = array_map(function ($user) {
        $user['AddFriend'] = rand(0, 1) ? true : false;

        return $user;
    }, $outputData['users']);

    file_put_contents('output2.json', json_encode($outputArray2));

    $fileJsonOutputOne = file_get_contents('output.json');
    $fileJsonOutputTwo = file_get_contents('output2.json');
    $outputDataOne = json_decode($fileJsonOutputOne, true);
    $outputDataTwo = json_decode($fileJsonOutputTwo, true);

    function diffArray(array $firstArray, array $secondArray)
    {
        $resultDiffArray = [];
        foreach ($firstArray as $key => $value) {
            if (is_array($value)) {
                $new = diffArray($value, $secondArray[$key]);
                if ($new) {
                    $resultDiffArray[$key] = $new;
                }
            } else {
                $diff = array_diff($secondArray, $firstArray);
                if ($diff) {
                    return $diff;
                }
            }
        }
        return $resultDiffArray;
    }
    var_export(diffArray($outputDataOne, $outputDataTwo));
    echo '</pre>';
}

function task3()
{
    $arraySomeNumbers = [];
    for ($i = 0; $i < 50; $i++) {
        $arraySomeNumbers[] = mt_rand(1, 100);
    }

    $newCSVFile = fopen('numbers.csv', 'w');
    fputcsv($newCSVFile, $arraySomeNumbers, ';');
    fclose($newCSVFile);

    $newCSVFile = fopen('numbers.csv', 'r');
    while (($line = fgetcsv($newCSVFile, 0, ";")) !== false) {
        $arrayFromCsv = $line;
    }

    $sum = array_reduce($arrayFromCsv, function ($result, $value) {
        return $value % 2 === 0 ? $result + $value : $result;
    }, 0);

    echo '<pre>Сумма четных чисел из csv файла равна: <b>' . $sum . '</b></pre>';
}