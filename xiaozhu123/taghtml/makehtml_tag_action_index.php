<?php
/**
 * 生成TAGS 首页
 */
require_once(dirname(__FILE__)."/../config.php");
CheckPurview('sys_MakeHtml');
require_once(DEDEINC."/arc.partview.class.php");
    $tag_basedir = trim($GLOBALS['cfg_tag_basedir'],'/\ ');
    $tag_basedir = empty($tag_basedir) ? 'tag' : $tag_basedir; 
    CreateDir($GLOBALS['cfg_cmspath'].'/'.$tag_basedir);
    
    $tagFile = DEDEADMIN."/../{$tag_basedir}/index.html";
	$fp = fopen($tagFile,"w") or die("你指定的文件名有问题，无法创建文件");
	fclose($fp);	
	
    $pv = new PartView();
	$GLOBALS['_arclistEnv'] = 'index';    
	$pv->SetTemplet($GLOBALS['cfg_basedir'].$GLOBALS['cfg_templets_dir']."/".$GLOBALS['cfg_df_style']."/tagindex.htm");  //打开TAG页模板
    $pv->SaveToHtml($tagFile);
	echo "成功更新TAG主页：".$tagFile;
	echo "<br/><br/><a href='../../{$tag_basedir}/index.html' target='_blank'>浏览...</a>";

