<?php
require_once(dirname(__FILE__)."/../config.php");
CheckPurview('sys_Edit');

$configfile = DEDEDATA.'/config.cache.inc.php';

//更新配置函数
function ReWriteConfig()
{
    global $dsql,$configfile;
    if(!is_writeable($configfile))
    {
        echo "配置文件'{$configfile}'不支持写入，无法修改系统配置参数！";
        exit();
    }
    $fp = fopen($configfile,'w');
    flock($fp,3);
    fwrite($fp,"<"."?php\r\n");
    $dsql->SetQuery("SELECT `varname`,`type`,`value`,`groupid` FROM `#@__sysconfig` ORDER BY aid ASC ");
    $dsql->Execute();
    while($row = $dsql->GetArray())
    {
        if($row['type']=='number')
        {
            if($row['value']=='') $row['value'] = 0;
            fwrite($fp,"\${$row['varname']} = ".$row['value'].";\r\n");
        }
        else
        {
            fwrite($fp,"\${$row['varname']} = '".str_replace("'",'',$row['value'])."';\r\n");
        }
    }
    fwrite($fp,"?".">");
    fclose($fp);
}

if(empty($dopost))
{
    include('templets/tags_config.htm');
    exit();
}
/*
function update()
*/
else if($dopost == 'save')
{
    //if (!isset($tag_basedir) || !isset($tag_style)) {
		if (!isset($tag_basedir)||!isset($tag_basedir_m) || !isset($tag_style)) {
        ShowMsg('修改失败!','-1');
        exit;
    }
    $tag_basedir = trim($tag_basedir,'/\ ');
    $tag_basedir = empty($tag_basedir) ? 'tag' : $tag_basedir;
	
	//添加两条手机的tag目录设置
	$tag_basedir_m = trim($tag_basedir_m,'/\ ');
    $tag_basedir_m = empty($tag_basedir_m) ? '/m/tag' : $tag_basedir_m;
	
	
    $tag_style = intval($tag_style);
    $tag_style = $tag_style < 1 || $tag_style > 5 ? 1 : $tag_style;
    
    $dsql->ExecuteNoneQuery("UPDATE `#@__sysconfig` SET `value`='$tag_basedir' WHERE `varname`='cfg_tag_basedir'");
    $dsql->ExecuteNoneQuery("UPDATE `#@__sysconfig` SET `value`='$tag_style' WHERE `varname`='cfg_tag_style'");
	//手机的tag目录写入数据库
	$dsql->ExecuteNoneQuery("UPDATE `#@__sysconfig` SET `value`='$tag_basedir_m' WHERE `varname`='cfg_tag_basedir_m'");
    ReWriteConfig();
    ShowMsg("成功修改TAG优化设置!", 'tags_config.php');
    exit();
}

