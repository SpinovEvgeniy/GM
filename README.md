Yii 2 Music CMS
================================

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages)
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this application template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

Checkout repository 

~~~
git clone https://github.com/SpinovEvgeniy/GM.git
~~~

Copy content to your web directory.

Now update your Apache configuration so it's DirectoryRoot will point to (your_web_directory)/web/

Now you should be able to access system by URL:

~~~
http://localhost/
~~~



CONFIGURATION
-------------

### Database



Edit the file `config/db.php` with real data. Default DB name is `gm`:
