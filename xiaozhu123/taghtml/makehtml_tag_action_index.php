<?php
/**
 * ����TAGS ��ҳ
 */
require_once(dirname(__FILE__)."/../config.php");
CheckPurview('sys_MakeHtml');
require_once(DEDEINC."/arc.partview.class.php");
    $tag_basedir = trim($GLOBALS['cfg_tag_basedir'],'/\ ');
    $tag_basedir = empty($tag_basedir) ? 'tag' : $tag_basedir; 
    CreateDir($GLOBALS['cfg_cmspath'].'/'.$tag_basedir);
    
    $tagFile = DEDEADMIN."/../{$tag_basedir}/index.html";
	$fp = fopen($tagFile,"w") or die("��ָ�����ļ��������⣬�޷������ļ�");
	fclose($fp);	
	
    $pv = new PartView();
	$GLOBALS['_arclistEnv'] = 'index';    
	$pv->SetTemplet($GLOBALS['cfg_basedir'].$GLOBALS['cfg_templets_dir']."/".$GLOBALS['cfg_df_style']."/tagindex.htm");  //��TAGҳģ��
    $pv->SaveToHtml($tagFile);
	echo "�ɹ�����TAG��ҳ��".$tagFile;
	echo "<br/><br/><a href='../../{$tag_basedir}/index.html' target='_blank'>���...</a>";

