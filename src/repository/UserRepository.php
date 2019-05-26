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
            $sql = "SELECT id, mobile_number, name, address FROM users WHERE mobile_number = ? AND password = ?";
            $params = array($username, md5($password));

            $query = $this->connection->prepare($sql);
            $query->execute($params);
            $query->setFetchMode(PDO::FETCH_ORI_FIRST);
            $record = $query->fetch();

            $userDetails = array(
                'id' => $record['id'],
                'username' => $record['mobile_number'],
                'name'     => $record['name'],
                'address'  => $record['address']
            );

        } catch (\Exception $e) {
            throw $e;
        }

        return $userDetails;
    }

    /**
     *  Function to SignUp New User.
     *
     * @param string $name
     * @param string $pass
     * @param string $address
     * @param string $mobile
     *
     * @return bool
     */
    public function signUp($name, $pass, $address, $mobile)
    {
        $name = '"'.$name.'"';
        $pass = '"'.md5($pass).'"';
        $address = '"'.$address.'"';
        $mobile = '"'.$mobile.'"';
        $insertUserSQL = 'INSERT INTO users(name, mobile_number, address, password) VALUES ('.
            implode(',', [$name, $mobile, $address, $pass]). ')'
        ;

        $this->connection->beginTransaction();
        $stmt = $this->connection->prepare($insertUserSQL);
        $stmt->execute();
        $this->connection->commit();
        $stmt = $this->connection->query("SELECT LAST_INSERT_ID()");
        $userId = $stmt->fetchColumn();

        return $userId;
    }
}