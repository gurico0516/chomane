# chomane

This is a web application for managing your allowance on a weekly basis.

This web application is featuring basic like below:

* login authentication function
* user registration function
* allowance list display function
* allowance create function
* allowance editing function
* allowance deletion function
* allowance calendar display function
* allowance graph display function
* expense create function
* expense editing function
* expense deletion function
* application setting function
* pagenation

## Prefece

This application is intended to be used on Mac OS  or Linux (probably available on Windows, unconfirmed).

And following instructions are only for Mac OS , sorry.

## Usage
First of all, you need to clone this repository.  
Move to your directory that you want to set this repository.
```
git clone git@github.com:gurico0516/chomane.git
```

This application is used `Sail`, so you must need to install `Docker`.  
Install `composer package` if you already installed Docker, create minimum container including php and composer.
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

After that, create `.env`, change `DB_HOST` to connect mysql container.
```
DB_HOST=mysql
```

Set up sail when you finished above procedure.
```
# Start in the background
./vendor/bin/sail up -d

# Update APP_KEY
sail artisan key:generate

# Create and migrate your database
sail artisan migrate

# Insert initial data
sail artisan db:seed
```

Lastly, build `Laravel-Mix`.
```
# Install Node.js
sail npm install

# Build
sail npm run dev
```

Now you can visit `http://localhost/` from your browser.  

ANd you can login `admin page` by user admin01@example.com password `Admin!01`.

## Walkthrough
1. Log in and register your weekly allowance now.
2. Enter money spent daily from expenses to keep track of your spending.
3. Your registered allowance can also be viewed in the calendar and graph.
4. Use the app's settings feature to configure the app to your liking and make it easy to use!

## Built Using
* PHP 8.2.5
* Laravel 10.7.1
* TypeScript 5.0.4
* React 18.2.0
* Tailwind 3.3.1
* Vite 4.2.1
* MySQL 8.0.32
* Docker 20.10.17
* Figma 112.2
* Devise
* VSCode
