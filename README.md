
**Prerequisite:**
1. WAMP installed
2. php path added to Environment Variables under 'Advanced system settings'

**Steps to run.**

1. Clone the repo
2. Start the WAMP server, Open phpmyadmin on browser (https://localhost/phpmyadmin) and login.
3. Now Import script file (location: script/jrd_test.sql) and verify a db named "jrd_test" is created and two tables are also created along with some data.
5. Open config/Config.php and change the username/password for the Database accordingly (line no 7 & 8).
6. Open cmd and go inside the project folder.(jrd_test) (It will loke something like "C:\Users\johna12\Desktop\mywork\JRD_Code_test\jrd_test"). And execute command:  php -S localhost:8880
7. Open the browser and go to http://localhost:8880




Reach me out @ ajujohn2009@gmail.com if you have any issue in setup.

