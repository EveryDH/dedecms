<?php
/**
 * �Զ������޸�
 *
 * @version        $Id: mytag_edit.php 1 15:37 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require(dirname(__FILE__)."/config.php");
CheckPurview('temp_Other');
require_once(DEDEINC."/typelink.class.php");

if(empty($dopost)) $dopost = '';
$aid = intval($aid);
$ENV_GOBACK_URL = empty($_COOKIE['ENV_GOBACK_URL']) ? 'mytag_main.php' : $_COOKIE['ENV_GOBACK_URL'];

if($dopost=='delete')
{
    csrf_check();
    $dsql->ExecuteNoneQuery("DELETE FROM #@__mytag WHERE aid='$aid'");
    ShowMsg("�ɹ�ɾ��һ���Զ����ǣ�",$ENV_GOBACK_URL);
    exit();
}
else if($dopost=="saveedit")
{
    csrf_check();
    $starttime = GetMkTime($starttime);
    $endtime = GetMkTime($endtime);
    $query = "UPDATE `#@__mytag`
     SET
     typeid='$typeid',
     timeset='$timeset',
     starttime='$starttime',
     endtime='$endtime',
     normbody='$normbody',
     expbody='$expbody'
     WHERE aid='$aid' ";
    $dsql->ExecuteNoneQuery($query);
    ShowMsg("�ɹ�����һ���Զ����ǣ�",$ENV_GOBACK_URL);
    exit();
}
else if($dopost=="getjs")
{
    require_once(DEDEINC."/oxwindow.class.php");
    $jscode = "<script src='{$cfg_phpurl}/mytag_js.php?aid=$aid' language='javascript'></script>";
    $showhtml = "<xmp style='color:#333333;background-color:#ffffff'>\r\n\r\n$jscode\r\n\r\n</xmp>";
    $showhtml .= "<b>Ԥ����</b><iframe name='testfrm' frameborder='0' src='mytag_edit.php?aid={$aid}&dopost=testjs' id='testfrm' width='100%' height='250'></iframe>";
    $wintitle = "���Ƕ���-��ȡJS";
    $wecome_info = "<a href='mytag_main.php'><u>���Ƕ���</u></a>::��ȡJS";
    $win = new OxWindow();
    $win->Init();
    $win->AddTitle('����Ϊѡ�����ǵ�JS���ô��룺');
    $winform = $win->GetWindow('hand', $showhtml);
    $win->Display();
    exit();
}
else if($dopost=="testjs")
{
    echo "<body bgcolor='#ffffff'>";
    echo "<script src='{$cfg_phpurl}/mytag_js.php?aid=$aid&nocache=1' language='javascript'></script>";
    exit();
}
$row = $dsql->GetOne("SELECT * FROM `#@__mytag` WHERE aid='$aid'");
include DedeInclude('templets/mytag_edit.htm');