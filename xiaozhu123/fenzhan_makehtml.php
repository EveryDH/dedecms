<?php
/**
 * 生成首页
 *
 * @version        $Id: makehtml_homepage.php 2 9:30 2010-11-11 tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/../include/common.inc.php");
if(!islogin()){
	showmsg('请登录后操作',-1);
	die;
}
require_once(DEDEINC."/arc.partview.class.php");
if(empty($dopost)) $dopost = '';
$row  = $dsql->GetOne("SELECT * FROM #@__fenzhan");
$row['templetm']=str_replace('.htm','_m.htm',$row['templet']);
$row['templet_indexm']=str_replace('.htm','_m.htm',$row['templet_index']);
$row['powerby']=empty($row['powerby'])?$cfg_powerby:$row['powerby'];
if($act=='getstate'){
	helper('cache');
    $rs=getcache('makefenzhan','state');
    $rs++;
    if($rs>=100){
    	SetCache('makefenzhan','state','-1',10);
    }
    $rs=$rs<2?'-1':$rs;
    if($rs<0&& $id=='0'){
    	echo '1';
    }else{
    	echo $rs;
    }
    die;
}
if($dopost=="make")
{
    if($act=='save'){
        $remotepos = empty($remotepos)? '/index.html' : $remotepos;
        $isremote = empty($isremote)? 0 : $isremote;
        $serviterm = empty($serviterm)? "" : $serviterm;
        $homeFile = DEDEROOT."/".$position_index;
        $homeFile = str_replace("\\","/",$homeFile);
        $homeFile = str_replace("//","/",$homeFile);
        $iquery = "UPDATE `#@__fenzhan` SET 
        `title`='$title',
        `keyword`='$keyword',
        `desc`='$desc',
        `powerby`='$powerby',
        `templet_index`='$templet_index',`position_index`='$position_index',`templet`='$templet',`position`='$position',`urltype`='$urltype'";
        if($dsql->ExecuteNoneQuery($iquery)){
            showmsg('保存成功',"fenzhan_makehtml.php");exit;
        }
        die;
    }
    ini_set('memory_limit', '512M');
    helper('cache');
    if(getcache('makefenzhan','state')>'-1'){
    	echo $rs;
    	exit;
    }
    $row=$dsql->getone("select * from #@__fenzhan where id=1");
    $homeFile = DEDEROOT."/".$row['position_index'];
    $homeFile = str_replace("\\","/",$homeFile);
    $homeFile = str_replace("//","/",$homeFile);
    $cfg_webname2=$cfg_webname;
    $cfg_keywords2=$cfg_keywords;
    $cfg_description2=$cfg_description;
    $templet = str_replace("{style}", $cfg_df_style, $templet);
    if($makehtml=='m'){
        mkdir(DEDEROOT.'/m'.$position);
    	$templet =str_replace('.htm','_m.htm',$templet);
    }else{
         mkdir(DEDEROOT.$position);
    }
    $files=array();
    $dsql->SetQuery("Select * from #@__district limit 0,500");
    $dsql->Execute();
    while($row2 = $dsql->GetArray()){
        $py=GetPinyin(stripslashes($row2['district']));//城市拼音
        $py=$row2['name'];
        $province=$row2['district'];
        if($row2['level']>'1'){
            $province=getprovince($row2['pid']);
        }
        $suffix=$suffix2='.html';
        if($urltype=='0'){
           $suffix="/index.html";
           $suffix2="/";
        }
        $filedir=DEDEROOT.$position.$py;
        if($makehtml=='m'){
            $filedir=DEDEROOT.'/m'.$position.$py;
        }
        if($urltype=='0'){
            is_dir($filedir)?"":mkdir($filedir);
        }
        $file.=$filedir.$suffix;
        $url=$cfg_basehost.$position.$py.$suffix2;
        $murl=$cfg_basehost.'/m'.$position.$py.$suffix2;
        $find=array('{城市名}','{地区}','{地区名}','{xx}','{XX}');
        $files[]=array(
        	'py'=>$py,
        	'cfg_city'=>$row2['district'],
        	'cfg_webname'=>str_replace($find,$row2['district'],$row['title']),
        	'cfg_keywords'=>str_replace($find,$row2['district'],$row['keyword']),
        	'cfg_description'=>str_replace($find,$row2['district'],$row['desc']),
        	'cfg_powerby'=>str_replace($find,$row2['district'],$row['powerby']),
        	'file'=>$file,
        	'url'=>$url,
        	'murl'=>$murl,
            'cid'=>$row2['pid'],
            'cfg_province'=>$province,
        );
        $file='';
    }
    helper('cache');
    SetCache('makefenzhan','state',0,time()-3600);
    $htmlcount=count($files);
    for($i=0;$i<$htmlcount;$i++){
        $rs=getjindu($i,$htmlcount);
        SetCache('makefenzhan','state',$rs,10);
        $v=$files[$i];
        $GLOBALS['cfg_city']=$cfg_city=$v['cfg_city'];
        $cfg_webname=$v['cfg_webname'];
        $cfg_keywords=$v['cfg_keywords'];
        $cfg_description=$v['cfg_description'];
        $cfg_powerby=$v['cfg_powerby'];
        $cfg_url=$url=$v['url'];
        $murl=$v['murl'];
        $cfg_province=$v['cfg_province'];
        if(!empty($v['file'])){
            $pv = new PartView();
            $cid=$v['cid'];
            $pv->SetTemplet($cfg_basedir.$cfg_templets_dir."/".$templet);
            $pv->SaveToHtml($v['file']);
            unset($pv);
        }
    }
    $cfg_webname=$cfg_webname2;
    $cfg_keywords=$cfg_keywords2;
    $cfg_description=$cfg_description2;
    if($makehtml=='m'){
    	$templet_index =str_replace('.htm','_m.htm',$templet_index);
    	$url=$cfg_basehost.'/m'.$position_index.".html";
    	$homeFile=DEDEROOT."/m/".$position_index;
    }
    $murl=$cfg_basehost."/m".$position_index;
    $pv = new PartView();
    $pv->SetTemplet($cfg_basedir.$cfg_templets_dir."/".$templet_index);
    $pv->SaveToHtml($homeFile);
    echo "成功更新分站html以及分站主页HTML：".$homeFile."<br /><a href='{$position_index}' target='_blank'>浏览分站主页...</a><br />";
    SetCache('makefenzhan','state','',time()-3600);
    exit();
}
function getjindu($i,$all){
  $rs=intval($i/$all*100);
  return $rs;
}
include ('templets/fenzhan_makehtml.htm');
function islogin(){
  global $dsql,$cfg_cookie_encode;
  $pwd=substr(md5($cfg_cookie_encode."1"),0, 16);
  if(empty($_COOKIE['DedeUserID']) || empty($_COOKIE['DedeUserID__ckMd5'])){
    return false;
  }
  if($pwd<>$_COOKIE['DedeUserID__ckMd5']){
    return false;
  }
  return true;//正常返回
}
function getprovince($id){
    global $dsql;
    $row=$dsql->getone("select district from #@__district where id=$id");
    return $row['district'];
}
