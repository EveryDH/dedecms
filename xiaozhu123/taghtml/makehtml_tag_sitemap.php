<?php
/**
 * ����TAGS վ���ͼ
 */
require_once(dirname(__FILE__)."/../config.php");
CheckPurview('sys_MakeHtml');
require_once(DEDEINC."/arc.partview.class.php");

$tag_basedir = trim($GLOBALS['cfg_tag_basedir'],'/\ ');
$tag_basedir = empty($tag_basedir) ? 'tag' : $tag_basedir; 
$templet_file = $GLOBALS['cfg_basedir'].$GLOBALS['cfg_templets_dir']."/".$GLOBALS['cfg_df_style']."/tagmap.htm";
    
//$tagMap = DEDEADMIN."/../{$tag_basedir}/tag.xml";
$tagMap = $GLOBALS['cfg_basedir'].$GLOBALS['cfg_cmspath'].'/tag.xml';
$fp = fopen($tagMap,"w") or die("��ָ�����ļ��������⣬�޷������ļ�");
fclose($fp);	
    
$pv = new PartView();
$GLOBALS['_arclistEnv'] = 'index';
$pv->SetTemplet($templet_file);
$pv->SaveToHtml($tagMap);

echo "�ɹ�����TAG��ͼ��".$tagMap;
echo "<br/><br/><a href='{$GLOBALS['cfg_cmspath']}/tag.xml' target='_blank'>���...</a>";
    
