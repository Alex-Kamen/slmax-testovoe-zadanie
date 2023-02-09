<?php

try {
    require_once(__DIR__ . '/User.php');
} catch (ErrorException $error) {
    exit();
}

class UserList
{
    private $idList;

    /**
     * UserList constructor.
     * @param $idList
     */
    public function __construct($connection, $condition)
    {
        $result = $connection->prepare("SELECT * FROM user WHERE"
            . " id " . $condition . " OR "
            . " name " . $condition . " OR "
            . " surname " . $condition . " OR "
            . " dateOfBirth " . $condition . " OR "
            . " gender " . $condition . " OR "
            . " city " . $condition);

        $result->execute();
        $this->idList = [];

        while ($row = $result->fetch()) {
            $this->idList[] = $row['id'];
        }
    }

    public function getUserList($connection)
    {
        $userList = [];

        foreach ($this->idList as $id) {
            $userList[] = new User($connection, $id);
        }

        return $userList;
    }

    public function delete($connection)
    {
        $userList = $this->getUserList($connection);

        foreach ($userList as $user) {
            $user->delete($connection);
        }
    }

    /**
     * @return mixed
     */
    public function getIdList()
    {
        return $this->idList;
    }

    /**
     * @param mixed $idList
     */
    public function setIdList($idList)
    {
        $this->idList = $idList;
    }
}


