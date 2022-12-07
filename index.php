<?php

//CREATE AND CONNECT TO DATABASE

$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='password';
$DATABASE='test';


$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD);
if($con){
    $sql="CREATE DATABASE `test`";
    $queryexecute=mysqli_query($con,$sql);

    if($queryexecute){
       // echo "creation success!";
    } else {
        die(mysqli_error($con));
    }
}
else {
    die(mysqli_error($con));
}  
$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);
// CREATE TABLE PATIENT
if($con){
    $sql="CREATE TABLE `patient`    
        (`_id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `pn` VARCHAR(11)  NULL, 
        `first` VARCHAR(15) NULL, 
        `last` VARCHAR(25)  NULL, 
        `dob` DATE  NULL)";
    $queryexecute=mysqli_query($con,$sql);
    if($queryexecute){
       // echo "table success!";
    }else{
        die(mysqli_error($con));
    }

    // CREATE TABLE INSURANCE
    $sql="CREATE TABLE `insurance`    
        (`_id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        `patient_id` INT(10) NOT NULL,
        `iname` VARCHAR(40) NULL, 
        `to_date` DATE NULL, 
        `from_date` DATE NULL,
        FOREIGN KEY (patient_id) REFERENCES patient(_id))";
    $queryexecute=mysqli_query($con,$sql);
    if($queryexecute){
      //  echo "table success!";
    }else{
        die(mysqli_error($con));
    }
} 
// POPULATE TABLE PATIENT
if($con){
    $sql="INSERT INTO `patient`(`pn`, `first`, `last`, `dob`) 
     VALUES
    (0000000022, 'John', 'Smith', STR_TO_DATE('11-07-90','%m-%d-%y')),
    (0000000041, 'Jack', 'Daniels', STR_TO_DATE('10-07-90','%m-%d-%y')), 
    (0000000012, 'Frank', 'Ocean', STR_TO_DATE('04-10-5','%m-%d-%y')), 
    (0000000026, 'Mike', 'Mclovin', STR_TO_DATE('02-12-00','%m-%d-%y')), 
    (0000000097, 'Jane', 'Doe', STR_TO_DATE('08-11-80','%m-%d-%y'))";
     $queryexecute=mysqli_query($con,$sql);
     if($queryexecute){
      //   echo "populate success!";
     }else{
         die(mysqli_error($con));
     }
}
// POPULATE TABLE INSURANCE
if($con){
    $sql="INSERT INTO `insurance`( `patient_id`, `iname`, `from_date`, `to_date`) 
    VALUES
    (0000000001, 'Blue Cross', STR_TO_DATE('02-01-10','%m-%d-%y'), STR_TO_DATE('03-01-14','%m-%d-%y')),
    (0000000001, 'Medicare', STR_TO_DATE('03-05-03','%m-%d-%y') , STR_TO_DATE('02-07-05','%m-%d-%y')),
    (0000000002, 'Blue Shield', STR_TO_DATE('01-01-17','%m-%d-%y') , STR_TO_DATE('01-01-20','%m-%d-%y')), 
    (0000000002, 'Medicaid', STR_TO_DATE('01-01-03','%m-%d-%y') , STR_TO_DATE('01-01-07','%m-%d-%y')), 
    (0000000003, 'Blue Cross', STR_TO_DATE('06-08-10','%m-%d-%y'), STR_TO_DATE('09-06-11','%m-%d-%y')),
    (0000000003, 'Red Shield', STR_TO_DATE('07-25-12','%m-%d-%y'), STR_TO_DATE('07-04-13','%m-%d-%y')),
    (0000000004, 'Red Cross', STR_TO_DATE('05-05-05','%m-%d-%y'), STR_TO_DATE('07-07-07','%m-%d-%y')),
    (0000000004, 'Blue Shield', STR_TO_DATE('04-02-08','%m-%d-%y'), STR_TO_DATE('10-01-10','%m-%d-%y')),
    (0000000005, 'Medicaid', STR_TO_DATE('05-02-09','%m-%d-%y'), STR_TO_DATE('10-05-13','%m-%d-%y')),
    (0000000005, 'Blue Cross', STR_TO_DATE('01-04-14','%m-%d-%y'), STR_TO_DATE('04-09-16','%m-%d-%y'))";
     $queryexecute=mysqli_query($con,$sql);
     if($queryexecute){
        // echo "populate success! \r\n";
     }else{
         die(mysqli_error($con));
     }
}else{
    die(mysqli_error($con));
}     
 
// DISPLAYING PATIENT NUMBER, PATIENT LAST AND FIRST NAME, INSURANCE NAME, INSURANCE FROM AND TO DATES. ORDERING BY INSURANCE TO DATE STARTING FROM EARLIEST.
$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);

 if($con){
    $sql="SELECT `pn`, `last`, `first`, `iname`, `from_date`, `to_date` FROM `patient`, `insurance` WHERE patient_id = patient._id ORDER BY `insurance`.`from_date` ASC";
    $queryexecute=mysqli_query($con,$sql);
    if($queryexecute){
        $numRows=mysqli_num_rows($queryexecute);
        if($numRows>0){
            while($row=mysqli_fetch_assoc($queryexecute))
            {
             echo $row['pn']." " .$row['last']. " " .$row['first']. " " .$row['iname']." " .$row['from_date']. " " .$row['to_date'].  "\r\n";
            }
        }
    }
} 

// CREATE STATISTICS ABOUT HOW MANY TIMES LETTER APPEAR IN NAMES. 
$row = "John Smith Jack Daniels Frank Ocean Mike Mclovin Jane Doe";

$row = strtoupper($row);
$row = str_replace(' ', '', $row );
$arrLetters = str_split($row);
$countLetters = count($arrLetters);

$letters = array();
rsort($letters);

foreach($arrLetters as $letter){
    if(isset($letters[$letter])){
        $letters[$letter] += 1;
    } else {
        $letters[$letter] = 1;  
    }
}

foreach($letters as $letter => $total){
    echo $letter."  ".$total."  ".round(($total/$countLetters*100),2)." %\r\n";
};
