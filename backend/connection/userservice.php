<?php

include __DIR__  . '/utils/loadStringForJson.php';

class UserService
{
    private string $password;
    private string $host;
    private string $port;
    private string $dbName;


    public function __construct(string $password, string $host, string $port, string $dbName)
    {
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;
        $this->dbName = $dbName;
        try {
            $pdo = new PDO("pgsql:host=$this->host;dbname=$this->dbName;port=$this->port", 'myuser', $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            return loadStringForJson("connectionFail" . $e->getMessage());

        }
        return null;
    }

    public function getUser(string $email, string $password): string | bool
    {
        $pdo = new PDO("pgsql:host=$this->host;dbname=$this->dbName;port=$this->port", 'myuser', $this->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = loadQueryString("login");
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $sha1 = md5($password);
            $stmt->bindParam(':hashedPassword', $sha1);
            $stmt->execute();
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                echo "Welcome " . $row['name'];
                return true;
            }else{
                echo loadStringForJson("userNotExist");
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return false;
    }
    public function insertToDb(string $email, string $name, string $surname, string $password, string $vat_number): null|string
    {
        $pdo = new PDO("pgsql:host=$this->host;dbname=$this->dbName;port=$this->port", 'myuser', $this->password);
        $pdo->beginTransaction();
        $sql = loadQueryString("insert_new_user");
        try {
            $stmt = $pdo->prepare($sql);
            $password_encryption = encryption($password);
            $stmt->execute([$email, $name, $surname, $password_encryption, $vat_number]);
            $pdo->commit();
            return loadStringForJson("userAddedSuccessfully");
        } catch (PDOException) {
            return loadStringForJson("userAlreadyExist");
        }
    }

}