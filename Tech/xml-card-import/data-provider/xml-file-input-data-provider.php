<?php
    include_once(DATA_PROVIDER_INTERFACE_FOLDER.'/input-data-provider-interface.php');
    include_once(MODEL_DATABASE_FOLDER.'/card.php');
    include_once(MODEL_DATABASE_FOLDER.'/picture.php');
    include_once(MODEL_DATABASE_FOLDER.'/parameter.php');
    include_once(MODEL_DATABASE_FOLDER.'/price.php');

    class XmlFileInputDataProvider implements IInputDataProvider
    {
        private $file;
        private $priceTypeArray;

        private $cardList = [];

        public function __construct($filePath, IPriceTypeDataProvider $priceTypeDataProvider)
        {
            $this->file = $filePath;
            $this->priceTypeArray = $priceTypeDataProvider->GetData();
            
            $this->ParseData();
        }

        public function ParsePictureValues($xmlPicture)
        {
            $picture = new Picture();

            $picture->pictureId = (string)$xmlPicture->pictureid;
            $picture->pictureDescription = (string)$xmlPicture->picturedescription;
            $picture->pictureFile = (string)$xmlPicture->picturefile;
            $picture->pictureDefault = (string)$xmlPicture->picturedefault;
            $picture->isDeleted = 0;

            return $picture;
        }

        public function ParseParameterValues($xmlParameter)
        {
            $parameter = new Parameter();

            $parameter->parId = (string)$xmlParameter->parid;
            $parameter->parCode = (string)$xmlParameter->parcode;
            $parameter->parCodeHr = (string)$xmlParameter->parcodeHR;
            $parameter->parName = (string)$xmlParameter->parname;
            $parameter->parNameHr = (string)$xmlParameter->parnameHR;
            $parameter->parValue = isset($xmlParameter->parvalue) ? (string)$xmlParameter->parvalue : null;
            $parameter->parValueHr = isset($xmlParameter->parvalueHR) ? (string)$xmlParameter->parvalueHR : null;
            $parameter->isDeleted = 0;

            return $parameter;
        }

        public function ParsePriceValues($xmlPrice)
        {
            $price = new Price();
            $priceTypeIndex = array_search($xmlPrice->getName(), array_column($this->priceTypeArray, 'elementName'));

            $price->priceTypeId = $this->priceTypeArray[$priceTypeIndex]->id;
            $price->currency = (string)$xmlPrice->currency;
            $price->vat = (string)$xmlPrice->vat;
            $price->sellingPrice = isset($xmlPrice->sellingprice) ? (float)$xmlPrice->sellingprice : null;
            $price->sellingPriceWithoutVat = isset($xmlPrice->sellingpricewithoutvat) ? (float)$xmlPrice->sellingpricewithoutvat : null;
            $price->isDeleted = 0;

            return $price;
        }

        private function ParseCardValues($xmlCard)
        {
            $card = new Card();

            $card->cardId = (string)$xmlCard->cardid;
            $card->code = (string)$xmlCard->code;
            $card->ean = isset($xmlCard->ean) ? (string)$xmlCard->ean : null;
            $card->name = (string)$xmlCard->name;
            $card->nameHr = (string)$xmlCard->nameHR;
            $card->text = isset($xmlCard->text) ? (string)$xmlCard->text : null;
            $card->storage = (string)$xmlCard->storage;
            $card->storageHr = (string)$xmlCard->storageHR;
            $card->description = isset($xmlCard->description) ? (string)$xmlCard->description : null;
            $card->manufacturer = isset($xmlCard->manufacturer) ? (string)$xmlCard->manufacturer : null;
            $card->count = (float)$xmlCard->count;
            $card->unit = (string)$xmlCard->unit;
            $card->mass = isset($xmlCard->mass) ? (float)$xmlCard->mass : null;
            $card->warranty = (int)$xmlCard->warranty;
            $card->action = isset($xmlCard->action) ? (string)$xmlCard->action : null;
            $card->isDeleted = 0;

            foreach($xmlCard->pictures->children() as $picture)
                $card->pictureList[] = $this->ParsePictureValues($picture);

            foreach($xmlCard->parameters->children() as $parameter)
                $card->parameterList[] = $this->ParseParameterValues($parameter);

            foreach($xmlCard->prices->children() as $price)
                $card->priceList[] = $this->ParsePriceValues($price);

            return $card;
        }

        private function ParseData()
        {
            $xmlCardData = simplexml_load_file($this->file) or die('Problem sa učitavanjem');
            foreach($xmlCardData as $card)
                $this->cardList[] = $this->ParseCardValues($card);
        }

        public function GetData()
        {
            return $this->cardList;
        }
    }
?>