<?php
$z[0]=Array("global","",233,261);
$z[0][4]=array();
$z[0][4]['name']="cfg_soft_lang";
$z[1]=Array("sql","\n\n<title>[field:array runphp=yes]\n@me = (empty(@me['title']) ? \"{@me['tag']}\" : \"{@me['title']}\");\n[/field:array]</title>\n<meta name=\"keywords\" content=\"[field:array runphp=yes]\n@me = (empty(@me['keywords']) ? \"��ҵ20������רҵ�о�-{@me['tag']}����˾��Ҫ��Ʒ�У������ϴ����á����������ıá�{@me['tag']}�����Ͻ�á������á��ķ��á��͸�ʴ���ıã�רҵ��������ʦ����Ϊ���ṩ{@me['tag']}��ѡ�ͱ���\n\" : \"{@me['keywords']}\");\n[/field:array]\" />\n<meta name=\"description\" content=\"[field:array runphp=yes]\n@me = (empty(@me['description']) ? \"��ҵ20������רҵ�о�-{@me['tag']}����˾��Ҫ��Ʒ�У������ϴ����á����������ıá�{@me['tag']}�����Ͻ�á������á��ķ��á��͸�ʴ���ıã�רҵ��������ʦ����Ϊ���ṩ{@me['tag']}��ѡ�ͱ���\n\" : \"{@me['description']}\");\n[/field:array]\" />\n\n ",267,1101);
$z[1][4]=array();
$z[1][4]['sql']="select * from #@__tagindex where id=~id~";
$z[2]=Array("global","",1116,1148);
$z[2][4]=array();
$z[2][4]['name']="cfg_templets_skin";
$z[3]=Array("global","",1277,1302);
$z[3][4]=array();
$z[3][4]['name']="cfg_cmsurl";
$z[4]=Array("include","",1370,1405);
$z[4][4]=array();
$z[4][4]['filename']="head.htm";
$z[5]=Array("global","",1544,1569);
$z[5][4]=array();
$z[5][4]['name']="cfg_cmsurl";
$z[6]=Array("field","",1622,1642);
$z[6][4]=array();
$z[6][4]['name']="title";
$z[7]=Array("list","\n				<li>\n      				[field:array runphp='yes']@me = (empty(@me['litpic']) ? \"\" : \"<a href='{@me['arcurl']}' class='preview'><img src='{@me['litpic']}'/></a>\"); [/field:array]\n					<a href=\"[field:arcurl/]\" class=\"title\">[field:title/]</a>\n					<span class=\"info\">\n						<small>���ڣ�</small>[field:pubdate function=\"GetDateTimeMK(@me)\"/]\n						<small>�����</small>[field:click/]\n						<small>������</small>[field:scores/]\n					</span>\n					<p class=\"intro\">\n						[field:description/]...\n					</p>\n				</li>\n",1710,2275);
$z[7][4]=array();
$z[7][4]['orderby']="sortrank";
$z[7][4]['pagesize']="12";
$z[8]=Array("pagelist","",2376,2447);
$z[8][4]=array();
$z[8][4]['listitem']="info,index,end,pre,next,pageno";
$z[8][4]['listsize']="5";
$z[9]=Array("mda","",2621,2646);
$z[9][4]=array();
$z[9][4]['name']="728x90";
$z[10]=Array("include","",2653,2690);
$z[10][4]=array();
$z[10][4]['filename']="footer.htm";

?>