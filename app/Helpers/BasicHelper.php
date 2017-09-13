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

function isMilestone($type_id){
    if($type_id == 5){
        return true;
    }
    return false;
}

function isItem($type_id){
    if($type_id == 4){
        return true;
    }
    return false;
}

function isSubCategory($type_id){
    if($type_id == 3){
        return true;
    }
    return false;
}

function isCategory($type_id){
    if($type_id == 2){
        return true;
    }
    return false;
}

function isLevel($type_id){
    if($type_id == 1){
        return true;
    }
    return false;
}

function pr($param, $exit = true){
    echo"<pre>";
    print_r($param);
    if($exit){
        exit();
    }
}