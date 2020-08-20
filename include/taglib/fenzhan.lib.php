<?php   if(!defined('DEDEINC')) exit('Request Error!');
require_once(DEDEINC.'/arc.partview.class.php');
function lib_fenzhan(&$ctag,&$refObj)
{
    global $dsql,$envs,$cfg_basehost,$makehtml;
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);
    $innertext = trim($ctag->GetInnerText());
    $dsql->SetQuery("Select * From `#@__district`  where level=1");
    $dsql->Execute();
    $artlist='';
    while($row = $dsql->GetArray()) {
    $ids[] = $row;
    }
    if(!isset($ids[0])) return '';
    $GLOBALS['itemindex'] = 0;
    $GLOBALS['itemparity'] = 1;
    $sys=$dsql->getone("select * from #@__fenzhan");
    $urltype=$sys['urltype'];
    if($makehtml=='m'){
        $urltype="/m/".$sys['urltype'];
    }
    for($i=0;isset($ids[$i]);$i++)
    {
        $GLOBALS['itemindex']++;
        $pv = new PartView($ids[$i]['id']);
        $pv->Fields['typename'] =$ids[$i]['district'];
        if($urltype=='1'){
            $pv->Fields['typeurl']=$cfg_basehost.$sys['position'].$ids[$i]['name'].".html";
        }else{
            $pv->Fields['typeurl']=$cfg_basehost.$sys['position'].$ids[$i]['name']."/";
        }
        $pv->SetTemplet($innertext,'string');
        $artlist .= $pv->GetResult();
        $GLOBALS['itemparity'] = ($GLOBALS['itemparity']==1 ? 2 : 1);
    }
    //注销环境变量，以防止后续调用中被使用
    $GLOBALS['envs']['typeid'] = $_sys_globals['typeid'];
    $GLOBALS['envs']['reid'] = '';
    return $artlist;
}
