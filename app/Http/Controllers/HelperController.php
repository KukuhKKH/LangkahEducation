<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\StatistikPengunjung;
use Illuminate\Support\Facades\Artisan;

class HelperController extends Controller {
    public static function kunjungan_user() {
        $ip = self::getIP();
        $browser = self::getBrowser();
        $os = self::getOS();
        $data= [
            'ip' => $ip,
            'browser' => $browser,
            'os' => $os
        ];
        $location = \Illuminate\Support\Facades\Request::ip();
        if($location) $dataIP = \Stevebauman\Location\Facades\Location::get($location);
        // $statistik = StatistikPengunjung::where('ip', $ip)->whereDate('created_at', Carbon::today())->first();
        StatistikPengunjung::updateOrCreate([
            'ip' => $ip,
            'created_at' => Carbon::today()
        ],[
            'ip' => $ip,
            'browser' => $browser,
            'os' => $os,
            'kota' => $dataIP->cityName ?? "",
            'negara' => $dataIP->countryName ?? "",
            'provinsi' => $dataIP->regionName ?? "",
            'long' => $dataIP->longitude ?? "",
            'lat' => $dataIP->latitude ?? ""
        ]);
        return $data;
    }
    
    public function link() {
        return Artisan::call('storage:link', []);
    }

    public function clear_kabeh() {
        Artisan::call('cache:clear');
        Artisan::call('optimize');
        Artisan::call('route:cache');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('config:cache');
        return redirect()->route('dashboard')->with(['success' => 'Berhasil clear Cache Dan kawan kawan']);
    }
    
    public function down() {
        Artisan::call('down --allow=112.215.241.185');
        return 'down';
    }
    
    public function up() {
        Artisan::call('up');
        return 'up';
    }

    private static function getIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    private static function getBrowser() {
        $browser = self::getuserAgent();
        return $browser['name'] . ' v.' . $browser['version'];
    }

    private static function getuserAgent() {
        $u_agent     = $_SERVER['HTTP_USER_AGENT'];
        $bname       = 'Unknown';
        $platform     = 'Unknown';
        $version     = "";

        $os_array   =   array(
            '/windows nt 10.0/i'     =>  'Windows 10',
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

            if (preg_match($regex, $u_agent)) {
                $platform    =   $value;
                break;
            } else {
                $platform    =   'Tidak diketahui';
            }
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        } else {
            $bname = 'Tidak diketahui';
            $ub = "Tidak diketahui";
        }

        //  finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }
        // check if we have a number
        $version = ($version == null || $version == "") ? "?" : $version;
        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'   => $pattern
        );
    }

    private static function getOS() {
        $OS = self::getuserAgent();
	    return $OS['platform'];
    }
}
