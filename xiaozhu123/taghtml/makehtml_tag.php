<?php
require_once(dirname(__FILE__)."/../config.php");

if ($action == 'search') {
    $search_word = trim($search_word);
    $search_style = intval($search_style);
    $addsql = '';
    if (!empty($search_word)) {
        if ($search_style == 0) {
            $addsql = " where `tag` like '%{$search_word}%' ";
        } else {
            $addsql = " where `tag` like '{$search_word}' ";
        }
    }
} else {
    $search_word = '';
    $search_style = '0';
}
include('templets/makehtml_tag.htm');

?>
