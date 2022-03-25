<?php
    include_once('mysqli-base-repository.php');
    include_once(REPOSITORY_INTERFACE_FOLDER.'/parameter-repository-interface.php');

    class MysqliParameterRepository extends MysqliBaseRepository implements IParameterRepository
    {
        private function GetData($sqlQuery, $paramTypes = "", $paramList = [])
        {
            $queryResult = $this->dbConn->Select($sqlQuery, $paramTypes, $paramList);

            $parameterList = [];
            foreach ($queryResult as $row)
            {
                $parameter = new Parameter();

                $parameter->id = (int)$row['id'];
                $parameter->parId = (string)$row['par_id'];
                $parameter->cardId = (string)$row['card_id'];
                $parameter->parCode = (string)$row['par_code'];
                $parameter->parCodeHr = (string)$row['par_code_hr'];
                $parameter->parName = (string)$row['par_name'];
                $parameter->parNameHr = (string)$row['par_name_hr'];
                $parameter->parValue = (string)$row['par_value'];
                $parameter->parValueHr = (string)$row['par_value_hr'];
                $parameter->isDeleted = $row['is_deleted'];

                $parameterList[] = $parameter;
            }

            return $parameterList;
        }

        public function Add(Parameter &$parameter)
        {
            $sqlQuery =
            '
                INSERT INTO parameter
                    (par_id, card_id, par_code, par_code_hr, par_name, par_name_hr, par_value, par_value_hr, is_deleted)
                VALUES
                    (?, ?, ?, ?, ?, ?, ?, ?, ?);
            ';

            $paramList = [$parameter->parId, $parameter->cardId, $parameter->parCode, $parameter->parCodeHr, $parameter->parName, $parameter->parNameHr,
                $parameter->parValue, $parameter->parValueHr, $parameter->isDeleted];
            $paramTypes = 'iissssssi';

            $parameter->id = $this->dbConn->insert($sqlQuery, $paramTypes, $paramList);
        }

        public function Get($id)
        {
            $sqlQuery =
            '
                SELECT *
                FROM parameter
                WHERE (id = ?)
            ';

            $paramList = [$id];
            $paramTypes = 'i';

            $parameterList = $this->GetData($sqlQuery, $paramTypes, $paramList);

            if (sizeof($parameterList) > 0)
                return $parameterList[0];
            else
                return null;
        }

        public function GetAll()
        {
            $sqlQuery =
            '
                SELECT *
                FROM parameter
            ';

            $parameterList = $this->GetData($sqlQuery);

            return $parameterList;
        }

        public function GetAllForCardId($cardId)
        {
            $sqlQuery =
            '
                SELECT *
                FROM parameter
                WHERE (card_id = ?)
            ';

            $paramList = [$cardId];
            $paramTypes = 'i';

            $parameterList = $this->GetData($sqlQuery, $paramTypes, $paramList);

            return $parameterList;
        }
    }
?>