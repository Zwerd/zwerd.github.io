<?php
function print_troll(){
    $messages = $GLOBALS['messages'];
    $troll = $GLOBALS['troll'];
    echo $messages[0];
    echo $troll;
}

$troll = <<<EOT
<pre>
                                   _,..._
                                  /__    \
                                   >< `.  \
                                  /_    \ |
                                   \-_  /:|
                                 ,--'..'. :
                               ,'         `.
                            _,'             \
                   _.._,--''    ,           |
               , ,',, _|    _,.'|      |    |
            \\||/,'(,' '--''    |      |    |
       _     |||                |      /-'  |
      | |   (- -)<`._           |     /    /
      | |  \_\O/_/`-.(<<        |____/    /
      | |   /   \              / -'| `--.'|
      | |   \___/             /           /
      | |    H H             /     |     |
      |_|_..-H-H--.._       /     ,|     |
        |-.._"_"__..-|     |   _-/ |     |
        |            |     |    |   \_   |
        |            |     |    |   |    |
        |            |     |____|   |    |
        |            |  _..'    |   |____|
        |            |_(____..._' _.'    |
        `-..______..-'""         (___..--'
<pre>
EOT;

if(!isset($_GET['t']) || !isset($_GET['f'])){
    exit();
}

$imagefile = base64_decode($_GET['f']);
$timestamp = time();
$isblocked = FALSE;
$blacklist = array('/etc','/opt','/var','/opt','/proc','/dev','/lib','/bin','/usr','/home','/ids');
$messages = array("\nLet me throw away your nice request into the bin.\n".
    "The SOC was informed about your attempt to break into this site. Thanks to previous attackers effort in smashing my infrastructructure I will take strong legal measures.\n".
    "Why don't you wait on your chair until someone (maybe the police) knock on your door?\n\n");

if(abs($_GET['t'] - $timestamp) > 10){
    exit();
}
foreach($blacklist as $elem){
    if(strstr($imagefile, $elem) !== FALSE)
        $isblocked = TRUE;
}
// report the intrusion to the soc and save information locally for further investigation
if($isblocked){
    $logfile = 'intrusion_'.$timestamp;
    $fp = fopen('/var/log/soc/'.$logfile, 'w');
    fwrite($fp, "'".$imagefile."'");
    fclose($fp);
    exec('python /opt/ids_strong_bvb.py </var/log/soc/'.$logfile.' >/tmp/output 2>&1');
    print_troll();
    exit();
}
chdir('img');
$filecontent = file_get_contents($imagefile);
if($filecontent === FALSE){
    print_troll();
}
else{
    echo $filecontent;
}
chdir('../');

?>
