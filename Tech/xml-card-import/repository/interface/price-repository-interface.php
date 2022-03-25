<?php
    interface IPriceRepository
    {
        public function Add(Price &$price);
        public function Get($id);
        public function GetAll();
        public function GetAllForCardId($cardId);
    }
?>