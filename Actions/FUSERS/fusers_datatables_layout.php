<?php
/*
 * @author Anakeen
 * @license http://www.fsf.org/licensing/licenses/agpl-3.0.html GNU Affero General Public License
 * @package FDL
*/

include_once ("FDL/freedom_util.php");
/**
 * Set layout for fusers datatables
 * @param Action $action
 */
function fusers_datatables_layout(Action & $action)
{
    $type = $action->getArgument("type");
    $group = $action->getArgument("group");
    $displayLength = $action->getParam("FUSERS_DISPLAYLENGTH", "10");
    $thead = array();
    $list = array();
    switch ($type) {
        case "user":
            $thead = array(
                array(
                    "id" => "us_login",
                    "name" => _("login") ,
                    "value" => ""
                ) ,
                array(
                    "id" => "us_lname",
                    "name" => _("lastname") ,
                    "value" => ""
                ) ,
                array(
                    "id" => "us_fname",
                    "name" => _("firstname") ,
                    "value" => ""
                ) ,
                array(
                    "id" => "us_mail",
                    "name" => _("mail") ,
                    "value" => ""
                )
            );
            $list = getButtonList($action, "IUSER");
            break;

        case "role":
            $thead = array(
                array(
                    "id" => "title",
                    "name" => _("label") ,
                    "value" => ""
                )
            );
            $list = getButtonList($action, "ROLE");
            break;

        case "group":
            $thead = array(
                array(
                    "id" => "us_login",
                    "name" => _("login") ,
                    "value" => ""
                ) ,
                array(
                    "id" => "grp_name",
                    "name" => _("desc") ,
                    "value" => ""
                )
            );
            $list = getButtonList($action, "IGROUP");
            break;
    }
    
    $action->lay->setBlockData("thead", $thead);
    $action->lay->set("fuserType", $type);
    $action->lay->set("fuserGroup", $group);
    $action->lay->set("fuserDisplayLength", $displayLength);
    $action->lay->set("style", (count($list) <= 0 ? "display:none;" : ""));
    $action->lay->setBlockData("urgtype", $list);
}

function getButtonList(Action & $action, $famid)
{
    $list = array();
    $doc = new_Doc($action->dbaccess, $famid);
    $infos = $doc->getChildFam(-1, true);
    foreach ($infos as $info) {
        $list[] = array(
            "id" => $info["id"],
            "title" => $info["title"],
            "imgsrc" => $action->parent->getImageLink($info["icon"], true, 14)
        );
    }
    $action->lay->set("idmain", $doc->getPropertyValue("id"));
    $action->lay->set("titlemain", $doc->getTitle());
    $action->lay->set("imgsrcmain", $doc->getIcon("", 14));
    return $list;
}