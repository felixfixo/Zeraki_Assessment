<?php
$host = 'localhost';  
$user = 'root';  
$Password = '';  
$databaseName = 'education';  
// Create a connection to the 'education' database
$dbConnection = mysqli_connect($host, $user, $Password, $databaseName);

//check if the connection was successful
if(!$dbConnection){  
	die('Failed to connect to the database '.mysqli_connect_error());  
}

// Define  student table 
$student_table_schema= "CREATE TABLE IF NOT EXIST 'student'
(
	studentid INT(11) AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(250),
	course INT(11)
)";

// Define  course table 
$course_table_schema = "CREATE TABLE IF NOT EXIST 'course'
(
	courseid INT(11) AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(250),
	institution INT(11)
)";

// Define  institution table 
$institution_table_schema = "CREATE TABLE IF NOT EXIST 'institution'
(
	institutionid INT(11) AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(250)
)";

// Execute command to create table 'student' and check if the process is successful or not
if ( mysqli_query($dbConnection, $student_table_schema) ){
    echo "Student table has been created";
}
else {
    echo "An error occurred while creating student table. Please try again";  
}

// Execute command to create table 'course' and check if the process is successful or not


if ( mysqli_query($dbConnection, $course_table_schema) ){
    echo "course table has been created";
}
else {
    echo "An error occurred while creating course table. Please try again";  
}

// Execute command to create table 'course' and check if the process is successful or not

if (mysqli_query($dbConnection, $institution_table_schema) ){
    echo "institution table has been created";
}
else {
    echo "An error occurred while creating institution table. Please try again";  
}

// The following section has the answer to question 3. b)

//selection all institutions
$institutionsQuery = mysqli_query( $dbConnection, "SELECT * FROM institution");

$institutionsData=array();           
if ($institutionsQuery) {
	//creating an associative array of the returned institution(s)
   while ($row=mysqli_fetch_assoc($institutionsQuery) ) {
        $institutionsData[]=$row;
   }

}

$mergedCoursesNInstitution=array();
$coursesData=array();
foreach ($institutionsData as $institution) {
	//query that returns the courses related to instutions
	$coursesQuery = mysqli_query( $dbConnection, "SELECT * FROM course WHERE institution LIKE ".$institution->institutionid);

	//creating an associative array of the returned course(s)
	if ($coursesQuery) {
	   	while ($row=mysqli_fetch_assoc($coursesQuery) ) {
	 		$coursesData[]=$row;
	   	}

	   	//creating a single array to store related instution(s) and course(s) 
	   	foreach ($coursesData as $courseDatum) {
	   		array_push($mergedCoursesNInstitution, ['institution_name'=> $institution->name, 'course_name'=>$courseDatum->name, 'course_id' => $courseDatum->courseid]);
	   	}
	}	
}


$studentsCount = array();
foreach ($mergedCoursesNInstitution as $datum) {
	//query that returns the student(s) related to instutions
	$query = mysqli_query( $dbConnection, "SELECT * FROM student WHERE course LIKE ".$datum->course_id);

	// Count the number of rows returned by $query
	$numberOfStudents = mysqli_num_rows($query);
	// Create an array to store the count of students
	array_push($studentsCount, ['number_of_students'=>$numberOfStudents]);

}

// Merge $studentsCount and $mergedCoursesNInstitution into one array
$finalMergedData= array_merge($mergedCoursesNInstitution, $studentsCount);

// Creating a HTML table where the results will be displayed
echo "<table>"; 

foreach ($finalMergedData as $finalDatum) {
	echo "<tr>";
	echo "<th>INSTITUTION NAME </th>";
	echo "<th>COURSE NAME </th>";
	echo "<th>NUMBER OF STUDENTS </th>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>" .$finalDatum->institution_name ."</td>";
	echo "<td>" .$finalDatum->course_name ."</td>";
	echo "<td>" .$finalDatum->number_of_students ."</td>";
	echo "</tr>";
}
// close the table
echo "</table>";

// Close the database connection when no longer needed
 mysqli_close($dbConnection);  
?>