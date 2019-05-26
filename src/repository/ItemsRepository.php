<?php

require_once('BaseRepository.php');

class ItemsRepository extends BaseRepository
{
    public function __construct($connection)
    {
        parent::__construct($connection);
    }

    /**
     *  Function to get the list of items
     *
     */
    public function getPaginationItems($category = '', $page = 1, $noRecords = 10)
    {
        $params = array();
        $sql = 'SELECT id, item_name, price, quantity, image, category FROM items i';

        if (!empty($category)) {
            $sql .= ' WHERE category = ?';
            array_push($params, $category);
        }

        $offset = ($page - 1) * $noRecords;

        $sql .= ' LIMIT '. $offset. ', '.$noRecords;

        $query = $this->connection->prepare($sql);
        $query->execute($params);
        $query->setFetchMode(PDO::FETCH_ASSOC);

        $items = array();

        while ($record = $query->fetch()) {
            $newItem = array(
                'id' => $record['id'],
                'name' => $record['item_name'],
                'price' => $record['price'],
                'quantity' => $record['quantity'],
                'image_url' => $record['image'],
                'category' => $record['category']
            );
            if (empty($items[$record['category']])) {
                $items[$record['category']] = array();
            }

            array_push($items[$record['category']], $newItem);
        }

        return $items;
    }

    /**
     *  Function to get the item details
     *
     * @param array $itemIds
     *
     * @return array
     */
    public function getItemsDetail($itemIds)
    {
        if (empty($itemIds) || !is_array($itemIds)) {
            return [];
        }

        $params = array();
        $sql = 'SELECT id, item_name, price, quantity, image, category FROM items WHERE id IN ('.
            implode(', ', $itemIds).')'
        ;

        $query = $this->connection->prepare($sql);
        $query->execute($params);
        $query->setFetchMode(PDO::FETCH_ASSOC);

        $items = array();

        while ($record = $query->fetch()) {
            $item = array(
                'id' => $record['id'],
                'name' => $record['item_name'],
                'price' => $record['price'],
                'quantity' => $record['quantity'],
                'image_url' => $record['image'],
                'category' => $record['category']
            );

            $items[$record['id']]=  $item;
        }

        return $items;
    }
}