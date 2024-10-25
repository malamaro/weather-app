<h1>Weather App</h1>
<p>A weather forecasting web application built with the Laravel framework, designed to provide up-to-date weather information based on city and country inputs.</p>

<h2>Features</h2>
    <ul>
        <li>Fetches current, hourly, and 16-day weather forecasts.</li>
        <li>Caches previously searched locations for quick access.</li>
        <li>Responsive UI with Bootstrap integration.</li>
    </ul>
<div class="section">
    <h2>Prerequisites</h2>
    <p>Ensure you have the following installed:</p>
    <ul>
        <li>PHP (v8.1+ recommended)</li>
        <li>Composer</li>
        <li>MySQL or another Laravel-supported database</li>
        <li>Node.js and npm (for front-end assets)</li>
    </ul>
</div>

<h2>Getting Started</h2>
<h3>1. Clone the Repository</h3>
<div class="code-block">
    <code>git clone https://github.com/malamaro/weather-app.git</code><br>
    <code>cd weather-app</code>
</div>

<h3>2. Install Dependencies</h3>
<p>Make sure you have <a href="https://getcomposer.org/" target="_blank" class="link">Composer</a> installed, then run:</p>
<div class="code-block">
    <code>composer install</code>
</div>
<p>Install Node.js dependencies for front-end assets:</p>
<div class="code-block">
    <code>npm install</code>
</div>

<h3>3. Environment Setup</h3>
<p>Create a copy of the <code>.env</code> file from the example provided:</p>
<div class="code-block">
    <code>cp .env.example .env</code>
</div>

<h3>4. Generate Application Key</h3>
<p>Generate the Laravel application key:</p>
<div class="code-block">
    <code>php artisan key:generate</code>
</div>

<h3>5. Configure Database</h3>
<p>In the <code>.env</code> file, set up your database credentials:</p>
<div class="code-block">
    <pre>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=weather_app
DB_USERNAME=root
DB_PASSWORD=your_password
    </pre>
</div>
<p class="note important">Note: Replace <code>DB_DATABASE</code>, <code>DB_USERNAME</code>, and <code>DB_PASSWORD</code> with your actual database name and credentials.</p>

<h3>6. Migrate the Database</h3>
<p>Run the migrations to set up the database tables:</p>
<div class="code-block">
    <code>php artisan migrate:fresh --seed</code>
</div>

<h3>7. API Setup</h3>
<p>Since this app relies on weather data and location data, you will need an API key from a weather service (like OpenWeatherMap) and OpenCage. Place your API key in the <code>.env</code> file:</p>
<div class="code-block">
    <pre>
WEATHER_BIT_API_KEY=your_key
OPENCAGE_API_KEY=your_key
    </pre>
</div>
<p class="note important">Replace <code>your_api_key</code> with your actual API key.</p>

<h3>8. Build Front-End Assets</h3>
<p>Compile the front-end assets with:</p>
<div class="code-block">
    <code>npm run dev</code>
</div>
<p>To watch for changes in your front-end code, use:</p>
<div class="code-block">
    <code>npm run watch</code>
</div>

<h3>9. Serve the Application</h3>
<p>To start the application, use:</p>
<div class="code-block">
    <code>php artisan serve</code>
</div>
<p>Your application should now be running at <a href="http://localhost:8000" target="_blank" class="link">http://localhost:8000</a>.</p>

<div class="section">
    <h2>Additional Commands</h2>
    <p>To update Composer dependencies, run:</p>
    <div class="code-block">
        <code>composer update</code>
    </div>
    <p>For more Laravel commands, see the <a href="https://laravel.com/docs" target="_blank" class="link">Laravel documentation</a>.</p>
</div>

<div class="section">
    <h2>Troubleshooting</h2>
    <p>If you encounter issues with permissions, ensure that the <code>storage</code> and <code>bootstrap/cache</code> directories are writable:</p>
    <div class="code-block">
        <code>chmod -R 775 storage bootstrap/cache</code>
    </div>
</div>

<div class="section">
    <h2>Contributing</h2>
    <ol>
        <li>Fork the repository.</li>
        <li>Create a new branch (<code>git checkout -b feature/your-feature</code>).</li>
        <li>Commit your changes (<code>git commit -am 'Add a new feature'</code>).</li>
        <li>Push to the branch (<code>git push origin feature/your-feature</code>).</li>
        <li>Create a new Pull Request.</li>
    </ol>
</div>

<div class="section">
    <h2>License</h2>
    <p>This project is licensed under the MIT License. See the <code>LICENSE</code> file for more details.</p>
</div>
