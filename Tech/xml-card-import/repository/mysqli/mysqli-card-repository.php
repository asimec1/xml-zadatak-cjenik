<?php
    include_once(REPOSITORY_INTERFACE_FOLDER.'/card-repository-interface.php');
    include_once('mysqli-base-repository.php');
    include_once('mysqli-picture-repository.php');
    include_once('mysqli-parameter-repository.php');
    include_once('mysqli-price-repository.php');

    class MysqliCardRepository extends MysqliBaseRepository implements ICardRepository
    {
        private $pictureRepository;
        private $parameterRepository;
        private $priceRepository;

        public function __construct($mysqliDbConn)
        {
            parent::__construct($mysqliDbConn);

            $this->pictureRepository = new MysqliPictureRepository($this->dbConn);
            $this->parameterRepository = new MysqliParameterRepository($this->dbConn);
            $this->priceRepository = new MysqliPriceRepository($this->dbConn);
        }

        private function GetData($sqlQuery, $paramTypes = "", $paramList = [])
        {
            $queryResult = $this->dbConn->Select($sqlQuery, $paramTypes, $paramList);

            $cardList = [];
            foreach ($queryResult as $row)
            {
                $card = new Card();

                $card->id = (int)$row['id'];
                $card->cardId = (string)$row['card_id'];
                $card->code = (string)$row['code'];
                $card->ean = (string)$row['ean'];
                $card->name = (string)$row['name'];
                $card->nameHr = (string)$row['name_hr'];
                $card->text = (string)$row['text'];
                $card->storage = (string)$row['storage'];
                $card->storageHr = (string)$row['storage_hr'];
                $card->description = (string)$row['description'];
                $card->manufacturer = (string)$row['manufacturer'];
                $card->count = (float)$row['count'];
                $card->unit = (string)$row['unit'];
                $card->mass = (float)$row['mass'];
                $card->warranty = (int)$row['warranty'];
                $card->action = (string)$row['action'];
                $card->isDeleted = $row['is_deleted'];

                $card->pictureList = $this->pictureRepository->GetAllForCardId($card->id);
                $card->parameterList = $this->parameterRepository->GetAllForCardId($card->id);
                $card->priceList = $this->priceRepository->GetAllForCardId($card->id);

                $cardList[] = $card;
            }

            return $cardList;
        }

        public function Add(Card &$card)
        {
            $sqlQuery =
            '
                INSERT INTO card
                    (card_id, code, ean, name, name_hr, text, storage, storage_hr, description, manufacturer, count, unit, mass, warranty, action, is_deleted)
                VALUES
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
            ';

            $paramList = [$card->cardId, $card->code, $card->ean, $card->name, $card->nameHr, $card->text, $card->storage, $card->storageHr,
                $card->description, $card->manufacturer, $card->count, $card->unit, $card->mass, $card->warranty, $card->action, $card->isDeleted];
            $paramTypes = 'isssssssssdsdiii';

            $card->id = $this->dbConn->Insert($sqlQuery, $paramTypes, $paramList);

            for($i = 0; $i < sizeof($card->pictureList); $i++)
            {
                $card->pictureList[$i]->cardId = $card->id;
                $card->pictureList[$i]->id = $this->pictureRepository->Add($card->pictureList[$i]);
            }

            for($i = 0; $i < sizeof($card->parameterList); $i++)
            {
                $card->parameterList[$i]->cardId = $card->id;
                $card->parameterList[$i]->id = $this->parameterRepository->Add($card->parameterList[$i]);
            }

            for($i = 0; $i < sizeof($card->priceList); $i++)
            {
                $card->priceList[$i]->cardId = $card->id;
                $card->priceList[$i]->id = $this->priceRepository->Add($card->priceList[$i]);
            }
        }

        public function Get($id)
        {
            $sqlQuery =
            '
                SELECT *
                FROM card
                WHERE (id = ?)
            ';

            $paramList = [$id];
            $paramTypes = 'i';

            $cardList = $this->GetData($sqlQuery, $paramTypes, $paramList);

            if (sizeof($cardList) > 0)
                return $cardList[0];
            else
                return null;
        }

        public function GetAll()
        {
            $sqlQuery =
            '
                SELECT *
                FROM card
            ';

            $cardList = $this->GetData($sqlQuery);

            return $cardList;
        }
    }
?>