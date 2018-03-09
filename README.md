Plantilla Symfony
========================
Plantilla Symfony es una plantilla que utiliza las versiones más actualizadas de Symfony en su versión
2.6.6 y Sonata con sus respectivos bunldes, la idea de este proyecto es facilitar la
actualización de Symfony y Sonata a versiones posteriores, permitiendo con ello crear
una estructura que permita integrar o actualizar los sistemas de versiones antiguas
a una version más reciente.

Instalación del Sistema
========================

Esta documentación contiene información de como descargar, instalar la Plantilla Symfony.

1) Clonar el proyecto del repositorio
--------------------------------------

    git clone git@<servidor>:<directorio>/plantilla_symfony.git

### Uso de Composer (*recomendado*)

Plantilla Symfony utiliza Composer para manejar las dependencias (bundles) que son utilizados dentro del proyecto.

Si no se tiene composer instalado utilizar el siguiente comando dentro del directorio raíz del proyecto:

    curl -s http://getcomposer.org/installer | php

2) Configuración de la base de datos
-------------------------------------
Creación del usuario de la base de datos como usuario **postgres** ejecutar:

    createuser -DRSP usuario

Creación de la base de datos del sistema

    createdb nombre-base -O usuario

3) Configuración del Plantilla Symfony
-------------------------------
Todos los pasos que se describen a continuación deben realizarse como usuario normal.

Creación de las carpetas cache y logs:

    mkdir -p var/cache var/logs

Brindando permisos a apache de escribir en dichas carpetas

    setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx var/cache/ var/logs/
    setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx var/cache/ var/logs/


4) Instalación de las dependencias (Bundles)
--------------------------------------------

Usar el siguiente comando como usuario normal:

    php composer.phar install

Recordar cambiar los valores de **database_name, database_user, database_password** por los valores apropiados.

5) Realizando Virtual Host
--------------------------------------------
Como **usuario root**, moverse a la carpeta:

        cd /etc/apache2/sites-available/

Con un editor de texto crear el archivo **plantilla_symfony.localhost** con el siguiente contenido:

        # Inicio del archivo
        <VirtualHost *:80>
        ServerName plantilla_symfony.localhost
        DocumentRoot /var/www/plantilla_symfony/web/  ##Esta debe ser la ruta donde está el proyecto y se debe de borrar este comentario
        DirectoryIndex app.php
        <Directory /var/www/plantilla_symfony/web/ >  ##Esta debe ser la ruta donde está el proyecto y se debe de borrar este comentario
                Options FollowSymLinks MultiViews
                AllowOverride All
                Order allow,deny
                allow from all
        </Directory>
        ErrorLog ${APACHE_LOG_DIR}/plantilla_symfony.localhost-error.log
        # Possible values include: debug, info, notice, warn, error, crit,
        # alert, emerg.
        LogLevel warn
        CustomLog ${APACHE_LOG_DIR}/plantilla_symfony.localhost-access.log combined
        </VirtualHost>
        # Fin del archivo

Guardar el archivo. Luego, como **root** ejecutar:

        a2ensite plantilla_symfony.localhost

Habilitar el modo de reescritura con la siguiente sentencia:

        a2enmod rewrite

Reiniciar el servicio de Apache

        /etc/init.d/apache2 restart

Se debe agregar en el archivo **/etc/hosts** la IP junto con el ServerName
del Virtual Host. La línea debe ser similar a la siguiente:

        X.X.X.X       plantilla_symfony.localhost


6) Verificando la configuración del Sistema
--------------------------------------------

Antes de empezar hay que asegurarse que el sistema local está configurado correctamente para Symfony y sus dependencias.

Acceder al script **config.php** desde el navegador:

    http://plantilla_symfony.localhost/config.php

Si se obtienen warnings o recomendaciónes, corregirlas antes de empezar a utilizar el sistema.

7) Actualización de la base de datos
--------------------------------------------
Actualizar el esquema de la base de datos

    php bin/console doctrine:schema:update --force

8) Creación del usuario dentro del sistema
--------------------------------------------
Crear el usuario que tendrá los privilegios de SUPER ADMIN y tendrá acceso total al sistema.

    php bin/console fos:user:create --super-admin

Limpiar la cache del sistema:

    php bin/console cache:clear

Actualizar los assets

    php bin/console assets:install web --symlink

Ingresar al sistema.

    http://plantilla_symfony.localhost/app_dev.php/

9) Configuración del .gitignore
-------------------------------
Este proyecto ya incluye un archivo .gitignore

Sin embargo, es necesario agregar todos aquellos archivos y directorios generados por otros IDE,
editores de texto, etc.


10) Documentación Oficial
-------------------------------

  * **FrameworkBundle** - The core Symfony framework bundle

  * [**SensioFrameworkExtraBundle**][6] - Adds several enhancements, including
    template and routing annotation capability

  * [**DoctrineBundle**][7] - Adds support for the Doctrine ORM

  * [**TwigBundle**][8] - Adds support for the Twig templating engine

  * [**SecurityBundle**][9] - Adds security by integrating Symfony's security
    component

  * [**SwiftmailerBundle**][10] - Adds support for Swiftmailer, a library for
    sending emails

  * [**MonologBundle**][11] - Adds support for Monolog, a logging library

  * [**AsseticBundle**][12] - Adds support for Assetic, an asset processing
    library

  * [**JMSSecurityExtraBundle**][13] - Allows security to be added via
    annotations

  * [**JMSDiExtraBundle**][14] - Adds more powerful dependency injection
    features

  * **WebProfilerBundle** (in dev/test env) - Adds profiling functionality and
    the web debug toolbar

  * **SensioDistributionBundle** (in dev/test env) - Adds functionality for
    configuring and working with Symfony distributions

  * [**SensioGeneratorBundle**][15] (in dev/test env) - Adds code generation
    capabilities

  * **AcmeDemoBundle** (in dev/test env) - A demo bundle with some example
    code

  * **CiRestClientBundle** [16] (in master) - A Smart REST client with an intuitive API, providing all REST methods and returning a Symfony Response Object.

[1]:  http://symfony.com/doc/current/book/installation.html
[2]:  http://getcomposer.org/
[3]:  http://symfony.com/download
[4]:  http://symfony.com/doc/current/quick_tour/the_big_picture.html
[5]:  http://symfony.com/doc/current/index.html
[6]:  http://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html
[7]:  http://symfony.com/doc/current/book/doctrine.html
[8]:  http://symfony.com/doc/current/book/templating.html
[9]:  http://symfony.com/doc/current/book/security.html
[10]: http://symfony.com/doc/current/cookbook/email.html
[11]: http://symfony.com/doc/current/cookbook/logging/monolog.html
[12]: http://symfony.com/doc/current/cookbook/assetic/asset_management.html
[13]: http://symfony.com/doc/current/bundles/SensioGeneratorBundle/index.html
[16]: https://github.com/CircleOfNice/CiRestClientBundle
