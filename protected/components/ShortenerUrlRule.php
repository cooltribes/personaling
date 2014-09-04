<?php
class ShortenerUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';

    public function createUrl($manager,$route,$params,$ampersand)
    {
        if ($route==='look/view')
        {
            if (isset($params['id'], $params['ps_id']))
                return $params['id'] . '/' . $params['ps_id'];
            else if (isset($params['id']))
                return $params['id'];
        }
        return false;  // this rule does not apply
    }

    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
        if (preg_match('%^(l)(/([123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ]{5}))?$%', $pathInfo, $matches))
        {
            if ($matches[1]=="l"){
                $_GET['id']=44;
                $_GET['ps_id']=35;
                return "look/view";
            }
            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database
            // If so, set $_GET['manufacturer'] and/or $_GET['model']
            // and return 'car/index'
        }
        return false;  // this rule does not apply
    }
}

?>