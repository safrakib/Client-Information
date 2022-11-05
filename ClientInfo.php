class ClientInfo
{
public static function getClientIp()
    {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
        return $ipaddress;
    }

    public static function getMac()
    {
        $mac = '';
        $response = array();
        if (function_exists('system')) {
            ob_start();
            system('getmac');
            $Content = ob_get_contents();
            ob_clean();
            $mac=substr($Content, strpos($Content,'\\')-20, 17);

        }elseif (function_exists('exec')) {
            $string = exec('getmac');
            $mac = substr($string, 0, 17);
        } else {
            $response['status'] = 'error';
            $response['message'] = 'System Function Need To Enable';
            return $response;
        }

        $macValid = self::macValidate($mac);
        if ($macValid == true) {
            $response['status'] = 'success';
            $response['message'] = '';
            $response['mac'] = $mac;
            return $response;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Mac Address Not Valid';
            $response['mac'] = '';
            return $response;
        }
    }

    public static function macValidate($mac)
    {
        return preg_match('/^(?:(?:[0-9a-f]{2}[\:]{1}){5}|(?:[0-9a-f]{2}[-]{1}){5}|(?:[0-9a-f]{2}){5})[0-9a-f]{2}$/i', $mac);
    }
    public static function getOS()
    {

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform =   "unknown";
        $os_array =   array(
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }
        return $os_platform;
    }

    public static function getBrowser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser        = "unknown";
        $browser_array  = array(
            '/msie/i'       =>  'Internet Explorer',
            '/firefox/i'    =>  'Firefox',
            '/safari/i'     =>  'Safari',
            '/chrome/i'     =>  'Chrome',
            '/Edg/i'       =>  'Edge',
            '/opera/i'      =>  'Opera',
            '/netscape/i'   =>  'Netscape',
            '/maxthon/i'    =>  'Maxthon',
            '/konqueror/i'  =>  'Konqueror',
            '/mobile/i'     =>  'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }
        return $browser;
    }

    public static function getShortAmount($money){

       if($money>=1000000000000){
        $result['amount']=$money/1000000000000;
        $result['word']='T';
        $result['short']=$result['amount'].'T';
       }elseif($money>=1000000000){
        $result['amount']=$money/1000000000;
        $result['word']='B';
        $result['short']=$result['amount'].'B';
       }elseif($money>=1000000){
        $result['amount']=$money/1000000;
        $result['word']='M';
        $result['short']=$result['amount'].'M';
       }elseif($money>=1000){
        $result['amount']=$money/1000;
        $result['word']='K';
        $result['short']=$result['amount'].'K';
       }else{
        $result['amount']=$money;
        $result['word']='';
        $result['short']=$money;
       }
       return $result;
    }

}
