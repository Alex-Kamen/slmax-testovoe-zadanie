<?php
require_once(__DIR__ . '/User.php');
require_once(__DIR__ . '/UserList.php');

$login = 'root';
$password = 'root';
$dataBase = 'slmax-testovoe-zadanie';
$host = 'localhost';

$connection = new PDO("mysql:host=" . $host . ";dbname=" . $dataBase, $login, $password);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// operations with class User

new User($connection, '1', 'Alex', 'Grigoriev', '2003-11-05', 1, 'Minsk');
new User($connection, '2', 'Evgeniy', 'Sidorov', '2003-11-05', 1, 'Vitebsk');

$userA = new User($connection, '3', 'Ivan', 'Ivanov', '2003-11-05', 1, 'Gomel');
$userB = new User($connection, '2');

$userA->setName('Sergei');
$userA->save($connection);

$userB->delete($connection);

echo "<pre>";
print_r($userA->formatUser(true, true));
echo "</pre>";

// operations with class UserList

/*$userList = new UserList($connection, "= 'Alex'");

$userList->getUserList($connection);

echo "<pre>";
print_r($userList->getUserList($connection));
echo "</pre>";

$userList->delete();*/



