# Split
Split is a Google Photos like service that allows you to query your photos based on computer vision tags.

## Inspiration
It is so tediuous to sort through you photos and manually tag them.  What if it could be done automatically for you?

## Deliverables

[An interactive demo](http://54.173.238.19/CMSC389L_Split/no-role-web-interface/)

[Checkpoint](https://github.com/chnakamura/CMSC389L_Split/blob/master/checkpoint.pdf)

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
