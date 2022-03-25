<?php
    class MysqliBaseRepository
    {
        protected $dbConn;

        public function __construct($mysqliDbConn)
        {
            $this->dbConn = $mysqliDbConn;
        }
    }
?>