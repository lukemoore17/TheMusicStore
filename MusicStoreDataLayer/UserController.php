<?php
require_once("UserRepository.php");

/**
 * Controller to work with user data.
 *
 * @version 1.0
 * @author Luke
 */
class UserController
{
    private $repository;

    public function __construct($repository = null)
    {
        $this->repository = $repository;
        $this->repository = new UserRepository();
    }

    public function getAllAlbums()
    {
        return $this->repository->getAllAlbums();
    }

    public function getAlbumByAlbumID($albumID)
    {
        return $this->repository->getAlbumByAlbumID($albumID);
    }

    public function verifyCredentials($username, $password)
    {
        return $this->repository->verifyCredentials($username, $password);
    }

    public function getUserByUsername($username)
    {
        return $this->repository->getUserByUsername($username);
    }

    public function createNewUser($firstname, $lastname, $username, $password, $email)
    {
        return $this->repository->createNewUser($firstname, $lastname, $username, $password, $email);
    }

    public function updateUserInfo($customerID, $firstname, $lastname)
    {
        return $this->repository->updateUserInfo($customerID, $firstname, $lastname);
    }

    public function updateUserPassword($customerID, $password)
    {
        return $this->repository->updateUserPassword($customerID, $password);
    }

    public function checkIfUsernameExists($username)
    {
        return $this->repository->checkIfUsernameExists($username);
    }

    public function createNewAddress_ReturnAddressID($firstname, $lastname, $addressline1, $addressline2, $city, $state, $zip)
    {
        return $this->repository->createNewAddress_ReturnAddressID($firstname, $lastname, $addressline1, $addressline2, $city, $state, $zip);
    }

    public function createNewCustomerAddress($customerID, $addressID)
    {
        return $this->repository->createNewCustomerAddress($customerID, $addressID);
    }

    public function getCustomerAddressesByCustomerID($customerID)
    {
        return $this->repository->getCustomerAddressesByCustomerID($customerID);
    }

    public function getAddressByAddressID($addressID)
    {
        return $this->repository->getAddressByAddressID($addressID);
    }

    public function createNewCustomerOrder_ReturnOrderID($customerID, $shipAddressID, $billAddressID, $date)
    {
        return $this->repository->createNewCustomerOrder_ReturnOrderID($customerID, $shipAddressID, $billAddressID, $date);
    }

    public function createNewCustomerOrderItem($orderID, $albumID, $quantity)
    {
        return $this->repository->createNewCustomerOrderItem($orderID, $albumID, $quantity);
    }

    public function getCustomerOrdersByCustomerID($customerID)
    {
        return $this->repository->getCustomerOrdersByCustomerID($customerID);
    }

    public function getCustomerOrderItemsByOrderID($orderID)
    {
        return $this->repository->getCustomerOrderItemsByOrderID($orderID);
    }

    public function createNewGuest_ReturnGuestCustomerID($shipAddressID, $billAddressID)
    {
        return $this->repository->createNewGuest_ReturnGuestCustomerID($shipAddressID, $billAddressID);
    }

    public function createNewGuestOrder_ReturnOrderID($customerID, $date)
    {
        return $this->repository->createNewGuestOrder_ReturnOrderID($customerID, $date);
    }

    public function createNewGuestOrderItem($orderID, $albumID, $quantity)
    {
        return $this->repository->createNewGuestOrderItem($orderID, $albumID, $quantity);
    }
}

?>