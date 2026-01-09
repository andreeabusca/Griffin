# Griffin
A Banking Web Application 
---
**Technologies**: PHP, Simfony Framework, Composer, Twig, PostgreSQL, HTML, CSS
---
##User Features
---
###Registration & Login:
Users can register new accounts and log in securely. 

###Profile and Account Management:
Users can view and edit their personal information, see account balances, and update credentials.

###Virtual Transactions:
Users can transfer virtual funds between accounts. Each transaction updates sender and receiver account balances.

###Transaction History:
Each user can view a list of their past transactions with details such as date, counterpart, and amount.

---
##Administrative Features 
---
###Admin Dashboard:
Admins can view all registered users, monitor balances, review system-wide transactions, and manage user accounts (activation, suspension).

---
##Usage instructions:

##Client:

-user tries to log in;

-if user is already in the database, the user login is successful;

-if user does not exit in the database, the user must register;

-user can view profile, create or delete accounts, and make transactions;

-user logs out.

##Admin:

-user logs in;

-user can view all clients, accounts, and transactions;

-user can change the status of an account;

-user logs out.

---
##Before installation of the project, you must already have installed:
-an IDE: PHPStorm (one month free trial), Visual Studio Code (free) to work on the code;

-PHP: https://www.php.net/manual/en/install.php; 

-Composer: https://getcomposer.org/doc/00-intro.md#using-the-installer;

-Symfony CLI: https://symfony.com/doc/current/setup.html;

-PostgreSQL servers: https://www.postgresql.org/download/ (you also need to create a database with tables that mirror the entities in the project);

---
##!If you decide to use Visual Studio Code, you should also install the following extensions to make working on the project easier:
-PHP Debug

-PHP Intelephense

-PHP Namespace Resolver

-Twig Language 2

-Symfony for VSCode 

---
##Installation of the project:
-clone git repo: git clone <repo_url>

-enter project folder: cd <project_folder>

-configure .env files 

-run app: symfony server:start

