<!DOCTYPE html>
<html>
<body>

<?php

require_once('config.php');

// Include the AWS SDK using the Composer autoloader.
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$query = $_POST['querystring'];

$sql = "SELECT distinct file_path, confidence from tags where name like \"%{$query}%\" group by file_path";

$res = $mysqli->query($sql);
if (!$res) throw new $mysqli->error;

$bucket = 'cmsc389l-split';


try {
    // Get the object

    while ($row = $res->fetch_assoc()) {
        $keyname = $row['file_path'];

        $result = $s3->getObject(array(
            'Bucket' => $bucket,
            'Key'    => $keyname
        ));
    
        echo '<div class="col-lg-4" >';
        echo '<figure class="figure">';
        echo '<img class="figure-img img-fluid rounded" src="data:image/jpeg;base64,'.base64_encode($result['Body']).'"/>';
        echo '<figcaption class="figure-caption">Confidence: '.$row['confidence'].'</figcaption>';
        echo ' </figure>';
        echo '</div>';
    }

    // Display the object in the browser
    // header("Content-Type: {$result['ContentType']}");
    // echo $result['Body'];
} catch (S3Exception $e) {
    echo $e->getMessage() . "\n";
}

?>


</body>
</html>
