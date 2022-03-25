<?php

    class StoreInputData
    {
        private $cardRepository;

        public function __construct(ICardRepository $cardRepository)
        {
            $this->cardRepository = $cardRepository;
        }

        public function StoreInputData(IInputDataProvider $inputDataProvider)
        {
            $cardList = $inputDataProvider->GetData();

            for($i = 0; $i < sizeof($cardList); $i++)
                $this->cardRepository->Add($cardList[$i]);
        }
    }
?>