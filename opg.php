<?php

use App\Core\projectManager;

require_once __DIR__ . '/vendor/autoload.php';

//activate application
$app = new projectManager();
//select project
$projectName = 'SCHOOL1';
//provide array with string values of Bank holidays
//place for improvement  - automatic selects array with Bank holidays according to country provided in projects.
$bankHolydays = ["2020-01-01", "2020-01-06"];

//calculating project end date including weekends and holidays,
$endDate =  $app->calculateEndDate($projectName,$bankHolydays);

//update end date in DB projects  by project name
$app->updateEndDateInDB($projectName,$endDate);

//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX//

//update "koef" in DB jobsteps by projectName and jobType
$app->updateKoef($projectName,"LAYOUT",0.03);
$app->updateKoef($projectName,"STEEL",0.15);
$app->updateKoef($projectName,"FIRSTSIDE",0.25);
$app->updateKoef($projectName,"SECONDSIDE",0.20);

//add new job type in DB if not exist!
$app->NewJobTypeByProjectID("SCHOOL1","SECONDSIDE2",0.15,"m2");




//NOT DEVELOPED JET!!!
//
//$status = 1;
//$date =  "2020-01-01";
//
//$selectedData = $app->selectProject($projectName,$status,$date);
//foreach ($selectedData as $index => $key)
//{
//    $id = $selectedData[$index]['id'];
//    $app->updatePoints($id);
//
//}


