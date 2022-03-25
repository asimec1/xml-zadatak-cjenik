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