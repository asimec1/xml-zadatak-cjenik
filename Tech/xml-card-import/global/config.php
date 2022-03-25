<?php

    define('ROOT_ADDRESS', '/xml-card-import'); //Site root address
    define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'].ROOT_ADDRESS); //Site root folder definition
    define('DATABASE_NAME', 'xml_import'); //Database name

    define('DATA_PROVIDER_FOLDER', SITE_ROOT.'/data-provider');
    define('DATA_PROVIDER_INTERFACE_FOLDER', SITE_ROOT.'/data-provider/interface');
    define('MODEL_FOLDER', SITE_ROOT.'/model');
    define('MODEL_DATABASE_FOLDER', SITE_ROOT.'/model/database');
    define('REPOSITORY_FOLDER', SITE_ROOT.'/repository');
    define('REPOSITORY_INTERFACE_FOLDER', SITE_ROOT.'/repository/interface');

?>