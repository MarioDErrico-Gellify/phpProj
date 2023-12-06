
<?php

include "connection/userservice.php";


class CreateUser
{
    public string $name;
    public string $surname;
    public string $email;
    /*TODO implements api for vat_number*/
    public string $vat_number;
    public string $password;

    public function __construct(string $email, string $name , string $surname , string $password , string $vat_number)
    {
        $this->email = $email;
        $this->name = $name;
        $this->surname = $surname;
        $this->password = $password;
        $this->vat_number = $vat_number;
    }
    public function checkEmptyValue() : string | bool
    {
        if (empty($this->name) || empty( $this->password) || empty($this->email) || empty($this->surname) || empty($this->vat_number)) {

            return loadStringForJson("overpopulate");
        }
        return true;
    }
    public function insertUserToDb(): string | bool
    {
        $connection = singlePdoConnection();
        $allTestPassed = $this->checkEmptyValue();
        if ($allTestPassed ){
            return $connection->insertToDb($this->email, $this->name, $this->surname, $this->password, $this->vat_number);
        }
        return false;
    }
    public function retrieveUser(): bool
    {
        $connection = singlePdoConnection();
        if ($connection->getUser($this->email,$this->password)){
            return true;
        }
        return false;
    }
}




