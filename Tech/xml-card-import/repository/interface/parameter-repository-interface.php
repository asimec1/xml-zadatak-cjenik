<?php
    interface IParameterRepository
    {
        public function Add(Parameter &$parameter);
        public function Get($id);
        public function GetAll();
        public function GetAllForCardId($cardId);
    }
?>