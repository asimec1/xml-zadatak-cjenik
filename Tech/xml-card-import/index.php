<?php
    include_once('global/config.php');
    include_once('repository/mysqli-db-connection.php');
    include_once('data-provider/repository-price-type-data-provider.php');
    include_once('repository/mysqli/mysqli-price-type-repository.php');
    include_once('data-provider/xml-file-input-data-provider.php');
    include_once('model/store-input-data.php');
    include_once('repository/mysqli/mysqli-card-repository.php');

    $dbConn = new MysqliDbConnection();
    $priceTypeDataProvider = new RepositoryPriceTypeDataProvider(new MysqliPriceTypeRepository($dbConn));
    $inputDataProvider = new XmlFileInputDataProvider('ExportZasobUniversalEN2019.xml', $priceTypeDataProvider);
    $cardRepository = new MysqliCardRepository($dbConn);
    $storeDataObject = new StoreInputData($cardRepository);
    $storeDataObject->StoreInputData($inputDataProvider);

    echo '<p><h2>Gotovo!</h2></p>';

    $card = $cardRepository->Get(1);
    print_r($card);
?>