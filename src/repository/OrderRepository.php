<?php

require_once('BaseRepository.php');

class OrderRepository extends BaseRepository
{
    public function __construct($connection)
    {
        parent::__construct($connection);
    }

    /**
     *  Function to Create Order For User.
     *
     * @param array $items
     * @param array $cartInfo
     * @param string $userId
     *
     * @return integer
     */
    public function createNewOrder($items, $cartInfo, $userId)
    {
        $insertOrderSQL = 'INSERT INTO orders(total_amount, status, user_id) VALUES ('.
            implode(',', [0, '"INITIATED"', $userId]). ');'
        ;

        $this->connection->beginTransaction();
        $stmt = $this->connection->prepare($insertOrderSQL);
        $stmt->execute();
        $this->connection->commit();
        $stmt = $this->connection->query("SELECT LAST_INSERT_ID()");
        $orderId = $stmt->fetchColumn();

        if (!$orderId) {
            return false;
        }
        $insertOrderItemSQL = [];

        $totalBill = 0;
        foreach ($cartInfo as $id => $cartItem) {

            $itemTotalPrice = $items[$id]['price'] * $cartItem;

            $totalBill += $itemTotalPrice;

            $insertOrderItemSQL[] = 'INSERT INTO order_items(order_id, item_id, item_quantity) VALUES('.
                implode(', ', [$orderId, $id, $cartItem]). ');'
            ;
        }

        try {
            $this->connection->beginTransaction();
            foreach ($insertOrderItemSQL as $sql) {
                $stmt = $this->connection->prepare($sql);
                $stmt->execute();
            }

            $updateSQL = 'UPDATE orders SET total_amount = ?, status ="SUCCESS" WHERE id = ?';
            $stmt = $this->connection->prepare($updateSQL);
            $stmt->execute([$totalBill, $orderId]);

            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollback();
            return false;
        }

        return $orderId;
    }
}