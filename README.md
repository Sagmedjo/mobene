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
    <li>Finally php artisan serve to start a local server</li>
</ul>

## Important files are:

<ul>
    <li>FILE: app/Http/Controllers/EnergyConsultationInquiryController.php</li>
    <li>FILE: app/Http/Requests/EnergyConsultationInquiryRequest.php</li>
    <li>FILE: app/Jobs/AskChatGPT.php</li>
    <li>FILE: app/Models/EnergyConsultationInquiry.php</li>
    <li>FILE: app/Services/EnergyConsultationInquiryService.php</li>
    <li>FILE: config/services.php</li>
    <li>FILE: database/migrations/2023_04_15_170841_create_energy_consultation_inquiries_table.php</li>
    <li>FOLDER: resources/js/Pages/</li>
    <li>FOLDER: resources/js/Shared/</li>
    <li>FILE: resources/js/app.js/</li>
    <li>FILE: resources/views/app.blade.php/</li>
    <li>FILE: routes/web.php/</li>
    <li>FILE: tests/Feature/EnergyConsultationInquiryTest.php/</li>
</ul>
