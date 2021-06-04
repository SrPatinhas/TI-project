# TI-project

js chart -> https://www.chartjs.org/docs/latest/

PHP Framework -> http://slimframework.com/docs/v4/


## Project Config
### Requirements
- composer (v2 would be better)
- mysql and php `(used 7.2 and 8)`

### Install > `composer install` in a console/terminal

## Host config
### Windows
    C:\Windows\System32\drivers\etc
     > host
    (This file needs to have permissions to be edited)
    Add the following line to the end of the file
```
127.0.0.1       ti.test
```

### URL > ti.test
    C:\xampp\apache\conf\extra\httpd-vhosts.conf

Update the path to the right place of the files **(DocumentRoot)**

``` 
    <VirtualHost *>
        ServerName ti.test
        ServerAlias ti.test
        DocumentRoot "C:/xampp/htdocs/TI"
    </VirtualHost>

    <VirtualHost *:443>
        DocumentRoot "C:/xampp/htdocs/TI"
        ServerName ti.test
        SSLEngine on
        SSLCertificateFile "conf/ssl.crt/server.crt"
        SSLCertificateKeyFile "conf/ssl.key/server.key"
        <Directory "C:/xampp/htdocs/TI">
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>
```


# BD

Get the SQL file in `/model` folder

No need to create a database, it will be created automatically by the file.


# Config
Need to change the DB config `(user and password)` in the file `/config/settings.php`



# Structure

`/config` -> Every file with configurations for the project

`/config/routes` -> Every route/url that will be used by the project
  - - -
`/logs` -> will have any log of errors divided by day
  - - -
`/model` -> where the SQL file is to create and populate the database
  - - -
`/public` -> any JS, CSS or IMG is at. 

`/public/assets` -> any JS, CSS or IMG is at.

`/public/base_img` -> images to test with.

`/public/storage` -> images will be kept here after upload (only used for plants)
  - - -
`/src` -> All the core logic of the app

`/src/Action` -> Main controllers for the app

`/src/Domain` -> Connection between the controllers and the SQL queries, and the same queries 

`/src/Domain/{table}/Repository` -> Connection of app to the DB and the queries made for the app

`/src/Domain/{table}/Service` -> Connection between the `Repository` file and the controller in `Action`

`/src/Exception` -> Exceptions controller for the app

`/src/Middleware` -> Middleware controllers for the app

`/src/Support` -> Functions needed to be used by the app
  - - - 
`/templates` -> All the templates and html used in the app

`/templates/components` -> small components used in several pages

`/templates/layout` -> base files for almost every page `(header, menu, sidebar, footer)` 

`/templates/components` -> small components used in several pages
  - - -
`/tmp/uploads` -> folder for temporary files uploaded in the app
  - - -


# Tutorials

**Begin implementation**

https://odan.github.io/2019/11/05/slim4-tutorial.html

**Views**

https://odan.github.io/2020/12/09/slim4-php-view.html

**Logging**

https://odan.github.io/2020/05/25/slim4-logging.html

**Error Handling**

https://odan.github.io/2020/05/27/slim4-error-handling.html

**Session**

https://odan.github.io/2021/01/15/slim4-session.html

**File Upload**

https://odan.github.io/2020/10/06/slim4-filepond.html

# Users

### Admin

The admin will be able to have access to everything

    Email: admin@email.com
    Password: Qwerty

### Gardener

The gardener will only be able to see the plants, logs and devices

    Email: gardener@email.com
    Password: Qwerty

### User

The user will only have access to his plants and logs

    Email: user@email.com
    Password: Qwerty


# V2

## Changes

### BD

``ALTER TABLE `user` CHANGE `role` `role` ENUM('admin','gardener','user','device') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;``

``
INSERT INTO 'user' ('id', 'email', 'name', 'password', 'role', 'is_active', 'created_at') VALUES
(5, 'mcu_line1@email.com', 'MCU Linha 1', '$2y$10$7htXxHNDo0d0EiqpNjL3uulymx7IbQTevknl/d2XPcfzNE/VdB5q.', 'device', 1, '2021-05-29 16:37:49'),
(6, 'mcu_line2@email.com', 'MCU Linha 2', '$2y$10$1.j2EWf/kXCmyerFZmhEUu3Vpqzu1Ix49NfR3fVYjMr1LEavGh85q', 'device', 1, '2021-05-29 16:38:04'),
(7, 'mcu_line3@email.com', 'MCU Linha 3', '$2y$10$7/UI.IaBp4lNOHDSwHxoHe/St7AoYiM/SAPc4zevstjoxbePSMExu', 'device', 1, '2021-05-29 16:38:14');
COMMIT;
``