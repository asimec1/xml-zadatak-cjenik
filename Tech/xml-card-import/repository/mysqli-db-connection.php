<?php

   class MysqliDbConnection
   {
        private $connection = null;

        function __construct($host = "localhost", $user = "root", $password = "", $database = DATABASE_NAME)
        {
            $this->connection = mysqli_connect($host, $user, $password, $database);
            if(mysqli_connect_errno() > 0)
                die('Error connecting to MySQL server.');
        }

        private function ExecuteStatmenet($query, $paramTypes = "", $params = [])
        {
            $stmt = $this->connection->prepare($query);
            if ($stmt == false)
                die('Error: '.$this->connection->errno.' '.$this->connection->error);

            if($params)
                $stmt->bind_param($paramTypes, ...$params);
            
            $stmt->execute();

            return $stmt;
        }

        function Insert($query, $paramTypes = "", $params = [])
        {
            $stmt = $this->ExecuteStatmenet($query, $paramTypes, $params);
            $stmt->close();
            return $this->connection->insert_id;
        }

        function Select($query, $paramTypes = "", $params = [])
        {
            $stmt = $this->ExecuteStatmenet($query, $paramTypes, $params);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $result;
        }
   }
?>