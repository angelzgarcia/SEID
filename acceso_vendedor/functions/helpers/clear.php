<?php

function clearEntry($entry)
{
    if (!isset($entry) || empty($entry)) return false;

    if (is_numeric($entry)) return strpos($entry, '.') !== false ? (float)$entry : (int)$entry;

    $entry = trim($entry);
    $entry = stripslashes($entry);
    $entry = htmlspecialchars($entry);
    $entry = str_ireplace("SELECT * FROM", "", $entry);
    $entry = str_ireplace("DELETE FROM", "", $entry);
    $entry = str_ireplace("INSERT INTO", "", $entry);
    $entry = str_ireplace("SELECT *", "", $entry);
    $entry = str_ireplace("UPDATE", "", $entry);
    $entry = str_ireplace("<script src>", "", $entry);
    $entry = str_ireplace("<script type>", "", $entry);
    $entry = str_ireplace("</script>", "", $entry);
    $entry = str_ireplace("<script>", "", $entry);
    $entry = str_ireplace("<link>", "", $entry);
    $entry = str_ireplace("</link>", "", $entry);
    $entry = str_ireplace("<?php", "", $entry);
    $entry = str_ireplace("?>", "", $entry);
    $entry = str_ireplace("<?=", "", $entry);
    $entry = str_ireplace("<?echo", "", $entry);
    $entry = str_ireplace("~", "", $entry);
    $entry = str_ireplace("``", "", $entry);
    $entry = str_ireplace("||", "", $entry);
    $entry = str_ireplace("&&", "", $entry);
    $entry = str_ireplace("===", "", $entry);
    $entry = str_ireplace("!=", "", $entry);
    $entry = str_ireplace("<", "", $entry);
    $entry = str_ireplace(">", "", $entry);
    $entry = str_ireplace("^", "", $entry);
    $entry = str_ireplace("[", "", $entry);
    $entry = str_ireplace("]", "", $entry);
    $entry = str_ireplace("{", "", $entry);
    $entry = str_ireplace("}", "", $entry);

    return strtolower($entry);
}
