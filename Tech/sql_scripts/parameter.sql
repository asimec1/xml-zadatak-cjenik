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