<?php 

namespace app\components;

class Utils {

    public static function getIP(){
        
        $ipaddress = "";
        if ($_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if($_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if($_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if($_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
    
        $ipaddress = explode(',',$ipaddress);
    
        return $ipaddress[0];
    }
    
    public static function getMac(){

        exec("/sbin/ifconfig", $output, $err);
        $cont = 0;
        if($output != null){
            $mac = implode($output);
        }else{
            exec("getmac", $output);
            foreach($output as $line)
            {
                if ($cont == 3) {
                    $texto = explode("\\",$line);
                    $mac = trim($texto[0]);
                }
                $cont++;
            }
        }
        return substr($mac, 0,3900);
    }
}