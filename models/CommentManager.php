<?php
include_once "PDO.php";

function GetOneCommentFromId($id)
{
  global $PDO;
  $response = $PDO->prepare("SELECT * FROM comment WHERE id = :id ");
  $response->execute(
    array(
      "id" => $id
    )
  );
  return $response->fetch();
}

function GetAllComments()
{
  global $PDO;

  $stmt = $PDO->prepare("SELECT * FROM comment ORDER BY created_at ASC");
  $stmt->execute();
  return $stmt->fetchAll();
}

function GetAllCommentsFromUserId($userId)
{
  global $PDO;

  $stmt = $PDO->prepare(
    "SELECT comment.*, user.nickname "
      . "FROM comment LEFT JOIN user on (comment.user_id = user.id) "
      . "WHERE comment.user_id = :userId "
      . "ORDER BY comment.created_at ASC"
  );
  $stmt->execute([':userId' => $userId]);
  return $stmt->fetchAll();
}

function GetAllCommentsFromPostId($postId)
{
  global $PDO;

  $stmt = $PDO->prepare(
    "SELECT comment.*, user.nickname "
      . "FROM comment LEFT JOIN user on (comment.user_id = user.id) "
      . "WHERE comment.post_id = :postId "
      . "ORDER BY comment.created_at ASC"
  );
  $stmt->execute([':postId' => $postId]);
  return $stmt->fetchAll();
}

// models/CommentManager.php

function CreateNewComment($userId, $postId, $comment)
{
  global $PDO;

  $stmt = $PDO->prepare("INSERT INTO comment (user_id, post_id, content) VALUES (:userId, :postId, :comment)");
  $stmt->execute([
    ':userId' => $userId,
    ':postId' => $postId,
    ':comment' => $comment
  ]);

  return $stmt->rowCount() > 0;
}
