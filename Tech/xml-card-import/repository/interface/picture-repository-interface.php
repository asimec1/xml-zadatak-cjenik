<?php
    interface IPictureRepository
    {
        public function Add(Picture &$picture);
        public function Get($id);
        public function GetAll();
        public function GetAllForCardId($cardId);
    }
?>