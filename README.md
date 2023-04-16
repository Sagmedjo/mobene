<p align="center"><a href="https://mobeneconnect.de" target="_blank"><img src="https://mobeneconnect.de/wp-content/uploads/2023/04/mobeneConnect-Logo-Slogan.png" width="400" alt="mobeneConnect Logo"></a></p>

<p>You can check out a fully functional version of this project on <a href="https://app.mobeneconnect.de" target="_blank">mobeneConnect App</a></p>
<p>The local version will not show a text in the KI Bullet List Modal when entering <a href="https://app.mobeneconnect.de/admin" target="_blank">Admin Site</a> because of missing SSL cert</p>

## Installation

<ul>
    <li>Clone project</li>
    <li>Switch in directory containing artisan file</li>
    <li>PHP 8.2 is installed</li>
    <li>take .env and needed php.ini from Google Drive (please don't use my openAI api key too much ;)</li>
    <li>change database connection to used one</li>
    <li><ul><li>DB_CONNECTION=sqlite</li><li>DB_DATABASE=fullPathToDatabase</li></ul></li>
    <li>run composer install --no-dev</li>
    <li>run php artisan key:generate</li>
    <li>run php artisan storage:link</li>
    <li>run php artisan migrate</li>
    <li>run npm install && npm run build</li>
</ul>
