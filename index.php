<?php

require_once 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use Goutte\Client;
use App\JobScraperFactory;
use App\Scraper\JobBoards;
use App\Enums\JobStatusEnum;
use App\Database\CRUD;
use App\Database\DatabaseConnection;

$scraperInit = new Client();
$jobBoards = JobBoards::list();

JobScraperFactory::run($jobBoards, $scraperInit);

$config = require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

$dbConnection = DatabaseConnection::createConnection($config);

$pdo = $dbConnection->connect();

// Include your autoloader or require the necessary files


// Create a CRUD instance
$crud = new CRUD($dbConnection);

// // Example: Create a record
// $dataToInsert = [
//     'student_name' => 'John Doe',
//     'city' => 'Los Angeles',
//     'age' => 30,
// ];
// $crud->create('student', $dataToInsert);

// Example: Read records
// $users = $crud->read('student', ['age > :age'], [':age' => 25]);

$allStudents = $crud->read('student');
foreach ($allStudents as $student) {
    echo "Student Name: {$student['student_name']}, Age: {$student['age']}, City: {$student['city']}<br>";
}


// // Example: Update records
// $dataToUpdate = [
//     'age' => 31,
// ];
// $crud->update('users', $dataToUpdate, ['name = :name', ':name' => 'John Doe']);

// // Example: Delete records
// $crud->delete('users', ['age < :age', ':age' => 30]);

// // Example: Search for records
// $searchConditions = ['name LIKE :name', 'age > :age'];
// $searchValues = [':name' => 'John%', ':age' => 30];
// $searchResult = $crud->search('users', $searchConditions, $searchValues);





// $enum = JobStatusEnum::get('open');
// echo JobStatusEnum::set($enum);


// echo '<pre>';
// print_r(JobScraperFactory::run($jobBoards, $scraperInit));
// echo '</pre>';

/*
1. Factory class creates new instances of scraper classes using the strategy pattern.
2. Each scraper class scrapes 100 data entries, including a unique identifier/key.
3. Factory class adds the status and checks the database for each data entry using the identifier/key.
4. If a record with the same identifier/key exists in the database:
   - Compare the status in the database with the new status.
   - If they differ, update the status in the database.
5. If no record is found, insert the new data with its status into the database.
6. Once the data is saved in the database, the scraper proceeds to scrape the next 100 data entries.
7. This process continues until there's no more data to scrape.
8. Once one scraper is done scraping data, the scraper follows the process until all the scrapers are done scraping.
*/
