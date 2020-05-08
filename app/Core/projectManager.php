<?php


namespace App\Core;


use http\Exception\InvalidArgumentException;

class projectManager{

    public function getStartDate(string $projectName):string
    {
        $startDate = database()->select('projects','start_date',['project'=>$projectName]);
        return  $startDate[0];
    }

    public function getHumanPower(string $projectName):int
    {
       $humanPower = database()->select('projects','humanpower',['project'=>$projectName]);
       return $humanPower[0];
    }

    public function getAllPoints($projectName):array
    {
        return database()->select('jobs','points',['project'=>$projectName]);
    }


    public function calculateEndDate(string $projectName,array $bankHolidays):string
    {
        return Calculate::endDate($this->getStartDate($projectName),$this->getAllPoints($projectName),$this->getHumanPower($projectName),$bankHolidays);
    }

    public function updateEndDateInDB(string $projectName, string $endDate):void
    {
        database()->update('projects',['end_date'=>$endDate],['project'=>$projectName]);
    }

    public function updateKoef(string $projectID, string $jobType,float $koef):void
    {
        database()->update('jobsteps',['koef'=>$koef],['AND'=>[
            'project_id'=>$projectID,
            'job_type'=>$jobType]
        ]);
    }
    public function NewJobTypeByProjectID(string $projectID, string $jobType,float $koef, string $unit):void
    {
        if(database()->has('jobsteps',["AND"=>['project_id'=>$projectID, 'job_type'=>$jobType]]))
        {
            throw new \InvalidArgumentException("input data already exist!");
        }
        database()->insert('jobsteps',['project_id'=>$projectID,'job_type'=>$jobType,
            'koef'=>$koef,'unit'=>$unit]);
    }
    public function getUnitVal(int $id):float
    {
        return database()->get('jobs','unit_val',['id'=>$id]);
    }
    public function getKoef(string $projectId, string $jobType):float
    {
        $koef = database()->get('jobsteps','koef',['AND'=>['project_id'=>$projectId, 'job_type'=>$jobType]]);
        return $koef;
    }
    public function getProjectID($id):string
    {
        return database()->get('jobs','project_id',['id'=> $id]);
    }
    public function getJobType($id):string
    {
        return database()->get('jobs','job_type',['id'=> $id]);
    }

//    iznest validāciju ārpusē
    public function updatePoints(string $id):void
    {
        $points= Calculate::points($this->getUnitVal($id),$this->getKoef($this->getProjectID($id),$this->getJobType($id)));
        database()->update('jobs',['points'=>$points],['id'=>$id]);
    }

    public function selectProject(string $project, int $status, string $date):array
    {
        return database()->select('jobs',['id'],['AND'=>['project'=>$project,'status'=>$status,'date'=>$date]]);
    }
}
