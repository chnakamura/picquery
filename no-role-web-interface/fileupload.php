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

?>


</body>
</html>
