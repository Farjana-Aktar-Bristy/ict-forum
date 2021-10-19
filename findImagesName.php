<?php
function findAttachedImagesToPost($string) {
    $start = 'src="ckeditor/uploads/';
    $end = '"';
    $strArray = array();
    $newString = " " . $string;
    while (TRUE) {
        $ini = strpos($newString, $start);
        if ($ini == 0)
            break;
        $ini += strlen($start);
        $len = strpos($newString, $end, $ini) - $ini;
        array_push($strArray, substr($newString, $ini, $len));
        $startIndex = $ini + $len + 1;
        $lastIndex = strlen($string) - 1;
        $newString = substr($newString, $startIndex, $lastIndex);
    }
    return $strArray;
}
?>