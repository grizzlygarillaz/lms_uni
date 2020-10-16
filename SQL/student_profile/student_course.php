<?php
session_start();
//include  '../templates/Base.php';
require "templates/Base.php";

$host = 'localhost';
$database = 'gr1zzly_tisbi';
$user = 'gr1zzly_tisbi';
$password = '11QazSe44';
$sql = new mysqli($host,$user,$password,$database);

//$course_id=$sql->query("SELECT * FROM student_list WHERE stud_id ='" . $_SESSION['user_id'] . "'"   );
//$query = $course_id->fetch_assoc();
//$code_course=$query['course_id'];

$course_content=$sql->query("SELECT COUNT(*) FROM student_list where stud_id ='" . $_SESSION['user_id'] . "'");
$query= $course_content->fetch_assoc();

?>
    <div class="d-flex flex-wrap">
<?php
for ($i=0 ; $i< $query['COUNT(*)']; $i++):




?>


    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
            <div class="card-body">
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                    </div>
                    <small class="text-muted">9 mins</small>
                </div>
            </div>
        </div>
    </div>


<?php
endfor;
    ?>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT']."/templates/Footer.php"; ?>