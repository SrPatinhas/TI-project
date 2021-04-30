# TI-project

# Host config
###Windows
    C:\Windows\System32\drivers\etc
     > host
    (This file needs to have permissions to be edited)
    Add the following line to the end of the file
```
127.0.0.1       ti.test
```

# Config
Qualquer config a fazer e na parte de `config/settings.php`

### URL > ti.test
**C:\xampp\apache\conf\extra\httpd-vhosts.conf**

Update the path to the right place of the files (DocumentRoot)

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

**C:\Windows\System32\drivers\etc\hosts**

```127.0.0.1	ti.test```

## BD

    Create the database "greenhouse"

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

#Users

###Admin

The admin will be able to have access to everything

    Email: admin@email.com
    Password: Qwerty

###Gardener
The gardener will only be able to see the plants, logs and devices

    Email: gardener@email.com
    Password: Qwerty

###User
The user will only have access to his plants and logs

    Email: user@email.com
    Password: Qwerty