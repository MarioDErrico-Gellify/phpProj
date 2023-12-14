<?php

include __DIR__ . '/utils/utilsFunction.php';

class UserService
{
    private PDO $pdo;

    public function __construct(string $password, string $host, string $port, string $dbName)
    {
        try {

            $this->pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbName;protocol=tcp", 'myuser', $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception(loadStringForJson("connectionFail") . $e->getMessage());
        }
    }
    public function getUser(string $email, string $password): bool
    {
        $sql = loadQueryString("login");
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row && password_verify($password, $row['password'])) {
                echo "Welcome " . $row['name'];
                return true;
            } else {
                echo loadStringForJson("userNotExist");
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function insertToDb(string $email, string $name, string $surname, string $password, string $vat_number): null| string
    {
        $vat_valid_number = vatValidationDrashosistvan($vat_number);
        if ($vat_valid_number){
            return loadStringForJson("vatIsNotValid");
        }
        $this->pdo->beginTransaction();
        $sql = loadQueryString("insert_new_user");
        try {
            $stmt = $this->pdo->prepare($sql);
            $hashedPassword = encryption($password);
            $stmt->execute([$email, $name, $surname, $hashedPassword, $vat_number]);
            $this->pdo->commit();
            return loadStringForJson("userAddedSuccessfully");
        } catch (PDOException) {
            $this->pdo->rollBack();
            return loadStringForJson("userAlreadyExist" );
        }
    }
    public function updatePassword(string $password, string $email): bool
    {
        $this->pdo->beginTransaction();
        try {
            if (!$this->userExists($email)) {
                $this->pdo->rollBack();
                echo loadStringForJson("userNotExistPasswordReset");
                return false;
            }
            $hashedPassword = password_hash($password, PASSWORD_ARGON2I);

            $sql = loadQueryString("resetPassword");
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':hashedPassword', $hashedPassword);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $this->pdo->commit();
            echo loadStringForJson("updatedPassword");
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
            throw new Exception($e->getMessage());
        }
    }

    private function userExists(string $email): bool
    {
        $sql = loadQueryString("checkUserExists");
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }


}

