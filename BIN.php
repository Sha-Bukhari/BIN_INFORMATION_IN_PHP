<?php



error_reporting(0);
set_time_limit(0);
error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');

function multiexplode($delimiters, $string)
{
$one = str_replace($delimiters, $delimiters[0], $string);
$two = explode($delimiters[0], $one);
return $two;
}

##################### CC MES ANO CVV ##############################



$lista = $_GET['lista'];
$cc = multiexplode(array(":", "|", ""), $lista)[0];
$mon = multiexplode(array(":", "|", ""), $lista)[1];
$year = multiexplode(array(":", "|", ""), $lista)[2];
$cvv = multiexplode(array(":", "|", ""), $lista)[3];


function GetStr($string, $start, $end)
{
$str = explode($start, $string);
$str = explode($end, $str[1]);
return $str[0];
}



#################### bin lookup ######
$cc1 = substr($cc, 0, 6);

#################[ User Rand ]#################
$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://bins.su/');
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_POST, 1);
    $headers = array();
    $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
    $headers[] = 'Accept-Language: en-US,en;q=0.9';
    $headers[] = 'Cache-Control: max-age=0';
    $headers[] = 'Connection: keep-alive';
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    $headers[] = 'Host: bins.su';
    $headers[] = 'Origin: http://bins.su';
    $headers[] = 'Referer: http://bins.su/';
    $headers[] = 'Upgrade-Insecure-Requests: 1';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'action=searchbins&bins='.$cc1.'&bank=&country=');
$result = curl_exec($ch);
    $bincap1 = trim(strip_tags(getStr($result, '<td>Bank</td></tr><tr><td>','</td>')));
    $bincap2 = (getStr($result, '<td>'.$bincap1.'</td><td>','</td>'));
    $bincap3 = trim(strip_tags(getStr($result, '<td>'.$bincap2.'</td><td>','</td>')));
    $bincap4 = trim(strip_tags(getStr($result, '<td>'.$bincap3.'</td><td>','</td>')));
    $bincap5 = trim(strip_tags(getStr($result, '<td>'.$bincap4.'</td><td>','</td>')));
    $HEIST = trim(strip_tags(getStr($result, '<td>'.$bincap5.'</td><td>','</td>')));
// $flag = getFlags($bincap2);
    if(strpos($result, 'No bins found!')) {
    echo ("<b>❌BIN BANNED</b>");
    exit();
    }
echo  '<code>' .$bincap1. '</code>  <i>VALID-BIN✅</i>'; echo ' =>  <i>BRAND:-</i>  <code>'.$bincap3.'</code>  =>  <i>LEVEL:-</i>  <code>'.$bincap4.'</code> =>  <i>TYPE:-</i>  <code>'.$bincap5.'</code> => <i>BANK:-</i>  <code>'.$HEIST.'</code>  => <i>COUNTRY:-</i> ( <code>'.$bincap2.'</code>)  ';
        exit();


echo "MADE BY SHABUKHARI";

?>