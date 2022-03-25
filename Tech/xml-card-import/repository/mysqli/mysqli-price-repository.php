<?php
    include_once('mysqli-base-repository.php');
    include_once(REPOSITORY_INTERFACE_FOLDER.'/price-repository-interface.php');

    class MysqliPriceRepository extends MysqliBaseRepository implements IPriceRepository
    {
        private function GetData($sqlQuery, $paramTypes = "", $paramList = [])
        {
            $queryResult = $this->dbConn->Select($sqlQuery, $paramTypes, $paramList);

            $priceList = [];
            foreach ($queryResult as $row)
            {
                $price = new Price();

                $price->id = (int)$row['id'];
                $price->cardId = (string)$row['card_id'];
                $price->priceTypeId = (string)$row['price_type_id'];
                $price->currency = (string)$row['currency'];
                $price->vat = (string)$row['vat'];
                $price->sellingPrice = (float)$row['selling_price'];
                $price->sellingPriceWithoutVat = (float)$row['selling_price_without_vat'];
                $price->isDeleted = $row['is_deleted'];

                $priceList[] = $price;
            }

            return $priceList;
        }

        public function Add(Price &$price)
        {
            $sqlQuery =
            '
                INSERT INTO price
                    (card_id, price_type_id, currency, vat, selling_price, selling_price_without_vat, is_deleted)
                VALUES
                    (?, ?, ?, ?, ?, ?, ?);
            ';

            $paramList = [$price->cardId, $price->priceTypeId, $price->currency, $price->vat, $price->sellingPrice, $price->sellingPriceWithoutVat, $price->isDeleted];
            $paramTypes = 'iisiddi';

            $price->id = $this->dbConn->Insert($sqlQuery, $paramTypes, $paramList);
        }

        public function Get($id)
        {
            $sqlQuery =
            '
                SELECT *
                FROM price
                WHERE (id = ?)
            ';

            $paramList = [$id];
            $paramTypes = 'i';

            $priceList = $this->GetData($sqlQuery, $paramTypes, $paramList);

            if (sizeof($priceList) > 0)
                return $priceList[0];
            else
                return null;
        }

        public function GetAll()
        {
            $sqlQuery =
            '
                SELECT *
                FROM price
            ';

            $priceList = $this->GetData($sqlQuery);

            return $priceList;
        }

        public function GetAllForCardId($cardId)
        {
            $sqlQuery =
            '
                SELECT *
                FROM price
                WHERE (card_id = ?)
            ';

            $paramList = [$cardId];
            $paramTypes = 'i';

            $priceList = $this->GetData($sqlQuery, $paramTypes, $paramList);

            return $priceList;
        }
    }
?>