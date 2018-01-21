<?php
class Album
{
    public $AlbumID;
    public $AlbumName;
    public $Artist;
    public $Year;
    public $Price;
    public $ImageLink;

    public function __construct($data = null)
    {
        if (is_array($data))
        {
            if (isset($data['AlbumID'])) $this->AlbumID = $data['AlbumID'];

            $this->AlbumName = $data['AlbumName'];
            $this->Artist = $data['Artist'];
            $this->Year = $data['Year'];
            $this->Price = $data['Price'];
            $this->ImageLink = $data['ImageLink'];
        }
    }
}
?>