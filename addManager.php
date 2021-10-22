<?php

/** Execute this code only for binding manager and LPU */
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");


$filter = [
    "ACTIVE" => "Y",
    "IBLOCK_ID" => 5,
    "SECTION_ID" => [3062, 3064, 3065]
];

$dbRes = CIBlockSection::GetList(array(), $filter, false, array("ID", "NAME", "UF_LPU_MANAGER"));
while ($section = $dbRes->GetNext()) {
    $res[$section["NAME"]] = $section;
}
pretty_print($res, false);


$dbLPU = CIBlockElement::GetList(array("SORT" => "ASC"), array("IBLOCK_ID" => 76), false, false, array("NAME", "PROPERTY_LPU_MANAGER_ID"));


while ($lpu = $dbLPU->GetNext()) {

    $resLPU[$lpu["NAME"]] = $lpu["PROPERTY_LPU_MANAGER_ID_VALUE"];
}

$lpuWidthMan = [];
foreach ($resLPU as $key => $value) {
    $res[$key]["UF_LPU_MANAGER"] = $value;
}
$filterred = array_filter($res, function ($k) {
    return $k["UF_LPU_MANAGER"];
});


foreach ($filterred as $key => $value) {
    if (!$resLPU[$key]) $check[$key] = $value;
}

function lpuUpdate($check = [])
{
    foreach ($check as $key => $value) {

        $bs = new CIBlockSection;
        $arFields = array(
            "IBLOCK_ID" => 5,
            "UF_LPU_MANAGER" => $value["UF_LPU_MANAGER"]
        );
        $bs->Update($value["ID"], $arFields);
    }
}
//lpuUpdate($filterred);





