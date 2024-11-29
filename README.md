# Laravel Project Name: School Managment System





# Requirements:
- PHP 8+
- Composer
- SGBDR (phpMyAdmin)

# About SMS:
This SMS is a school management system developed with version 10 of the Laravel framework. Its purpose is to computerize the management that is done manually in some schools, and to facilitate access to various resources that will be made available such as:
- Login system
- Managment Student: add,edit,delete student,...
-
-



# How To Install STK SMS:

To be able to access the application it is necessary to follow the following steps:

1. Clone the repository with the following command:
```bash
https://github.com/baonq080921/school.com.git
```
2. Make a copy of the .env.example file and rename it to .env
    - On Mac and linux:    
   ```bash
   cp .env.example .env
   ```
   - On Windows:
   ```bash
   copy .env.example .env
   ```
3.Create a database and fill in the following information in the environment file
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school.com
DB_USERNAME=root
DB_PASSWORD=
```
4.Create a mailtrap account:
```bash
https://mailtrap.io/?gad_source=1&gclid=Cj0KCQiArby5BhCDARIsAIJvjIQyU3uY3LEe4c_kAQM19NL7GlGSMYy4Z6RtQFJ1gOMTv0g7EP-p-AwaAr6WEALw_wcB
```
![Screenshot](public/images/Screenshot%202024-11-10%20at%2000.33.42.png)


5.Install the various application dependencies
```bash
composer install
```
6.Run migrations to prepare database tables:
```bash
php artisan migrate
```


   



