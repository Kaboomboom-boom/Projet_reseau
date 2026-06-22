<?php

function getTypeAppareil(){
    $variable = strtolower($_SERVER['HTTP_USER_AGENT']);
    if(strpos($variable, "iphone") !== false ||
        strpos($variable, "android") !== false ||
        strpos($variable, "mobile") !== false){
            return "Mobile ✆";
    }

    return "Ordinateur 모";
}


function getPosition(){}

    $ip = $_SERVER['REMOTE_ADDR'];
    $json = file_get_contents("http://ip-api.com/json/$ip?fields=status,country,regionName");
    $data = json_decode($json, true);

    if($data['status'] === 'success'){
        return[
            "pays" => $data['country'],
            "region" => $data['regionName']
        ];
    }

    return[
        "pays" => "┬┴┬┴┤(･_├┬┴┬┴",
        "region" => "┬┴┬┴┤(･_├┬┴┬┴"
    ];

?>