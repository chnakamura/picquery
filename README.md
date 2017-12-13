# Split
Split is a Google Photos like service that allows you to query your photos based on computer vision tags.

## Inspiration
It is so tediuous to sort through you photos and manually tag them.  What if it could be done automatically for you?

## Deliverables

[Checkpoint](https://github.com/chnakamura/CMSC389L_Split/blob/master/checkpoint.pdf)

[Demo Video](https://www.youtube.com/watch?v=B0L8dqx8wY4&feature=youtu.be)

## Components

**Frontend web interface** - The frontend web interface allows you to upload photos as well as query them for tags.

**Background processes** - When you upload a photo, it is stored and tagged in a database.  This allows for fast querying of your photos.

## How I built it

* S3: Photos are stored in S3
* Lambda: Photo upload triggers lambda function that tags the photos
* Rekognition: Service used to tag the photos
* RDS: A mySQL database used to store image tags
* E3: Hosting service for the web interface

## Challenges I ran into

I originally planned to use Cognito to allow for the service to support multiple users, but I did not have time to get the service working.  This is somthing I want to enable in the future, as the future is not very useful when just one person can use it.  

## What is next

I will use Cognito to enable user-login so that users can access their own photos.  While I could have created sign-in functionality on my own using PHP forms and a MySQL user table, I decided against it becuase it would not teach me anything new, and it would have only been a temporary solution.  The current interface is more just a proof of concept.

## How to get it working on your own.

I did not include my config.php or my config.py file in this repo becuase they had private keys, and the login to the database. They can be recreated in the following way:

config.php:

~~~
$s3 = new S3Client([
    'version' => '2006-03-01',
    'region' => 'us-east-1',
    'credentials' => array(
        'key' => PUBLIC_KEY,
        'secret'  => SECRET_KEY,
      )
]);

$mysqli = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

?>
~~~

config.py:

~~~
config = {
    'host': '... 1.rds.amazonaws.com',
    'user': '',
    'password': '',
    'db': '',
}
~~~

You will need to make a S3 bucket, and a Lambda function.  You will need to make an IAM role for the Lambda function so that has read-access from S3, and permission to call Rekognition.  Amazon provides a outline for a Lambda function that is triggers on S3 file upload.
