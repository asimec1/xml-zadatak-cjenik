<?php
    include_once('interface/price-type-data-provider-interface.php');

    class RepositoryPriceTypeDataProvider implements IPriceTypeDataProvider
    {
        private $priceTypeList = [];

        public function __construct(IPriceTypeRepository $priceTypeRepository)
        {
            $this->priceTypeList = $priceTypeRepository->GetAll();
        }

        public function GetData()
        {
            return $this->priceTypeList;
        }
    }
?>