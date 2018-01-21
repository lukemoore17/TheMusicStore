<?php
class Address
{
    public $AddressID;
    public $FirstName;
    public $LastName;
    public $AddressLine1;
    public $AddressLine2;
    public $City;
    public $State;
    public $Zip;

    public function __construct($data = null)
    {
        if (is_array($data))
        {
            if (isset($data['AddressID'])) $this->AddressID = $data['AddressID'];

            $this->FirstName = $data['FirstName'];
            $this->LastName = $data['LastName'];
            $this->AddressLine1 = $data['AddressLine1'];
            $this->AddressLine2 = $data['AddressLine2'];
            $this->City = $data['City'];
            $this->State = $data['State'];
            $this->Zip = $data['Zip'];
        }
    }
}
?>