<?php
    class Card
    {
        public $id;
        public $cardId;
        public $code;
        public $ean;
        public $name;
        public $nameHr;
        public $text;
        public $storage;
        public $storageHr;
        public $description;
        public $manufacturer;
        public $count;
        public $unit;
        public $mass;
        public $warranty;
        public $action;
        public $isDeleted;

        public $pictureList = [];
        public $parameterList = [];
        public $priceList = [];
    }
?>