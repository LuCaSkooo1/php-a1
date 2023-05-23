<!DOCTYPE html>
<html>
<head>
    <title>Logs</title>
</head>
<body>
    <h1>Logs:</h1>
    <p></p>
    <?php

        $logDate = date('H:i:s');
        $logFile = "logs.txt";
        $currentHour = (int) date('H');


        function addLog($isLate, $logDate, $logFile, $currentHour)
        {
            $data = null;

            if (($currentHour) >= 8) {
                $isLate = true;
            }


            if ($isLate) {
                $data = $logDate . " meskanie";
                $isLate = true;
            }else{
                $data = "\n" . $logDate;
            };

            if(($currentHour) >= 20 && ($currentHour) <= 24 ){
                die("prichod nemoze byt zaznamenany");
            }
            

            $handle = fopen($logFile, "a");
            fwrite($handle, $data );
            fclose($handle);
        }

        function getLogs($logFile)
        {

            $lines = file($logFile);
            
            foreach ($lines as $line) {
                echo $line  . "<br>";
            }

        }

        addLog($isLate, $logDate, $logFile, $currentHour);
        getLogs($logFile);

        ?>
    
</body>
</html>



