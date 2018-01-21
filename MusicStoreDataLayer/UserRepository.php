<?php
{
	/**
	 * Database repository for MusicStore DB.
	 *
	 * @version 1.0
	 * @author Luke
	 */
	class UserRepository extends PDO
	{
        private $connection;

        public function __construct(PDO $connection = null)
        {
            $this->connection = $connection;
            if ($this->connection === null)
            {
                $this->connection = new PDO(
                        'mysql:host=podolski.mysql.database.azure.com;dbname=music_store',
                        'lukas@podolski',
                        '77tuFfS1'
                    );
                $this->connection->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );
            }
        }

        public function getAllAlbums()
        {
            $sp = 'CALL my_spS_getAllAlbums()';
            $stmt = $this->connection->prepare($sp);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Album');
            return  $stmt->fetchAll();
        }

        public function getAlbumByAlbumID($albumID)
        {
            $sp = 'CALL my_spS_getAlbumByAlbumID(:aID)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':aID', $albumID);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Album');
            return  $stmt->fetch();
        }

        public function verifyCredentials($username, $password)
        {
            $verified = false;

        //    $stmt = $this->connection->prepare('
        //    SELECT
        //        username,
        //        password
        //     FROM shopper_login
        //     WHERE username = :username
        //       AND password = :password
        //');
            $sp = 'CALL my_spS_verifyCredentials(:un, :pw)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':un', $username);
            $stmt->bindParam(':pw', $password);
            $stmt->execute();

            $rowsReturned = $stmt->rowCount();
            $verified = ($rowsReturned === 1) ? true : false;

            return $verified;
        }

        public function getUserByUsername($username)
        {
            $sp = 'CALL my_spS_getUserByUsername(:un)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':un', $username);
            $stmt->execute();

            // Set the fetchmode to populate an instance of 'User'
            // This enables us to use the following:
            //     $user = $repository->find(1234);
            //     echo $user->firstname;
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $stmt->fetch();
        }

        public function createNewUser($firstname, $lastname, $username, $password, $email)
        {
            $userCreated = false;

            $sp = 'CALL my_spI_createNewUser(:fn, :ln, :un, :pw, :em)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':fn', $firstname);
            $stmt->bindParam(':ln', $lastname);
            $stmt->bindParam(':un', $username);
            $stmt->bindParam(':pw', $password);
            $stmt->bindParam(':em', $email);
            $stmt->execute();

            $userCreated = ($this->verifyCredentials($username, $password) === true) ? true : false;

            return $userCreated;
        }

        public function updateUserInfo($customerID, $firstname, $lastname)
        {
            $sp = 'CALL my_spU_customerInfo(:cID, :fn, :ln)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':cID', $customerID);
            $stmt->bindParam(':fn', $firstname);
            $stmt->bindParam(':ln', $lastname);
            $stmt->execute();
        }

        public function updateUserPassword($customerID, $password)
        {
            $sp = 'CALL my_spU_customerPassword(:cID, :pw)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':cID', $customerID);
            $stmt->bindParam(':pw', $password);
            $stmt->execute();
        }

        public function checkIfUsernameExists($username)
        {
            $exists = false;

            $sp = 'CALL my_spS_checkIfUsernameExists(:un)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':un', $username);
            $stmt->execute();

            $rowsReturned = $stmt->rowCount();
            $exists = ($rowsReturned === 1) ? true : false;

            return $exists;
        }

        public function createNewAddress_ReturnAddressID($firstname, $lastname, $addressline1, $addressline2, $city, $state, $zip)
        {
            $sp = 'CALL my_spI_createNewAddress_ReturnAddressID(:fn, :ln, :al1, :al2, :city, :st, :zip)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':fn', $firstname);
            $stmt->bindParam(':ln', $lastname);
            $stmt->bindParam(':al1', $addressline1);
            $stmt->bindParam(':al2', $addressline2);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':st', $state);
            $stmt->bindParam(':zip', $zip);
            $stmt->execute();

            $row = $stmt->fetch();
            return $row['AddressID'];
        }

        public function createNewCustomerAddress($customerID, $addressID)
        {
            $sp = 'CALL my_spI_createNewCustomerAddress(:cID, :aID)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':cID', $customerID);
            $stmt->bindParam(':aID', $addressID);
            $stmt->execute();
        }

        public function getCustomerAddressesByCustomerID($customerID)
        {
            $sp = 'CALL my_spS_getCustomerAddressesByCustomerID(:cID)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':cID', $customerID);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Address');
            return  $stmt->fetchAll();
        }

        public function getAddressByAddressID($addressID)
        {
            $sp = 'CALL my_spS_getAddressByAddressID(:aID)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':aID', $addressID);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Address');
            return  $stmt->fetch();
        }

        public function createNewCustomerOrder_ReturnOrderID($customerID, $shipAddressID, $billAddressID, $date)
        {
            $sp = 'CALL my_spI_createNewCustomerOrder_ReturnOrderID(:cID, :saID, :baID, :d)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':cID', $customerID);
            $stmt->bindParam(':saID', $shipAddressID);
            $stmt->bindParam(':baID', $billAddressID);
            $stmt->bindParam(':d', $date);
            $stmt->execute();

            $row = $stmt->fetch();
            return $row['OrderID'];
        }

        public function createNewCustomerOrderItem($orderID, $albumID, $quantity)
        {
            $sp = 'CALL my_spI_createNewCustomerOrderItem(:oID, :aID, :q)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':oID', $orderID);
            $stmt->bindParam(':aID', $albumID);
            $stmt->bindParam(':q', $quantity);
            $stmt->execute();
        }

        public function getCustomerOrdersByCustomerID($customerID)
        {
            $sp = 'CALL my_spS_getCustomerOrdersByCustomerID(:cID)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':cID', $customerID);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Order');
            return $stmt->fetchAll();
        }

        public function getCustomerOrderItemsByOrderID($orderID)
        {
            $sp = 'CALL my_spS_getCustomerOrderItemsByOrderID(:oID)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':oID', $orderID);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'OrderItem');
            return $stmt->fetchAll();
        }

        public function createNewGuest_ReturnGuestCustomerID($shipAddressID, $billAddressID)
        {
            $sp = 'CALL my_spI_createNewGuest_ReturnGuestCustomerID(:sID, :bID)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':sID', $shipAddressID);
            $stmt->bindParam(':bID', $billAddressID);
            $stmt->execute();

            $row = $stmt->fetch();
            return $row['GuestCustomerID'];
        }

        public function createNewGuestOrder_ReturnOrderID($customerID, $date)
        {
            $sp = 'CALL my_spI_createNewGuestOrder_ReturnOrderID(:cID, :d)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':cID', $customerID);
            $stmt->bindParam(':d', $date);
            $stmt->execute();

            $row = $stmt->fetch();
            return $row['OrderID'];
        }

        public function createNewGuestOrderItem($orderID, $albumID, $quantity)
        {
            $sp = 'CALL my_spI_createNewGuestOrderItem(:oID, :aID, :q)';
            $stmt = $this->connection->prepare($sp);
            $stmt->bindParam(':oID', $orderID);
            $stmt->bindParam(':aID', $albumID);
            $stmt->bindParam(':q', $quantity);
            $stmt->execute();
        }

        public function findAll()
        {
            $stmt = $this->connection->prepare('
            SELECT * FROM users
        ');
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');

            // fetchAll() will do the same as above, but we'll have an array. ie:
            //    $users = $repository->findAll();
            //    echo $users[0]->firstname;
            return $stmt->fetchAll();
        }

        public function save(\User $user)
        {
            // If the ID is set, we're updating an existing record
            if (isset($user->id))
            {
                return $this->update($user);
            }
            $stmt = $this->connection->prepare('
            INSERT INTO users
                (username, firstname, lastname, email)
            VALUES
                (:username, :firstname , :lastname, :email)
        ');
            $stmt->bindParam(':username', $user->username);
            $stmt->bindParam(':firstname', $user->firstname);
            $stmt->bindParam(':lastname', $user->lastname);
            $stmt->bindParam(':email', $user->email);
            return $stmt->execute();
        }

        public function update(\User $user)
        {
            if (!isset($user->id))
            {
                // We can't update a record unless it exists...
                throw new \LogicException(
                    'Cannot update user that does not yet exist in the database.'
                );
            }
            $stmt = $this->connection->prepare('
            UPDATE users
            SET username = :username,
                firstname = :firstname,
                lastname = :lastname,
                email = :email
            WHERE id = :id
        ');
            $stmt->bindParam(':username', $user->username);
            $stmt->bindParam(':firstname', $user->firstname);
            $stmt->bindParam(':lastname', $user->lastname);
            $stmt->bindParam(':email', $user->email);
            $stmt->bindParam(':id', $user->id);
            return $stmt->execute();
        }
	}
}

?>