<?php
require_once "vendor/autoload.php";
class ContactsXmlManipulator
{
    /*properties*/
    private  $xmlFileHandler;
    /*constructor*/
    public function __construct()
    {
        $this->xmlFileHandler=simplexml_load_file(_filePath);
      //  echo $this->xmlFileHandler;
    }
    /*methods*/
    public function createEmployeeRecord(string $name,string $phone,string $address,string $email)
    {
        $newEmployee=$this->xmlFileHandler->addChild("employee");
        $newEmployee->addChild("name",$name);
        $newEmployee->addChild("phone",$phone);
        $newEmployee->addChild("address",$address);
        $newEmployee->addChild("email",$email);
        $this->saveToFile();

    }

    public function readEmployeeRecordByPosition(int $position) : EmployeeDto
    {
        $employeeElement=$this->xmlFileHandler->xpath("/contacts/employee[$position]")[0];
        $employeeDto=new EmployeeDto();
        $employeeDto->setName($employeeElement->name);
        $employeeDto->setPhone($employeeElement->phone);
        $employeeDto->setAddress($employeeElement->address);
        $employeeDto->setEmail($employeeElement->email);
        $employeeDto->setPosition($position);
        return $employeeDto;
    }

    public function readEmployeeRecordByName(string $name) : EmployeeDto
    {
        $employeeDto = new EmployeeDto();
        $count=$this->getRecordesCount();
       for( $counter=1;$counter<=$count;$counter++)
       {
           $elementFromXml=$this->xmlFileHandler->xpath("/contacts/employee[$counter]")[0];
           if(strcmp($elementFromXml->name,$name)==0)
           {
               $employeeElement=$elementFromXml;
               $employeeDto->setPosition($counter);
               $employeeDto->setName($employeeElement->name);
               $employeeDto->setPhone($employeeElement->phone);
               $employeeDto->setAddress($employeeElement->address);
               $employeeDto->setEmail($employeeElement->email);
               break;
           }
       }
        return $employeeDto;
    }



    public function updateEmployeeRecord(int $position,string $name,string $phone,string $address,string $email)
    {
        if($position==1)
        {
            return;
        }
        $employee=$this->xmlFileHandler->xpath("/contacts/employee[$position]")[0];
        $employee->name=$name;
        $employee->phone=$phone;
        $employee->address=$address;
        $employee->email=$email;
        $this->saveToFile();
    }

    public function deleteEmployeeRecord (int $poistion)
    {
        if($poistion==1){
            return;
        }
       unset($this->xmlFileHandler->employee[$poistion-1]) ;
       $this->saveToFile();
    }

    public function getRecordesCount() :int
    {
        return $this->xmlFileHandler->count();
    }

    private function saveToFile()
    {
        file_put_contents(_filePath,$this->xmlFileHandler->saveXML());
    }

}