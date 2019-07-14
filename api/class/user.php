<?php
// user class
// creating, modifing, and logging-in users

class USER
{
    private $con;
    private $table_name = "users";
    private $password_hash;

    public $error;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $token;



    public function __construct($db, $password_hash)
    {
        /*
            @param $db: Database connection (PDO)
            @param $password_hash: Hash alogrithm for password hashing
            @param return: nothing.
        */

        $this->con = $db;
        $this->password_hash = $password_hash;
    }

    private function checkForEmailDuplicate()
    {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = ? LIMIT 0, 1";
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(1, $this->email);

        $id = $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($id === false || $row["id"] == null) {
            return false;
        } else {
            $this->id = $row["id"];
            return true;
        }
    }

    private function checkForToken()
    {
        $query = "SELECT id FROM " . $this->table_name . " WHERE token = ? LIMIT 0, 1";
        $this->sanitze();
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(1, $this->token);

        $id = $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($id === false || $row["id"] == null) {
            return false;
        } else {
            return true;
        }
    }

    private function sanitze()
    {
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));

        //$this->password = htmlspecialchars(strip_tags($this->password));
    }

    private function hashPassword()
    {
        $this->password = password_hash($this->password, $this->password_hash);
    }

    public function validateToken()
    {
        if (!isset($this->token)) {
            $this->error = "No token set!";
            return false;
        }

        $query = "SELECT token FROM " . $this->table_name . " WHERE token = ? LIMIT 0, 1";
        $this->sanitze();
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(1, $this->token);

        $return = $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($return === false || $row["token"] == null) {
            $this->error = "Token invalid!";
            return false;
        }

        return true;
    }

    public function create()
    {
        // chech if first name is set
        if (!isset($this->firstname)) {
            $this->error = "No first name set";
            return false;
        }

        // check if last name is set
        if (!isset($this->lastname)) {
            $this->error = "No last name set";
            return false;
        }

        // check if email is set
        if (!isset($this->email)) {
            $this->error = "No email address set";
            return false;
        }

        // check if password is set
        if (!isset($this->password)) {
            $this->error = "No password set";
            return false;
        }

        // check if token is set
        if (!isset($this->token)) {
            $this->error = "No token set";
            return false;
        }

        // check if the user is permitted to create new users
        if (!$this->checkForToken()) {
            $this->error = "You are not permitted to create users!";
            return false;
        }

        // check if email already exists
        if ($this->checkForEmailDuplicate()) {
            // returns true, if email is already in database
            $this->error = "Email is already registered";
            return false;
        }


        // if all variables are set and the email is not already existing, do a registration:
        $query = "INSERT INTO 
                    " . $this->table_name . "
                SET
                    firstname = :firstname,
                    lastname = :lastname,
                    email = :email,
                    password = :password
                  ";

        $stmt = $this->con->prepare($query);
        $this->sanitze();
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":email", $this->email);
        $this->hashPassword();
        $stmt->bindPAram(":password", $this->password);

        if ($stmt->execute()) {
            if ($this->checkForEmailDuplicate()) {
                return true;
            } else {
                $this->error = "Something went wrong during inserting data to database";
                return false;
            }
        } else {
            $this->error = $stmt->errorInfo();
            return false;
        }
    }

    public function login()
    {
        // check if email is set
        if (!isset($this->email)) {
            $this->error = "No email address set";
            return false;
        }

        // check if password is set
        if (!isset($this->password)) {
            $this->error = "No password set";
            return false;
        }

        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? LIMIT 0, 1";
        $this->sanitze();
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(1, $this->email);

        $return = $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($return === false || $row == null) {
            $this->error = "User not found";
            return false;
        }



        if (!password_verify($this->password, $row['password'])) {
            $this->error = "Password invalid!";
            return false;
        }

        // get first & last name from database
        $this->firstname = $row["firstname"];
        $this->lastname = $row["lastname"];
        $this->id = $row["id"];

        // return successfull login
        return true;
    }

    public function updateToken()
    {
        if (!isset($this->token)) {
            $this->error = "No token set";
            return false;
        }

        if (!isset($this->id)) {
            $this->error = "No id set!";
            return false;
        }

        $query = "UPDATE " . $this->table_name . " SET token = :token WHERE id = :id";
        $this->sanitze();
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute() === false) {
            $this->error = $stmt->errorInfo();
            return false;
        }
        return true;
    }

    public function update()
    {
        if (!isset($this->id)) {
            $this->error = "No id set";
            return false;
        }


        if (isset($this->password)) {
            $query = "UPDATE " . $this->table_name . " 
            SET 
                firstname = :firstname,
                lastname = :lastname,
                password = :password
            WHERE 
                id = :id";
        } else {
            $query = "UPDATE " . $this->table_name . " 
                    SET 
                        firstname = :firstname,
                        lastname = :lastname
                    WHERE 
                        id = :id";
        }

        $this->sanitze();

        $stmt = $this->con->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);

        if (isset($this->password)) {
            $this->hashPassword();
            $stmt->bindParam(":password", $this->password);
        }


        if ($stmt->execute() === false) {
            $this->error = $stmt->errorInfo();
            return false;
        }

        return true;
    }
}
