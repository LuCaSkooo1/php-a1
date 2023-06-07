<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Student Logger</h1>
    <form method="POST" action="">
        <label for="name">Student Name:</label>
        <input type="text" name="name" >
        <input type="submit" value="Submit">
    </form>


    <?php

    class Logger
    {   

        private $fileName;
        private $studentsFile;

        public function __construct($fileName, $studentsFile)
        {
            $this->fileName = $fileName;
            $this->studentsFile = $studentsFile;
        }

        public function echoArrivalLog()
        {

            if (file_exists($this->fileName)) {

                $logContent = file_get_contents($this->fileName);


                echo nl2br($logContent);
            }
        }

        public function logStudentArrival()
        {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = isset($_POST['name']) ? $_POST['name'] : '';
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $name = isset($_GET['name']) ? $_GET['name'] : '';
            } else {
                $name = '';
}

            $currentTime = date('Y-m-d H:i:s');
            $arrivalTime = date('H:i', strtotime($currentTime));


            if ($arrivalTime >= '20:00' && $arrivalTime <= '23:59') {
                die("Error: Arrival cannot be logged between 20:00 and 24:00.");
            }


            $isLate = ($arrivalTime > '08:00') ? true : false;


            $logEntry = "$currentTime - $name" . (($isLate) ? " - meskanie" : "") . PHP_EOL;
            file_put_contents($this->fileName, $logEntry, FILE_APPEND);


            $students = $this->loadStudents();
            if (!isset($students[$name])) {
                $students[$name] = 0;
            }
            $students[$name]++;
            $this->saveStudents($students);


            $arrivals = $this->loadArrivals();
            $arrivals[] = $logEntry;

            $studentsLogs = $this->logStudents();
        }

        private function loadStudents()
        {
            if (file_exists($this->studentsFile)) {
                $studentsJson = file_get_contents($this->studentsFile);
                return json_decode($studentsJson, true);
            }
            return [];
        }

        private function saveStudents($students)
        {
            $jsonStudents = json_encode($students, JSON_PRETTY_PRINT);
            file_put_contents($this->studentsFile, $jsonStudents);
        }

        private function loadArrivals()
        {
            if (file_exists($this->fileName)) {

                $arrivals = file($this->fileName, FILE_IGNORE_NEW_LINES);
            } else {
                $arrivals = array();
            }
            return $arrivals;
        }

        private function saveArrivals($arrivals)
        {

            $arrivalsData = implode(PHP_EOL, $arrivals);


            file_put_contents($this->fileName, $arrivalsData);

        }

        private function logStudents(){
            $jsonFile = 'students.json';

            $jsonData = file_get_contents($jsonFile);

            $studentsLog = json_decode($jsonData, true);

            print_r($studentsLog);
            echo "<br>";
        }

    }

    $logger = new Logger('arrivals.txt', 'students.json');
    $logger->logStudentArrival();
    $logger->echoArrivalLog()
        ?>
</body>

</html>
<style>
    body{
        background-color: #252525;
        color: white;
        font-family: Arial, sans-serif;
        text-align: center;
    }

    input[type="text"]{
        width: 250px;
        height: 25px;
        border-radius: 50px;
        padding-left: 10px;
    }

    input[type="submit"]{
        background-color: #252525;
        border-radius: 50px;
        border: 2px solid #fff;
        color: #fff;
        font-weight: bold;
        width: 100px;
        height: 30px;
        transition: all 300ms;
        font-family: Arial, sans-serif;
        margin-left: 10px
    }

    input[type="submit"]:hover {
        color: #252525;
        background-color: #fff;
        transform:scale(1.1);
    }

    form{
        margin-bottom: 50px;
    }

    @keyframes scaleLoop {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }
    }

    h1 {
        animation: scaleLoop 3s infinite;
    }
</style>