<?php
    include_once('mysqli-base-repository.php');
    include_once(REPOSITORY_INTERFACE_FOLDER.'/picture-repository-interface.php');

    class MysqliPictureRepository extends MysqliBaseRepository implements IPictureRepository
    {
        private function GetData($sqlQuery, $paramTypes = "", $paramList = [])
        {
            $queryResult = $this->dbConn->Select($sqlQuery, $paramTypes, $paramList);

            $pictureList = [];
            foreach ($queryResult as $row)
            {
                $picture = new Picture();

                $picture->id = (int)$row['id'];
                $picture->pictureId = (string)$row['picture_id'];
                $picture->cardId = (string)$row['card_id'];
                $picture->pictureDescription = (string)$row['picture_description'];
                $picture->pictureFile = (string)$row['picture_file'];
                $picture->pictureDefault = (string)$row['picture_default'];
                $picture->isDeleted = $row['is_deleted'];

                $pictureList[] = $picture;
            }

            return $pictureList;
        }

        public function Add(Picture &$picture)
        {
            $sqlQuery =
            '
                INSERT INTO picture
                    (picture_id, card_id, picture_description, picture_file, picture_default, is_deleted)
                VALUES
                    (?, ?, ?, ?, ?, ?);
            ';

            $paramList = [$picture->pictureId, $picture->cardId, $picture->pictureDescription, $picture->pictureFile, $picture->pictureDefault, $picture->isDeleted];
            $paramTypes = 'iissii';

            $picture->id = $this->dbConn->insert($sqlQuery, $paramTypes, $paramList);
        }

        public function Get($id)
        {
            $sqlQuery =
            '
                SELECT *
                FROM picture
                WHERE (id = ?)
            ';

            $paramList = [$id];
            $paramTypes = 'i';

            $pictureList = $this->GetData($sqlQuery, $paramTypes, $paramList);

            if (sizeof($pictureList) > 0)
                return $pictureList[0];
            else
                return null;
        }

        public function GetAll()
        {
            $sqlQuery =
            '
                SELECT *
                FROM picture
            ';

            $pictureList = $this->GetData($sqlQuery);

            return $pictureList;
        }

        public function GetAllForCardId($cardId)
        {
            $sqlQuery =
            '
                SELECT *
                FROM picture
                WHERE (card_id = ?)
            ';

            $paramList = [$cardId];
            $paramTypes = 'i';

            $pictureList = $this->GetData($sqlQuery, $paramTypes, $paramList);

            return $pictureList;
        }
    }
?>