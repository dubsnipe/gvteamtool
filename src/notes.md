# Databse and Migrations

```mysql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created DATETIME,
    modified DATETIME
);

CREATE TABLE brigadas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  created datetime NOT NULL,
  modified datetime NOT NULL,
  name varchar(255) DEFAULT NULL,
  arrival date DEFAULT NULL,
  departure date DEFAULT NULL,
  gvCode varchar(255) DEFAULT NULL,
  agencia varchar(255) DEFAULT NULL,
  proyecto varchar(255) DEFAULT NULL,
  municipioConstru varchar(255) DEFAULT NULL,
  departamentoConstru varchar(255) DEFAULT NULL,
  albañil varchar(255) DEFAULT NULL,
  familiaSocia varchar(255) DEFAULT NULL,
  comentarios varchar(255) DEFAULT NULL,
  sendingProgram varchar(255) DEFAULT NULL,
  evento varchar(45) DEFAULT NULL,
  tipoBrigada varchar(45) DEFAULT NULL,
  encargado varchar(45) DEFAULT NULL,
  traductor varchar(45) DEFAULT NULL,
  status tinyint(1) DEFAULT '1',
  funds_budgeted decimal(15,2),
  funds_received decimal(15,2)
) CHARSET=utf8mb4;

CREATE TABLE voluntarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  created datetime NOT NULL,
  modified datetime NOT NULL,
  status tinyint(1) DEFAULT '1',
  firstName varchar(255) DEFAULT NULL,
  lastName varchar(255) DEFAULT NULL,
  birth date DEFAULT NULL,
  state varchar(255) DEFAULT NULL,
  residenceCountry varchar(255) DEFAULT NULL,
  phone varchar(255) DEFAULT NULL,
  passportNumber varchar(255) DEFAULT NULL,
  passportCountry varchar(255) DEFAULT NULL,
  postalCode varchar(255) DEFAULT NULL,
  spanishLevel varchar(255) DEFAULT NULL,
  gender varchar(255) DEFAULT NULL,
  tShirt varchar(255) DEFAULT NULL,
  emergencyContact varchar(255) DEFAULT NULL,
  emergencyNumber varchar(255) DEFAULT NULL,
  dietaryRestrictions varchar(255) DEFAULT NULL,
  email varchar(255) DEFAULT NULL,
  allergies varchar(255) DEFAULT NULL,
  healthConsiderations varchar(255) DEFAULT NULL
  middleName varchar(255) DEFAULT NULL,
  city varchar(255) DEFAULT NULL,
  address varchar(255) DEFAULT NULL,
) CHARSET=utf8mb4;

CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(191),
    created DATETIME,
    modified DATETIME,
    UNIQUE KEY (title)
) CHARSET=utf8mb4;

CREATE TABLE brigadas_tags (
    brigada_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (brigada_id, tag_id),
    FOREIGN KEY tag_key(tag_id) REFERENCES tags(id),
    FOREIGN KEY brigada_key(brigada_id) REFERENCES brigadas(id)
);

CREATE TABLE brigadas_voluntarios (
    brigada_id INT NOT NULL,
    voluntario_id INT NOT NULL,
    PRIMARY KEY (brigada_id, voluntario_id),
    FOREIGN KEY voluntario_key	(voluntario_id) REFERENCES voluntarios(id),
    FOREIGN KEY brigada_key(brigada_id) REFERENCES brigadas(id)
);

// Nueva versión
CREATE TABLE participaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brigada_id INT NOT NULL,
    voluntario_id INT NOT NULL,
    lider TINYINT(1) NOT NULL DEFAULT FALSE,
    FOREIGN KEY voluntario_key(voluntario_id) REFERENCES voluntarios(id),
    FOREIGN KEY brigada_key2(brigada_id) REFERENCES brigadas(id)
);

CREATE TABLE types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(191),
    created DATETIME,
    modified DATETIME,
    UNIQUE KEY (title)
) CHARSET=utf8mb4;

CREATE TABLE regions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(191),
    created DATETIME,
    modified DATETIME,
    UNIQUE KEY (title)
) CHARSET=utf8mb4;

CREATE TABLE officers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(191),
    created DATETIME,
    modified DATETIME,
    UNIQUE KEY (name)
) CHARSET=utf8mb4;

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(191),
    created DATETIME,
    modified DATETIME,
    UNIQUE KEY (name)
) CHARSET=utf8mb4;

CREATE TABLE translators (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(191),
    created DATETIME,
    modified DATETIME,
    UNIQUE KEY (name)
) CHARSET=utf8mb4;

CREATE TABLE sending_programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(191),
    created DATETIME,
    modified DATETIME,
    UNIQUE KEY (title)
) CHARSET=utf8mb4;

INSERT INTO users (email, password, created, modified)
VALUES
('cakephp@example.com', 'sekret', NOW(), NOW());

```

## Migrations

http://blog.osmosys.asia/schema-migration-in-cakephp-3-x/


## Users table 

Used for baking. Source: http://www.webistrate.com/cakephp-scaffolding-a-new-database-table/


```mysql
CREATE TABLE `users` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`first_name` varchar(150) NOT NULL,
`last_name` varchar(150) NOT NULL,
`email` varchar(150) NOT NULL,
`username` varchar(20) NOT NULL,
`password` varchar(100) NOT NULL,
`created` datetime NOT NULL,
`modified` datetime NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB
```

// (maybe) https://stackoverflow.com/questions/17442465/cakephp-save-extra-attribute-in-habtm-relation



## Sites table

```mysql
CREATE TABLE sites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created DATETIME,
    modified DATETIME,
    name VARCHAR(255) NOT NULL,
    identifier VARCHAR(255),
    address VARCHAR(255) NOT NULL,
    region VARCHAR(255) NOT NULL,
    area_0 VARCHAR(255) NOT NULL DEFAULT 'El Salvador',
    area_1 VARCHAR(255),
    area_2 VARCHAR(255),
    area_3 VARCHAR(255),
    lat DECIMAL(10, 8), 
    lng DECIMAL(11, 8),
    project VARCHAR(255) NOT NULL,
    telephone VARCHAR(255) NOT NULL,
    masons VARCHAR(255) NOT NULL,
    helpers VARCHAR(255) NOT NULL,
    notes MEDIUMTEXT,
    followup TINYINT NOT NULL,
    deleted DATETIME
) CHARSET=utf8mb4;
```



# Baking

https://waltherlalk.com/blog/cakephp-3-tutorial-part-3



 # Selectize

It can probably be used with AJAX. View: https://github.com/selectize/selectize.js/issues/1329


#Pagination
## Sorting order
https://stackoverflow.com/questions/13808573/cakephp-paginate-and-order-by

## Alphabetic sorting

https://phpandframeworks.wordpress.com/2017/04/03/alphabetic-pagination-in-cakephp/
https://stackoverflow.com/questions/46424609/alphabetical-order-in-cakephp

# Installing

.htacess for subdirectory
https://stackoverflow.com/questions/20061348/cakephp-install-in-a-folder-not-root

https://www.abhinavsood.com/install-cakephp-in-subdirectory-of-wordpress/

Error 403 on production server

Funcionó: https://stackoverflow.com/questions/41260746/cakephp-3-getting-forbidden-error-when-going-to-edit-in-live-server 

https://stackoverflow.com/questions/24248108/adding-403-exception-view-to-cakephp-applicaiton

https://stackoverflow.com/questions/39666028/cakephp-3-giving-403-forbidden-error-for-put?noredirect=1&lq=1

https://stackoverflow.com/questions/1402229/why-does-my-web-server-software-disallow-put-and-delete-requests



Production server
https://stackoverflow.com/questions/38425989/how-to-move-a-cakephp-app-to-a-production-server







Full name as display fields: https://stackoverflow.com/questions/38425881/how-to-use-a-custom-format-for-multi-column-display-fields



Installing plugin https://github.com/FriendsOfCake/search

```
composer require friendsofcake/search
```

