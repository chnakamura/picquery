import sys
import logging
import pymysql
import urllib.parse
import boto3
import json
from config import config

s3 = boto3.client('s3')
S3_RESOURCE = boto3.resource('s3')
BUCKET_RESOURCE = S3_RESOURCE.Bucket('cmsc389l-split')
REKOGNITION_CLIENT = boto3.client('rekognition')

CONNECTION = pymysql.connect(**config)

def handler(event, context):
    print("Received event: " + json.dumps(event, indent=2))

    # Get the object from the event and show its content type
    bucket = event['Records'][0]['s3']['bucket']['name']
    key = urllib.parse.unquote_plus(event['Records'][0]['s3']['object']['key'], encoding='utf-8')
    try:

        response = label_image(key)

        print(json.dumps(response, indent=4))

        input_labels_to_db(key, response["Labels"])

        response = s3.get_object(Bucket=bucket, Key=key)
        print("CONTENT TYPE: " + response['ContentType'])
        return response['ContentType']
    except Exception as e:
        print(e)
        print('Error getting object {} from bucket {}. Make sure they exist and your bucket is in the same region as this function.'.format(key, bucket))
        raise e

def label_image(key):
    return REKOGNITION_CLIENT.detect_labels(
        Image={
            'S3Object': {
                'Bucket': 'cmsc389l-split',
                'Name' : key
            }
        }
    )

def input_labels_to_db(key, labels):
    sql = '''INSERT INTO `tags` (`file_path`, `name`, `confidence`)
    VALUES (%s, %s, %s)
    ON DUPLICATE KEY UPDATE file_path=file_path'''
    cursor = CONNECTION.cursor()
    for label in labels:
        new_tup = (key, label["Name"], label["Confidence"])
        print (new_tup)
        cursor.execute(sql, new_tup)
    CONNECTION.commit()
    cursor.close()
