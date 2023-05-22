

<?php

$date = date('H:i:s');
$file = "logs.txt";


function addLog($isLate){
    global $date;
    global $file;
    $data = null;

    if (((int) date('H')) >= 8) {
        $isLate = true;
    }


    if ($isLate) {
        $data = $date . " meskanie \n";
        $isLate = true;
    }else{
        $data = $date . "\n";
    };

    if(((int) date('H')) >= 20 && ((int) date('H')) <= 24 ){
        die("prichod nemoze byt zaznamenany");
    }
    

    $handle = fopen($file, "a");
    fwrite($handle, $data);
    fclose($handle);
};

function getLogs(){
    global $file;
    echo "Logs: \n" . file_get_contents($file);    
};

addLog(false);
getLogs();
?>

