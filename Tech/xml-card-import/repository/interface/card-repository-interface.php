<?php
    interface ICardRepository
    {
        public function Add(Card &$card);
        public function Get($id);
        public function GetAll();
    }
?>