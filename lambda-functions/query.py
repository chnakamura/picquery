import sys
import pymysql.cursors
import boto3
from config import config

connection = pymysql.connect(**config)
S3_RESOURCE = boto3.resource('s3')
BUCKET_RESOURCE = S3_RESOURCE.Bucket('cmsc389l-split')

def query_images(tag):
    sql = "SELECT file_path FROM tags where name = (%s)"

    cursor = connection.cursor()
    cursor.execute(sql, tag)
    results = cursor.fetchall()

    for row in results:
        BUCKET_RESOURCE.download_file(row[0], row[0])
        print(row[0])

    cursor.close()

def main(argv):
    tag = argv[0]
    query_images(tag)

if __name__ == "__main__":
   main(sys.argv[1:])