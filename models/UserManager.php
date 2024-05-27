<?php
include_once "PDO.php";

function GetOneUserFromId($id)
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM user WHERE id = $id");
  return $response->fetch();
}

function GetAllUsers()
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM user ORDER BY nickname ASC");
  return $response->fetchAll();
}

function GetUserIdFromUserAndPassword($username, $password)
{
  global $PDO;
  $response = $PDO->query("SELECT id, password FROM user WHERE nickname = '$username'");
  $user = $response->fetch(PDO::FETCH_ASSOC);
  if ($user && $user['password'] === $password) {
    return $user['id'];
  } else {
    return -1;
  }
}
