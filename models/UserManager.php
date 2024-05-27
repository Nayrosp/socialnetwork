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

  $stmt = $PDO->prepare("SELECT id, password FROM user WHERE nickname = :username");
  $stmt->execute([':username' => $username]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && $user['password'] === $password) {
    return $user['id'];
  } else {
    return -1;
  }
}
