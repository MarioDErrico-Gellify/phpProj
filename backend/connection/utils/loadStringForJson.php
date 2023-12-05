<?php
function loadStringForJson(string $message): string{
    $fileJsonPath = file_get_contents(__DIR__ . '/param.json');
    $data = json_decode($fileJsonPath, true);
    return $data[$message];
}

function loadQueryString(string $query) : string{
    $fileJsonPath = file_get_contents(__DIR__ . '/query.json');
    $data = json_decode($fileJsonPath, true);
    return $data[$query];
}

function encryption(string $password ): string{
    return md5($password);
}

function  singlePdoConnection(): UserService | PDO{
    return new UserService("mypassword" , "postgres" , "5432" , "mydatabase");
}



