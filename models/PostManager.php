<?php
include_once "PDO.php";

function GetOnePostFromId($id)
{
  global $PDO;

  $stmt = $PDO->prepare("SELECT * FROM post WHERE id = :id");
  $stmt->execute([':id' => $id]);
  return $stmt->fetch();
}

function GetAllPosts()
{
  global $PDO;

  $stmt = $PDO->prepare(
    "SELECT post.*, user.nickname "
      . "FROM post LEFT JOIN user on (post.user_id = user.id) "
      . "ORDER BY post.created_at DESC"
  );
  $stmt->execute();
  return $stmt->fetchAll();
}

function GetAllPostsFromUserId($userId)
{
  global $PDO;

  $stmt = $PDO->prepare("SELECT * FROM post WHERE user_id = :userId ORDER BY created_at DESC");
  $stmt->execute([':userId' => $userId]);
  return $stmt->fetchAll();
}

function SearchInPosts($search)
{
  global $PDO;
  $response = $PDO->prepare(
    "SELECT post.*, user.nickname "
      . "FROM post LEFT JOIN user on (post.user_id = user.id) "
      . "WHERE content like :search "
      . "ORDER BY post.created_at DESC"
  );
  $searchWithPercent = "%$search%";
  $response->execute(
    array(
      "search" => $searchWithPercent
    )
  );
  return $response->fetchAll();
}

function createNewPost($userId, $msg)
{
  global $PDO;

  $stmt = $PDO->prepare("INSERT INTO post (user_id, content) VALUES (:userId, :msg)");
  $stmt->execute([':userId' => $userId, ':msg' => $msg]);

  return $stmt->rowCount() > 0;
}
