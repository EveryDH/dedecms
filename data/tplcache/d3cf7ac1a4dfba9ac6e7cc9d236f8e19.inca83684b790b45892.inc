<?php
$z[0]=Array("title","",24,38);
$z[0][4]=array();
$z[1]=Array("arcurl","",57,72);
$z[1][4]=array();
$z[2]=Array("typename","",91,108);
$z[2][4]=array();
$z[3]=Array("pubdate","",130,197);
$z[3][4]=array();
$z[3][4]['function']="strftime(\"%a,%d%b%Y%H:%M:%S +0800\",@me)";
$z[4]=Array("array","@me = (strpos(@me['litpic'],'defaultpic') ? \"\": \"<a [email=href='%7B@me[%22arcurl%22]%7D']href='{@me[\"arcurl\"]}'[/email] target='_blank'><img [email=src='%7B@me[%22litpic%22]%7D']src='{@me[\"litpic\"]}'[/email] border='0' /><br />\"); ",231,503);
$z[4][4]=array();
$z[4][4]['runphp']="yes";
$z[5]=Array("description","",503,549);
$z[5][4]=array();
$z[5][4]['function']="html2text(@me)";

?>