# [MARINE FUEL EXAM]

[MARINE FUEL EXAM] is a tech exam job application.

### Installation / Running the Program
Download/Clone the Application from the git repository [https://github.com/storemalt/marine-fuel.git]
```sh
git clone https://github.com/storemalt/marine-fuel.git [folder_name]
```

Navigate to your application root
```sh
cd [directory][app_folder]
```

Setup environment configuration file
```sh
cp .env.example .env
```

Add google maps api key in environment configuration file 
>*Note: https encrypted connection is required to connect to google maps api*
```sh
GOOGLE_MAPS_API_KEY:"whatever your api key is eg:foo"
```

Update/install the PHP vendor dependencies via composer.
make sure you have [composer] installed
Open your terminal/command line and execute the following command

```sh
composer update
```

Update/install the node vendor dependencies via npm.
make sure you have the LTS [node.js] installed
Open your terminal/command line and execute the following command

```sh
npm install
```

Set an application key value

```sh
php artisan key:generate
```
### [Unit Testing]
You can run the test by running the command (in linux distros)
```sh
phpunit
```
> in windows you might need to specify the php path
### Required Technologies

APP NAME is currently running on the following technologies on a windows server. Instructions on how to use them in your own application are linked below.

| Technology (Core) | Source |
| ------ | ------ |
| Laravelv5.8^ | [Laravel Framework v5.8^][laravel] |
| PHPv7^ | [PHP v7+ Thread Safe][php] |
| PseudoNoSQL | [Serialized Store Files][caching] |

| Technology - Nginx (linux, debian based) | Source |
| ------ | ------ |
| Nginx | [Nginx unit 1.8.0][nginx] |
| PHP-FPM | [Apache 2.4.38 Win64 on 64 bit][phpfpm] |

| Technology - Apache (windows based) | Source |
| ------ | ------ |
| C++ Redistributable | [C++ Redistributable Visual Studio 2017][c++] |
| Apache | [Apache 2.4.38 Win64 on 64 bit][apache] |
| .Net Framework | [.NET Framework 4.7.2+][.net] |

Instructional Video:
[How to install Apache, PHP & Mysql on windows](install)
[How to install Linux Nginx Mysql PHP](install-nginx)

MYSQL Configuration (windows)
> use Legacy authentication method option, NOT use Strong Password Encryption

> PHP Extensions required: (edit php.ini file in this case c:/php.ini)
extension=mbstring
extension=openssl
extension=xls
extension=pdo_mysql

> MYSQL Path:
Add mysql "bin" directory to windows environment variables in this case
```sh
C:\Program Files\MySQL\MySQL Server 8.0\bin;
```

### Required Dependencies

| Technology | Source |
| ------ | ------ |
| Git | [Git bash for windows][git] |
| Composer | [Composer setup exec for Windows][composer] |
| Make | [make-4.1-2-without-guile-w32-bin.zip][make] |
| Node.js | [LTS: 10.15.1/npm package manager included][nodejs]|
| Yarn | [Stable: v1.13.0 (Optional)][yarn] |
| Cypress | [Cypress.io Browser Testing Tool][cypress] |

>  Make on windows - Extract the files and copy the contents to your Git folder [Git\mingw64\] merging the folders, but do NOT overwrite/replace any existing files. Then open a new git terminal (run as administrator), and type [make] should say "no targets specified and no make file found", this tells us that we have successfully integrated make to the windows system.

> nodeJS - open git bash or terminal and type "npm --version" to check node js current version, this will tell us that the installation was successful.

> Yarn - type "yarn --version" on git bash to check if yarn is also installed properly, this should show the current version.

### Cloning the repository

[APP NAME] repository is located in github under storemalt access (changed in future)
[Bitbucket Repo](repo)

Install the directory under the directory folder that you want in this case
it's c:/www/
```sh
cd c:
mkdir www
cd www
git clone https://storemaltinside@bitbucket.org/storemaltinside/laravel-base-template-with-auth-v1.git app-name
cd app-name
```

### Project Initialization
create and copy a new environment file
```sh
cp .env.example .env
```

add the following values
```sh
APP_NAME="App Name"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL="WHAT EVER IS THE DOMAIN NAME"
ALLOWED_DOMAIN="DOMAIN NAME"

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE="DATABASE NAME"
DB_USERNAME="DATABASE USER"
DB_PASSWORD="DATABASE PASSWORD"

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST="EMAIL HOST"
MAIL_PORT=2525
MAIL_USERNAME="MAIL USERNAME"
MAIL_PASSWORD="MAIL PASSWORD"
MAIL_ENCRYPTION="MAIL ENCRYPTION"

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

GOOGLE_APPLICATION_CREDENTIALS="SET CREDENTIAL"
GOOGLE_CAPTCHA_SITE_KEY="SET KEY"
GOOGLE_CAPTCHA_SECRET_KEY="SET SECRET KEY"
```

Set Configuration Values in the environment file:
> database configuration (dbname, dbusername, dbpassword) etc..
> application configuration (APP_LOCAL, DEBUG) etc..

Create a database in MySQL:
```sh
winpty mysql -u [username] -p
enter your password: [password]
create database db_name;
exit
```
*Note: winpty is for using windows based terminal

Create a cypress configuration file
```sh
vim cypress.json
```

Then add the script
```sh
{
    "baseUrl": "http://YOURDOMAIN"
}
```

##### Setup Nginx VirtualHost
* will update this section

##### Setup Apache VirtualHost
* using the git bash terminal (run as administrator)
```sh
cd c:/Apache24/conf
vim httpd.conf
```
* search for Define SRVROOT and make sure the root value is (where apache directory is installed in this case Apache24)
```sh
Apache24
```

 * search for DocumentRoot make sure value is
```sh
"${SRVROOT}/htdocs"
```

* Change also <Directory "c:/Apache24/htdocs"> to
```sh
<Directory "${SRVROOT}/htdocs"
```

* Within the <Directory> block just a few lines below there is a tag 
* "AllowOverride None", change this to
```sh
AllowOverride All
```

* search for ScriptAlias /cig-bin/ make sure value is
```sh
"${SRVROOT}/cgi-bin"
```

* search for "# Virtual hosts", allow to include the vhosts config,
* just REMOVE the comment tag "#"
```sh
Include conf/extra/httpd-vhosts.conf
```

* Exit and save the new changes
```sh
:wq!
```

* open the vhosts config file under the /extra folder
* and add this virtualhost configuration
```sh
cd /extra
vim httpd-vhosts.conf
```
* Configuration
```sh
<VirtualHost *:80>
    ServerAdmin storemalt@gmail.com
    DocumentRoot "${SRVROOT}/htdocs/www/crm-jtb/public"
    ServerName crm.jtb.com.sg
    ErrorLog "logs/crm.jtb.com.sg-error.log"
    CustomLog "logs/crm.jtb.com.sg-access.log" common
</VirtualHost>
```

* save the file and exit, restart(stop then start) Apache on terminal
```sh
net stop Apache2.4
net start Apache2.4
```

* add the virtual host servername to windows hosts file and save
```sh
vim c:/WINDOWS/system32/drivers/etc/hosts
127.0.0.1   crm.jtb.com.sg
```

Instructional Video:
[How to create an Apache virtual host on windows](virtualhost)

Then run the command:
```sh
make init
```

### Updating the App codebase
run command on your terminal:
```sh
make update
```

### Changelogs:
> [2019/02/14] - Added a package fix for a inspect.js Gulp internal binding error, added this in the make init command
```sh
npm install natives@1.1.6
```

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)

   [laravel]: <https://laravel.com/>
   [php]: <https://windows.php.net/download>
   [caching]: <https://laravel.com/docs/5.8/cache#configuration>
   [nginx]: <https://unit.nginx.org/installation/>
   [phpfpm]: <https://php-fpm.org/>
   [apache]: <https://www.apachelounge.com/download/>
   [c++]: <https://aka.ms/vs/15/release/VC_redist.x64.exe>
   [.net]: <https://dotnet.microsoft.com/download/dotnet-framework-runtime/net472>
   [mysql]: <https://dev.mysql.com/downloads/windows/installer/8.0.html>
   [install]: <https://www.youtube.com/watch?v=D5NjQlS-j80>
   [install-nginx]: <https://www.youtube.com/watch?v=pGc8DbJVupE>
   [git]: <https://git-scm.com/>
   [composer]: <https://getcomposer.org/download/>
   [node.js]: <https://nodejs.org/en/>
   [make]: <https://sourceforge.net/projects/ezwinports/files/>
   [nodejs]: <https://nodejs.org/en/>
   [yarn]: <https://yarnpkg.com/lang/en/docs/install/#windows-stable>
   [cypress]: <https://www.cypress.io/>
   [repo]: <https://bitbucket.org/storemalt/crmjtb-v2/src/master/>
   [virtualhost]: <https://www.youtube.com/watch?v=3dUTbeUrlqE>