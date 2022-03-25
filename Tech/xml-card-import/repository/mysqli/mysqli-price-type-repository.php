<?php
    include_once(REPOSITORY_INTERFACE_FOLDER.'/price-type-repository-interface.php');
    include_once('mysqli-base-repository.php');
    include_once(MODEL_DATABASE_FOLDER.'/price-type.php');

    class MysqliPriceTypeRepository extends MysqliBaseRepository implements IPriceTypeRepository
    {

        private function ParseDbData($dbData)
        {
            $priceType = new PriceType();

            $priceType->id = (int)$dbData['id'];
            $priceType->name = $dbData['name'];
            $priceType->elementName = $dbData['element_name'];
            $priceType->description = $dbData['description'];
            $priceType->isDeleted = $dbData['is_deleted'];

            return $priceType;
        }


        public function GetAll()
        {
            $sqlQuery = 'SELECT * FROM price_type WHERE (is_deleted = 0)';
            $result = $this->dbConn->Select($sqlQuery);

            $priceTypeList = [];
            foreach($result as $row)
                $priceTypeList[] = $this->ParseDbData($row);
            
            return $priceTypeList;
        }
    }
?>