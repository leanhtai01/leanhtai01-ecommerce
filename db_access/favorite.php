<?php
require_once(dirname(__DIR__) . "/conf/db.conf.php");

/**
 * Add product to favorite
 *
 * @param int $account_id Account's id
 *
 * @param int $product_id Product's id
 *
 * @return bool Return true on success, false otherwise
 */
function add_favorite($account_id, $product_id)
{
  global $pdo;

  $sql = "INSERT INTO favorites (account_id, product_id) VALUES "
    . "(:account_id, :product_id);";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    "account_id" => $account_id,
    "product_id" => $product_id
  ]);

  return $stmt->rowCount() > 0;
}
