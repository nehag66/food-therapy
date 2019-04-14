<?php

class ItemsRepository
{
    private $connection;

    public function __construct($connection)
    {
        if (empty($connection)) {
        	echo "No Connection found with DB";
        	die();
        }

        $this->connection = $connection;
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
        	$params[] = $category;
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
}