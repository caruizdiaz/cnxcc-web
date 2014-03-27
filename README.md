cnxcc-web
=========

Web management interface for cnxcc module.

Updates
=========
- Still under development.

Requirements
==========
- Latest release of Zend Framwork 2.
- MySQL

Installation
=========

0. Create a new user, "cnxcc" for example (this is not mandatory, but it is recommended).
<pre>
    # useradd cnxcc -m
    # su - cnxcc
</pre>

1. Go to your installation directory and clone the repository
<pre>
    $ git clone git://github.com/caruizdiaz/cnxcc-web.git
</pre>

2. Grant read/execute permissions over your directory
<pre>
    # chmod 755 /home/cnxcc/
</pre>

3. Create a virtual host configuration file for apache, pointing the document root to the public directory of your
recently cloned repository
<pre>
    # vim /etc/httpd/conf.d/cnxcc.conf
</pre>
<pre>
    &#60;VirtualHost 1.2.3.4:80&#62;
        DocumentRoot /home/cnxcc/cnxcc-web/public
        ErrorLog /var/log/httpd/cnxcc-error_log
        &#60;Directory /home/cnxcc/cnxcc-web/public/&#62;
            Options Indexes FollowSymLinks MultiViews
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        &#60;/Directory&#62;
    &#60;/VirtualHost&#62;
</pre>

    <pre>
    # /etc/init.d/httpd restart
    </pre>

4. Create the database
<pre>
    # mysql &#60; /home/cnxcc/cnxcc-web/sql/cnxcc.sql
</pre>

5. Install ZendFramework and its dependencies
<pre>   
    cd /home/cnxcc/cnxcc-web
    php -r "readfile('https://getcomposer.org/installer');" | php
    php composer.phar install
</pre>
You may also need to install some other php dependencies, php-dom for example. Check "/var/log/httpd/cnxcc-error_log" error log.

6. Now the page should be accessible. Go to http://1.2.3.4 and try it
<pre>   
    User: admin
    Password: 123456
</pre>

7. Configure the database synchronization following these instructions
<pre>
    https://github.com/caruizdiaz/cnxcc-db-sync/blob/master/README.md
</pre>

8. You can configure the database connection credentials in:
<pre>
    'db' => array(
                'driver'        => 'Pdo',
                'dsn'           => 'mysql:dbname=cnxcc;host=127.0.0.1',
                'username' => 'root',
                'password' => '',
                'driver_options' => array(
                                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                ),
    ),
</pre>

On the file located at:
<pre>
./module/Application/config/module.config.php
</pre>

Screenshots
=========
![ScreenShot](http://caruizdiaz.com/wp-content/uploads/2013/01/cnxcc21-1024x495.png)
