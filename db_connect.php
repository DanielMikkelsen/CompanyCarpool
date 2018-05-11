<?php

function db() {
    global $link;
    $link = mysqli_connect("server13.chosting.dk", 
            "dingode1", "XXXXX", "dingode1_carpool")
            or die("couldn't connect to database");
    return $link;
}

if(db()){
    echo "wawu !!! I’m connected";
}

?>