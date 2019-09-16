<?php


namespace Core\LogReader;

use Core\Configuration\Config;
use Core\LogReader\Callbacks\CallbackFunction;
use Core\LogReader\LogObjects\InitGame;
use Core\LogReader\LogObjects\PlayerJoin;

/**
 * Class GamesLog
 *
 * games_mp.log Reader
 *
 * @package Core\LogReader
 */
class GamesLog extends Reader
{
    public function __construct()
    {
        parent::__construct(Config::$setting->main()->get("log_games_mp"));

        $this->getCallbackRegister()->addCallBack(CallbackFunction::onInitGame);
        $this->getCallbackRegister()->addCallBack(CallbackFunction::onPlayerJoin);
        $this->getCallbackRegister()->addCallBack(CallbackFunction::onKill);
        $this->getCallbackRegister()->addCallBack(CallbackFunction::onDamage);
        $this->getCallbackRegister()->addCallBack(CallbackFunction::onSay);
        $this->getCallbackRegister()->addCallBack(CallbackFunction::onSayTeam);
        $this->getCallbackRegister()->addCallBack(CallbackFunction::onPlayerDisconnect);
        $this->getCallbackRegister()->addCallBack(CallbackFunction::onTick);
        $this->getCallbackRegister()->addCallBack(CallbackFunction::onShutdown);
    }

    /**
     * Run addon Core function
     */
    public function run()
    {
        while(true) {
            $tStart = microtime(true);
            $this->getLines();
            $tEnd = microtime(true);
            $tCalc = $tEnd - $tStart;
            $sTime = 1000000 - $tCalc;

            if($sTime > 0) {
                usleep($sTime);
            }
        }
    }

    /**
     * Read / Parse logfile line
     * @param string $line String Line
     */
    protected function readLine(string $line)
    {
        if(Config::$setting->main()->get("game") == "codwaw"){
            $line = trim($line);
            $time = substr($line,0,10);
            $line =  substr($line,11);
            $temp[2] = $line;
            $action = substr($line,0,1);
            $action2 = substr($line,1,1);
        }else{
            $line = trim($line);
            $temp = explode(":",$line);
            $count_temp = count($temp);
            if($count_temp > 2){
                for($i = 2; $i < $count_temp; $i++){
                    $temp[1] = $temp[1].":".$temp[$i];
                }
            }

            $time = $temp[0].":".substr($temp[1],0,2);
            $expTime = explode(":",$time);
            $time = ($expTime[0] * 60) + $expTime[1];
            $line = $temp[1];
            $line = substr($line,3);
            $action = substr($line,0,1);
            $action2 = "";
        }

        switch ($action) {
            case "I":
                $this->onInitGame($time, $line);
                break;

            case "J":
                if($action2 != "T") {
                    $this->onPlayerJoin($time, $line);
                }
                break;
            case "K":
                $this->onKill($time, $line);
                break;
            case "s":
                $this->onChat($time, $line);
                break;
            case "Q":
                $this->onPlayerDisconnect($time,$line);
                break;
            case "D":
                $this->onDamage($time, $line);
                break;
            case "S":
                $this->onShutdown($time);
                break;
        }

        $this->getCallbackRegister()->doCallBacks("onTick", null);
    }

    /**
     * onInit Game Function
     * @param $time String Time
     * @param $line String line
     */
    private function onInitGame($time, $line) {
        //COD4  18:50 InitGame: \sv_maxclients\32\sv_punkbuster\0\version\CoD4 X 1.7a linux-i386-custom_debug build 3360 Feb 20 2016\shortversion\1.7a\build\3360\sv_hostname\^1=[^3JFF^1]= ^3Cracked ^1Server ^3#1\sv_minPing\0\sv_maxPing\300\sv_voice\0\sv_maxRate\25000\sv_floodprotect\1\_CoD4 X Creator\Ninjaman, TheKelm @ http://iceops.in\protocol\6\sv_privateClients\4\sv_disableClientConsole\0\g_mapStartTime\Fri Dec 22 07:33:22 2017\uptime\18 minutes\g_gametype\sab\mapname\mp_crossfire\sv_pure\1\g_compassShowEnemies\0\gamename\Call of Duty 4
        //COD5 1513028419 InitGame: \fxfrustumCutoff\1000\g_compassShowEnemies\0\g_gametype\tdm\gamename\Call of Duty: World at War\mapname\mp_outskirts\penetrationCount\5\protocol\101\r_watersim_enabled\1\shortversion\1\sv_allowAnonymous\0\sv_disableClientConsole\0\sv_floodprotect\4\sv_hostname\^1=[^3JFF^1]= ^3Cracked ^1Server ^3#1\sv_maxclients\40\sv_maxPing\500\sv_maxRate\25000\sv_minPing\0\sv_privateClients\4\sv_punkbuster\0\sv_pure\1\sv_voice\0\ui_maxclients\64\g_logTimeStampInSeconds\1
        //COD2  15:10 InitGame: \g_antilag\1\g_gametype\sd\gamename\Call of Duty 2\mapname\mp_toujane\protocol\118\scr_friendlyfire\0\scr_killcam\1\shortversion\1.3\sv_allowAnonymous\0\sv_floodProtect\1\sv_hostname\^1=[JFF]= ^3Classic CoD2! ^1Cracked\sv_maxclients\32\sv_maxPing\300\sv_maxRate\25000\sv_minPing\0\sv_privateClients\4\sv_punkbuster\0\sv_pure\1\sv_voice\0
        //COD1   0:00 InitGame: \fs_game\awe_uo\g_gametype\sd\g_timeoutsallowed\0\gamename\CoD:United Offensive\mapname\german_town\protocol\22\scr_allow_jeeps\1\scr_allow_tanks\1\shortversion\1.51\sv_allowAnonymous\1\sv_floodProtect\1\sv_hostname\^1=[^3JFF^1]= ^3Cracked ^1Server ^3#1\sv_maxclients\32\sv_maxRate\25000\sv_minPing\0\sv_privateClients\2\sv_punkbuster\0\sv_pure\0

        $gameSettings = array();

        $settings = explode('\\', $line);
        array_shift($settings);

        for($i = 0; $i < count($settings); $i += 2) {
            $gameSettings[$settings[$i]] = $settings[$i + 1];
        }

        $this->getCallbackRegister()->doCallBacks(CallbackFunction::onInitGame, new InitGame($time, $gameSettings));
    }

    /**
     * onPlayerJoin Function
     * @param $time String Time
     * @param $line String line
     */
    private function onPlayerJoin($time, $line) {
        //COD4  42:15 J;0000000046b1d170fcea01807b71cdda;4;Elijahk707
        //COD5 1513899619 J;0;2;[codw]beneissa
        //COD5 1513899621 JT;0;2;allies;[codw]beneissa;
        //COD2 1029:07 J;0;5;Thomas Shoot
        //COD1 1172:15 J;0;3;^7^^0YaMaHa^1*

        $playerInfo = explode(";",$line);

        $this->getCallbackRegister()->doCallBacks(CallbackFunction::onPlayerJoin, new PlayerJoin($time, $playerInfo[3], $playerInfo[2], $playerInfo[1]));
    }

    /**
     * onKill Function
     * @param $time String time
     * @param $line String line
     */
    private function onKill($time, $line) {
        //COD4 316:34 K;0000000046b1d170fcea01807b71cdda;12;;BrokenSY;0000000044b594260d4a1a6d97c6d179;5;;Leon;gl_m16_mp;107;MOD_GRENADE_SPLASH;none
        //COD5 1513947447 K;0;10;allies;[RAK]Danila;774126096;3;axis;MagWinters;stg44_aperture_mp;30;MOD_RIFLE_BULLET;torso_lower
        //COD2 1043:34 K;0;4;axis;Ashley;0;6;allies;BotyoElvtars;ppsh_mp;35;MOD_PISTOL_BULLET;torso_lower
        //COD1 1178:15 K;0;2;allies;^7^^1S^7ex^1X^7y;0;3;axis;^7^^0YaMaHa^1*;mp44_mp;54;MOD_PISTOL_BULLET;torso_lower

        $message = explode(";",$line);

        $info["guid_l"] = $message[1];
        $info["id_l"] = $message[2];
        $info["team_l"] = $message[3];
        $info["name_l"] = $message[4];
        $info["guid_w"] = $message[5];
        $info["id_w"] = $message[6];
        $info["team_w"] = $message[7];
        $info["name_w"] = $message[8];
        $info["weapon"] = $message[9];
        $info["damage"] = $message[10];
        $info["mod"] = $message[11];
        $info["body"] = $message[12];

        $this->getCallbackRegister()->doCallBacks(CallbackFunction::onKill, array(0 => $time, 1 => $info));
    }

    /**
     * onChat Function
     * @param $time String time
     * @param $line String line
     */
    private function onChat($time, $line)
    {
        //COD4 1671:34 say;0000000046b1d170fcea01807b71cdda;9;Alif;lmao we won against 3 max levels
        //COD5 1513928385 say;1630125638;2;yamaha5677;hi
        //COD2 986:15 say;0;4;Ashley;ïðèâåò
        //COD1 915:18 say;0;3;Aleck_O|||SUNDUK;hi

        $line = str_replace("\x15", "", $line);
        $message = explode(";",$line, 5);

        $type = $message[0];
        $guid = $message[1];
        $slot = $message[2];
        $name = $message[3];
        $text = $message[4];

        switch($type) {
            case "say":
                $this->getCallbackRegister()->doCallBacks(CallbackFunction::onSay, array(0 => $time, 1 => $slot, 2 => $guid, 3 => $name, 4 => $text));
                break;
            case "sayteam":
                $this->getCallbackRegister()->doCallBacks(CallbackFunction::onSayTeam, array(0 => $time, 1 => $slot, 2 => $guid, 3 => $name, 4 => $text));
                break;
        }
    }

    /**
     * OnPlayerDisconnect Function
     * @param $time String time
     * @param $line String line
     */
    private function onPlayerDisconnect($time, $line)
    {
        //COD4  22:11 Q;00000000dac4a2002167455cfada17df;4;Vit
        //COD5 1513928439 Q;1630125638;2;yamaha5677
        //COD2 1052:25 Q;0;6;BotyoElvtars
        //COD1 1013:00 Q;0;4;^2CypressHill

        $playerInfo = explode(";",$line);

        $this->getCallbackRegister()->doCallBacks(CallbackFunction::onPlayerDisconnect, array(0 => $time, 1 => $playerInfo[1], 2 => $playerInfo[2], 3 => $playerInfo[3]));
    }

    /**
     * OnDamage Function
     * @param $time String time
     * @param $line String line
     */
    private function onDamage($time, $line)
    {
        //COD4 337:30 D;000000003a6a0b9112e5ca06605c3cd2;14;allies;digiligi;000000007b1bf9e77faead1d50a15a0a;10;axis;robinhood;m4_reflex_mp;30;MOD_RIFLE_BULLET;left_leg_upper
        //COD5 1513928931 D;0;2;allies;1944;0;3;axis;Tolyan;stg44_aperture_mp;30;MOD_RIFLE_BULLET;torso_lower
        //COD2 1052:28 D;0;5;allies;Thomas Shoot;0;4;axis;Ashley;mp44_mp;40;MOD_RIFLE_BULLET;right_arm_lower
        //COD1 1012:54 D;0;3;axis;Aleck_O|||SUNDUK;0;2;allies;^1D^2A^1G;ppsh_mp;19;MOD_PISTOL_BULLET;left_arm_upper

        $message = explode(";",$line);

        $info["guid_l"] = $message[1];
        $info["id_l"] = $message[2];
        $info["team_l"] = $message[3];
        $info["name_l"] = $message[4];
        $info["guid_w"] = $message[5];
        $info["id_w"] = $message[6];
        $info["team_w"] = $message[7];
        $info["name_w"] = $message[8];
        $info["weapon"] = $message[9];
        $info["damage"] = $message[10];
        $info["mod"] = $message[11];
        $info["body"] = $message[12];

        $this->getCallbackRegister()->doCallBacks(CallbackFunction::onDamage, array(0 => $time, 1 => $info));
    }

    /**
     * onShutdown Function
     * @param $time String time
     */
    private function onShutdown($time)
    {
        $this->getCallbackRegister()->doCallBacks(CallbackFunction::onShutdown, array(0 => $time));
    }
}