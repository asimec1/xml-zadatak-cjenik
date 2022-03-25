SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS xml_import DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE xml_import;


-- card table
CREATE OR REPLACE TABLE card
(
	id int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    , card_id int UNSIGNED NOT NULL
    , code varchar(10) NOT NULL
	, ean varchar(30) NULL
	, name varchar(100) NOT NULL
	, name_hr varchar(100) NOT NULL
	, text varchar(255) NULL
	, storage varchar(100) NOT NULL
	, storage_hr varchar(100) NOT NULL
	, description varchar(1000) NULL
    , manufacturer varchar(100) NULL
    , count double(10, 2) NOT NULL
    , unit varchar(20) NOT NULL
    , mass double(10, 2) NULL
    , warranty smallint NOT NULL
    , action tinyint UNSIGNED NULL
    , is_deleted boolean NOT NULL DEFAULT(false)
);



-- price_type table
CREATE OR REPLACE TABLE price_type
(
	id int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    , name varchar(30) NOT NULL
    , element_name varchar(50) NOT NULL
    , description varchar(255) NULL
    , is_deleted boolean NOT NULL DEFAULT(false)
);

INSERT INTO price_type
    (name, element_name)
VALUES
    ('Normal price', 'price')
    , ('Action price', 'actionprice')
    , ('Original price', 'originalprice');



-- picture table
CREATE OR REPLACE TABLE picture
(
	id int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
	, picture_id int UNSIGNED NOT NULL
    , card_id int UNSIGNED NOT NULL
	, picture_description varchar(255) NOT NULL
	, picture_file varchar(100) NOT NULL
	, picture_default tinyint UNSIGNED NOT NULL
    , is_deleted boolean NOT NULL DEFAULT(false)
);

ALTER TABLE picture
ADD CONSTRAINT fk_picture_card FOREIGN KEY(card_id) REFERENCES card (id) ON DELETE CASCADE ON UPDATE RESTRICT;



-- parameter table
CREATE OR REPLACE TABLE parameter
(
	id int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    , par_id int UNSIGNED NOT NULL
    , card_id int UNSIGNED NOT NULL
	, par_code varchar(30) NOT NULL
	, par_code_hr varchar(30) NOT NULL
	, par_name varchar(100) NOT NULL
	, par_name_hr varchar(100) NOT NULL
	, par_value varchar(50) NULL
    , par_value_hr varchar(50) NULL
    , is_deleted boolean NOT NULL DEFAULT(false)
);

ALTER TABLE parameter
ADD CONSTRAINT fk_parameter_card FOREIGN KEY(card_id) REFERENCES card (id) ON DELETE CASCADE ON UPDATE RESTRICT;



-- price table
CREATE OR REPLACE TABLE price
(
	id int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    , card_id int UNSIGNED NOT NULL
    , price_type_id int UNSIGNED NOT NULL
	, currency varchar(30) NOT NULL
	, vat tinyint UNSIGNED NOT NULL
	, selling_price double(10, 2) NULL
	, selling_price_without_vat double(10, 2) NULL
    , is_deleted boolean NOT NULL DEFAULT(false)
);

ALTER TABLE price
ADD CONSTRAINT fk_price_card FOREIGN KEY(card_id) REFERENCES card (id) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE price
ADD CONSTRAINT fk_price_price_type FOREIGN KEY(price_type_id) REFERENCES price_type (id) ON DELETE CASCADE ON UPDATE RESTRICT;