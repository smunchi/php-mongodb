<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$filename = 'https://media.mongodb.org/zips.json';
$lines = file($filename, FILE_IGNORE_NEW_LINES);

$bulk = new MongoDB\Driver\BulkWrite;

foreach ($lines as $line) {
    $bson = MongoDB\BSON\fromJSON($line);
    $document = MongoDB\BSON\toPHP($bson);
    $bulk->insert($document);
}

// connect to mongodb
$manager = new \MongoDB\Driver\Manager();
echo "Connection to database successfully";
// select a database
//$manager->db = "php_mongodb";
//$db = $manager->db;
//echo nl2br("\nDatabase {$db} selected");

$result = $manager->executeBulkWrite('test.zips', $bulk);
printf("Inserted %d documents\n", $result->getInsertedCount());
?>