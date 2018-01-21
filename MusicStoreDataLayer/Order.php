<?php
class Order
{
    public $OrderID;
    public $ShipAddressID;
    public $BillAddressID;
    public $Date;

    public function __construct($data = null)
    {
        if (is_array($data))
        {
            if (isset($data['OrderID'])) $this->OrderID = $data['OrderID'];

            $this->ShipAddressID = $data['ShipAddressID'];
            $this->BillAddressID = $data['BillAddressID'];
            $this->Date = $data['Date'];
        }
    }
}
?>