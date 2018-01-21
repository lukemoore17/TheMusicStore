<?php
class OrderItem
{
    public $OrderItemID;
    public $OrderID;
    public $AlbumID;
    public $Quantity;

    public function __construct($data = null)
    {
        if (is_array($data))
        {
            if (isset($data['CustomerOrderItemID'])) $this->OrderItemID = $data['CustomerOrderItemID'];

            $this->OrderID = $data['CustomerOrderID'];
            $this->AlbumID = $data['AlbumID'];
            $this->Quantity = $data['Quantity'];
        }
    }
}
?>