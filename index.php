<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="get" action="">
        <label for="name">Student Name:</label>
        <input type="text" name="name" id="studentName">
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

        public function logStudentArrival($name)
        {

            if (isset($_GET['name'])) {
                $name = $_GET['name'];
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

    }

    $logger = new Logger('arrivals.txt', 'students.json');
    $logger->logStudentArrival($name);
    $logger->echoArrivalLog()
        ?>
</body>

</html>