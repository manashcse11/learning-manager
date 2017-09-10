<?php
function countArrayItemsInsideArray($param, $key){
    $total = 0;
    foreach($param as $item){
        if(array_key_exists($key, $item)){
            $total = $total + count($item[$key]);
        }
    }
    return $total;
}

function pr($param, $exit = true){
    echo"<pre>";
    print_r($param);
    if($exit){
        exit();
    }
}