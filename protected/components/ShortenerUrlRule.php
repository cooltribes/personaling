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

                $decoded = 0;
                $multi = 1;
                $alphabet = "123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ";
                $num = $matches[3];
                while (strlen($num) > 0) {
                    $digit = $num[strlen($num)-1];
                    $decoded += $multi * strpos($alphabet, $digit);
                    $multi = $multi * strlen($alphabet);
                    $num = substr($num, 0, -1);
                }
                $_GET['ps_id']=substr($decoded,-5);
                $_GET['id']=substr($decoded,0,-5);
                //$_GET['ps_id']=35;
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