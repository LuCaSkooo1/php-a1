<!DOCTYPE html>
<html>
<head>
    <title>Logs</title>
</head>
<body>
    <h1>Logs:</h1>
    <form action="index.php" method="get">
        Name: <input type="text" name="name"><br>
        <input type="submit">
    </form>
    <?php

        $logDate = date('H:i:s');
        $logFile = "logs.txt";
        $studentFile = "students.json";
        $currentHour = (int) date('H');

        


        function addLog($logDate, $logFile, $currentHour, $studentFile)
        {
            $data = null;
            $studentData = null;

            if (isset($_GET['name'])) {
                $name = $_GET['name'];
            } 

            if (($currentHour) >= 8) {
                $isLate = true;
            }


            if ($isLate) {
                $data = "\n" . $name . " " . $logDate . " meskanie";
                $studentData = "\n" . $name;
            }else{
                $data = "\n" . $name . $logDate;
                $studentData = "\n" . $name;
            };

            $studentFileData = file_get_contents($studentFile);

                $log = json_decode($studentFileData, true);

                if (array_key_exists($name, $log)) {
                    $log[$name]++;
                } else {
                    $log[$name] = 1;
                }

                print_r($studentFileData);

                $jsonData = json_encode($log, JSON_PRETTY_PRINT);

                file_put_contents($studentFile, $jsonData);


            if(($currentHour) >= 20 && ($currentHour) <= 24 ){
                die("prichod nemoze byt zaznamenany");
            }
            

            $handle = fopen($logFile, "a");
            fwrite($handle, $data );
            fclose($handle);

            
        }

        function getLogs($logFile)
        {
            return file_get_contents($logFile);
        }

        addLog($logDate, $logFile, $currentHour, $studentFile);
        echo nl2br(getLogs($logFile));

        ?>
    
</body>
</html>



