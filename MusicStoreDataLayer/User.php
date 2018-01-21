<?php
class User
{
    public $CustomerID;
    public $Username;
    public $FirstName;
    public $LastName;
    //public $email;

    public function __construct($data = null)
    {
        if (is_array($data))
        {
            if (isset($data['CustomerID'])) $this->CustomerID = $data['CustomerID'];

            $this->Username = $data['Username'];
            $this->FirstName = $data['FirstName'];
            $this->LastName = $data['LastName'];
            //$this->Email = $data['Email'];
        }
    }

    public function getFullname()
    {
        echo $this->FirstName . ' ' . $this->LastName;
    }
}
?>