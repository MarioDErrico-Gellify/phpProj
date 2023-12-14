<?php

use VatValidation\VatValidation;

function loadStringForJson(string $message): string{
    $fileJsonPath = file_get_contents(__DIR__ . '/testString.json');
    $data = json_decode($fileJsonPath, true);
    return $data[$message];
}

function loadQueryString(string $query) : string{
    $fileJsonPath = file_get_contents(__DIR__ . '/query.json');
    $data = json_decode($fileJsonPath, true);
    return $data[$query];
}

function encryption(string $password ): string{
    return password_hash($password , PASSWORD_ARGON2I);
}

function singlePdoConnection(): UserService {
    return new UserService("mypassword", "insertip", "3306", "mydatabase");
}

function vatValidationDrashosistvan(string $vatNumber) : bool{
    $validation = new VatValidation();
    $validation->validate($vatNumber);
    if ($validation->valid) {
        return true;
    }
    return false;
}


