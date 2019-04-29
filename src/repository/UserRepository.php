<?php

require_once('BaseRepository.php');


class UserRepository extends BaseRepository
{
    public function __construct($connection)
    {
        parent::__construct($connection);
    }

    /**
     *  Function to validate credentials of user.
     *
     * @param $username
     * @param $password
     *
     * @return array
     * @throws \Exception
     */
    public function validateCredentials($username, $password)
    {
        $userDetails = null;
        try {
            $sql = "SELECT mobile_number, name, address FROM users WHERE mobile_number = ? AND password = ?";
            $params = array($username, md5($password));

            $query = $this->connection->prepare($sql);
            $query->execute($params);
            $query->setFetchMode(PDO::FETCH_ORI_FIRST);
            $record = $query->fetch();

            $userDetails = array(
                'username' => $record['mobile_number'],
                'name'     => $record['name'],
                'address'  => $record['address']
            );

        } catch (\Exception $e) {
            throw $e;
        }

        return $userDetails;
    }
}