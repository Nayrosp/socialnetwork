<?php
include_once "PDO.php";

function GetOneUserFromId($id)
{
  global $PDO;

  $stmt = $PDO->prepare("SELECT * FROM user WHERE id = :id");
  $stmt->execute([':id' => $id]);
  return $stmt->fetch();
}

function GetAllUsers()
{
  global $PDO;

  $stmt = $PDO->prepare("SELECT * FROM user ORDER BY nickname ASC");
  $stmt->execute();
  return $stmt->fetchAll();
}

function GetUserIdFromUserAndPassword($username, $password)
{
  global $PDO;
  $response = $PDO->prepare("SELECT id FROM user WHERE nickname = :username AND password = MD5(:password) ");
  $response->execute(
    array(
      "username" => $username,
      "password" => $password
    )
  );
  if ($response->rowCount() == 1) {
    $row = $response->fetch();
    return $row['id'];
  } else {
    return -1;
  }
}

function IsNicknameFree($nickname)
{
  global $PDO;
  $response = $PDO->prepare("SELECT * FROM user WHERE nickname = :nickname ");
  $response->execute(
    array(
      "nickname" => $nickname
    )
  );
  return $response->rowCount() == 0;
}

function CreateNewUser($nickname, $password)
{
  global $PDO;
  $response = $PDO->prepare("INSERT INTO user (nickname, password) values (:nickname , MD5(:password) )");
  $response->execute(
    array(
      "nickname" => $nickname,
      "password" => $password
    )
  );
  return $PDO->lastInsertId();
}
