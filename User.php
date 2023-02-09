<?php

class User
{
    private $id;
    private $name;
    private $surname;
    private $dateOfBirth;
    private $gender;
    private $city;

    /**
     * User constructor.
     * @param $id
     * @param $name
     * @param $surname
     * @param $dateOfBirth
     * @param $gender
     * @param $city
     */
    public function __construct(
        $connection,
        $id,
        $name = null,
        $surname = null,
        $dateOfBirth = null,
        $gender = null,
        $city = null
    )
    {
        $result = $connection->prepare("SELECT * FROM user WHERE id = :id");
        $result->bindParam(":id", $id, PDO::PARAM_STR);

        $result->execute();
        $user = $result->fetch();

        if ($user) {
            $this->id = $user["id"];
            $this->name = $user["name"];
            $this->surname = $user["surname"];
            $this->dateOfBirth = $user["dateOfBirth"];
            $this->gender = $user["gender"];
            $this->city = $user["city"];
        } else {
            $this->id = $id;
            $this->name = $name;
            $this->surname = $surname;
            $this->dateOfBirth = $dateOfBirth;
            $this->gender = $gender;
            $this->city = $city;

            $this->validateUser();

            $result = $connection->prepare("INSERT INTO user"
                . " VALUES ("
                . " :id, "
                . " :name, "
                . " :surname, "
                . " :dateOfBirth, "
                . " :gender, "
                . " :city)");

            $result->bindParam(":id", $this->id, PDO::PARAM_INT);
            $result->bindParam(":name", $this->name, PDO::PARAM_STR);
            $result->bindParam(":surname", $this->surname, PDO::PARAM_STR);
            $result->bindParam(":dateOfBirth", $this->dateOfBirth, PDO::PARAM_STR);
            $result->bindParam(":gender", $this->gender, PDO::PARAM_INT);
            $result->bindParam(":city", $this->city, PDO::PARAM_STR);
            $result->execute();
        }
    }

    public function save($connection)
    {
        $result = $connection->prepare("UPDATE user"
            . " SET "
            . " id = :id, "
            . " name = :name, "
            . " surname = :surname, "
            . " dateOfBirth = :dateOfBirth, "
            . " gender = :gender, "
            . " city = :city");

        $result->bindParam(":id", $this->id, PDO::PARAM_INT);
        $result->bindParam(":name", $this->name, PDO::PARAM_STR);
        $result->bindParam(":surname", $this->surname, PDO::PARAM_STR);
        $result->bindParam(":dateOfBirth", $this->dateOfBirth, PDO::PARAM_STR);
        $result->bindParam(":gender", $this->gender, PDO::PARAM_INT);
        $result->bindParam(":city", $this->city, PDO::PARAM_STR);
        $result->execute();
    }

    public function delete($connection)
    {
        $result = $connection->prepare("DELETE FROM user WHERE id = :id");
        $result->bindParam(":id", $this->id, PDO::PARAM_INT);
        $result->execute();
    }

    public static function getAge($dateOfBirth)
    {
        return floor((microtime(true) - strtotime($dateOfBirth)) / (60 * 60 * 24 * 30 * 12));
    }

    public static function formatGender($gender)
    {
        return $gender == 0 ? 'Муж' : 'Жен';
    }

    public function formatUser($formatGender = false, $formatAge = false)
    {
        $user = new stdClass();

        $user->id = $this->id;
        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->dateOfBirth = $this->dateOfBirth;
        $user->gender = $formatGender ? User::formatGender($this->gender) : $this->gender;
        $user->city = $this->city;

        if ($formatAge) {
            $user->age = User::getAge($this->dateOfBirth);
        }

        return $user;
    }

    private function validateUser()
    {
        $this->validateField($this->id, "/^[0-9]+$/", "Invalid id");
        $this->validateField($this->name, "/^[A-Za-zА-Яа-я]+$/", "Invalid name");
        $this->validateField($this->surname, "/^[A-Za-zА-Яа-я]+$/", "Invalid surname");
        $this->validateField($this->gender, "/^[0-9]{1}$/", "Invalid gender");
        $this->validateField($this->dateOfBirth, "/^\d{4}-\d{1,2}-\d{1,2}$/", "Invalid date of birth");
    }

    private function validateField($value, $regexp, $message)
    {
        if (!preg_match($regexp, $value)) {
            throw new ErrorException($message);
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param mixed $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }
}