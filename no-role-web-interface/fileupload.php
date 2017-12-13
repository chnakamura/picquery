<!DOCTYPE html>
<html>
<body>

<?php

// Include the AWS SDK using the Composer autoloader.

require_once('config.php');

var_dump($_FILES);

foreach ($_FILES as $file) {
    $key = $file['name'];
    $pathToFile = $file['tmp_name'];
    
    $result = $s3->putObject(array(
        'Bucket'     => $bucket,
        'Key'        => $key,
        'SourceFile' => $pathToFile
    ));
}

return true;


// header('HTTP/1.1 500 Internal Server Error');
// header('Content-type: text/plain');
// exit("My error");

// $dbhost = "cmsc389n-group-project.cmwyuj79unri.us-east-1.rds.amazonaws.com";
// $dbuser = "cmsc389l";
// $dbpass = "aws_magic";
// $db = "cmsc-389l-split";

// $mysqli = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

// $query = $_POST['querystring'];

// $sql = "SELECT distinct file_path, confidence from tags where name like \"%{$query}%\" group by file_path";

// $res = $mysqli->query($sql);
// if (!$res) throw new $mysqli->error;

// $bucket = 'cmsc389l-split';
// //$keyname = 'college1.jpg';

// // Instantiate the client.
// $s3 = new S3Client([
//     'version' => '2006-03-01',
//     'region' => 'us-east-1',
//     'credentials' => array(
//         'key' => 'AKIAIDOBILMX3K47KGMA',
//         'secret'  => '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',
//       )
// ]);

// try {
//     // Get the object

//     while ($row = $res->fetch_assoc()) {
//         $keyname = $row['file_path'];

//         $result = $s3->getObject(array(
//             'Bucket' => $bucket,
//             'Key'    => $keyname
//         ));
    
//         echo '<div class="col-lg-6" >';
//         echo '<figure class="figure">';
//         echo '<img class="figure-img img-fluid rounded" src="data:image/jpeg;base64,'.base64_encode($result['Body']).'"/>';
//         echo '<figcaption class="figure-caption">Confidence: '.$row['confidence'].'</figcaption>';
//         echo ' </figure>';
//         echo '</div>';
//     }

//     // Display the object in the browser
//     // header("Content-Type: {$result['ContentType']}");
//     // echo $result['Body'];
// } catch (S3Exception $e) {
//     echo $e->getMessage() . "\n";
// }

?>


</body>
</html>
