<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Weather App</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container mb-5">
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm rounded-0 border">
            <div class="container-fluid">
                <a href="#" class="navbar-brand" href="#">Green Nature Foreast</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-danger" type="submit">Login</button>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <div class="container mb-5">
        <div class="row mb-3">
            <div class="col-md-8">
                <div class="mb-3">
                    <h6>Your location: <span class="cityName"></span>, <span class="countryCode"></span></h6>
                </div>
                <form id="weatherForm">
                    <div class="row mb-3">
                        <div class="col-4">
                            <input type="text" class="form-control shadow" id="city" name="city"
                                placeholder="Enter city" required>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control col shadow" id="country" name="country"
                                placeholder="Enter country code" required>
                        </div>
                        <button type="submit" class="btn btn-primary col-1">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row d-flex justify-content-between">
            <div class="col-md-8">
                <div class="container px-0 mb-0" style="height: 300px">
                    <div class="mb-3">
                        <h1><span class="cityName"></span></h1>
                        <span class="weatherDescription">Some text here</span> ●
                        <span class="weatherTime"></span>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h1 class="weatherTemp"></h1>
                        </div>
                        <div class="col">
                            Sun picture
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-5">
                            <div class="card-body">
                                <div class="mb-3 d-flex justify-content-between">
                                    <h6 class="card-title">TODAY'S FORECAST</h6>
                                </div>
                                <div class="d-flex align-items-stretch d-none py-2 gap-2" id="currentWeatherDisplay" style="width: 100%;overflow-x:scroll">

                                </div>
                            </div>
                        </div>

                        <div class="card shadow">
                            <div class="card-body">
                                <div class="mb-3 d-flex justify-content-between">
                                    <h6 class="card-title">AIR CONDITIONS</h6>
                                </div>
                                <div id="airConditionWeatherDisplay" class="d-none">

                                    <div class="row mt-3">
                                        <!-- Weather Description Card -->
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <i class="bi bi-cloud-sun me-2"></i>
                                                    <strong>Description:</strong> <span id="description">Clear
                                                        sky</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Wind Speed Card -->
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <i class="bi bi-wind me-2"></i>
                                                    <strong>Wind Speed:</strong> <span id="windSpd">3.2</span> m/s
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <!-- Humidity Card -->
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <i class="bi bi-droplet-half me-2"></i>
                                                    <strong>Humidity:</strong> <span id="humidity">60</span>%
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Air Quality Index Card -->
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <i class="bi bi-speedometer2 me-2"></i>
                                                    <strong>Air Quality Index:</strong> <span id="aqi">42</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <!-- Error Display -->
                                <div id="errorDisplay" class="d-none">
                                    <p class="text-danger">Error fetching weather data. Please try again.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header pt-4 pb-2 bg-transparent border-0">
                        <h6 class="card-title mb-0">16 - DAY FORECAST</h6>
                    </div>
                    <div class="card-body" style="height: 73.5vh; overflow-y:scroll">
                        <div class="list-group list-group-flush" id="forecastList">
                            <!-- The forecast items will be appended here -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        const weatherBitApiKey = 'c44417e75183453790f40d6ef4f8e7b6'; // Replace with your Weatherbit API key
        const openCageApiKey = 'c38fff3aae954903884d7f1f6738ca49'; // Replace with your OpenCage API key
    </script>
    <script>
        function getLocation() {
            return new Promise((resolve, reject) => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const latitude = position.coords.latitude;
                            const longitude = position.coords.longitude;

                            fetch(
                                    `https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=${openCageApiKey}`
                                )
                                .then(response => response.json())
                                .then(data => {
                                    if (data.results.length > 0) {
                                        const city = data.results[0].components.city || data.results[0]
                                            .components.town || data.results[0].components.village ||
                                            'Unknown City';
                                        const countryCode = data.results[0].components.country_code
                                            .toUpperCase();

                                        // Resolve the promise with the city and country code
                                        resolve({
                                            city,
                                            countryCode
                                        });

                                        document.querySelectorAll('.countryCode').forEach(element => {
                                            element.innerText = `${countryCode}`;
                                        });

                                        // Update all elements with the class 'cityName'
                                        document.querySelectorAll('.cityName').forEach(element => {
                                            element.innerText = `${city}`;
                                        });

                                    } else {
                                        reject('Location not found');
                                        document.getElementById('locationDisplay').innerText =
                                            `Location not found`;
                                    }
                                })
                                .catch(error => {
                                    console.error('Error fetching geocoding data:', error);
                                    reject('Error fetching location details');
                                    document.getElementById('locationDisplay').innerText =
                                        `Error fetching location details`;
                                });
                        },
                        (error) => {
                            let errorMessage = '';
                            switch (error.code) {
                                case error.PERMISSION_DENIED:
                                    errorMessage = "User denied the request for Geolocation.";
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    errorMessage = "Location information is unavailable.";
                                    break;
                                case error.TIMEOUT:
                                    errorMessage = "The request to get user location timed out.";
                                    break;
                                case error.UNKNOWN_ERROR:
                                    errorMessage = "An unknown error occurred.";
                                    break;
                            }
                            alert(errorMessage);
                            reject(errorMessage);
                        }
                    );
                } else {
                    const errorMessage = "Geolocation is not supported by this browser.";
                    alert(errorMessage);
                    reject(errorMessage);
                }
            });
        }

        function getWeather(params) {

        }
    </script>


    <script>
        document.getElementById('weatherForm').addEventListener('submit', function(event) {
            event.preventDefault();
            let cityName = document.getElementById('city').value;
            let countryCode = document.getElementById('country').value;

            getTodayWeatherForecast(countryCode, cityName);
        });

        function getTodayWeatherForecast(countryCode, cityName) {
            fetch(
                    `https://api.weatherbit.io/v2.0/current?city=${cityName}&country=${countryCode}&key=${weatherBitApiKey}`
                )
                .then(response => response.json())
                .then(data => {
                    if (data.data && data.data.length > 0) {
                        const weatherData = data.data[0];
                        document.getElementsByClassName('cityName').textContent = weatherData.city_name;
                        // document.getElementById('countryCode').textContent = weatherData.country_code;
                        document.querySelectorAll('.weatherTemp').forEach(element => {
                            element.innerText = `${weatherData.temp}°C`;
                        });
                        // document.getElementById('temp').textContent = weatherData.temp;
                        // document.getElementById('appTemp').textContent = weatherData.app_temp;
                        document.getElementById('description').textContent = weatherData.weather.description;
                        document.getElementById('windSpd').textContent = weatherData.wind_spd;
                        document.getElementById('humidity').textContent = weatherData.rh;
                        document.getElementById('aqi').textContent = weatherData.aqi;
                        // document.getElementById('obTime').textContent = weatherData.ob_time;
                        document.getElementById('currentWeatherDisplay').classList.remove('d-none');
                        document.getElementById('airConditionWeatherDisplay').classList.remove('d-none');
                        document.getElementById('errorDisplay').classList.add('d-none');
                    } else {
                        document.getElementById('weatherDisplay').classList.add('d-none');
                        document.getElementById('errorDisplay').classList.remove('d-none');
                    }
                })
                .catch(error => {
                    console.log(error);

                    document.getElementById('weatherDisplay').classList.add('d-none');
                    document.getElementById('errorDisplay').classList.remove('d-none');
                });
        }

        function getTodayHourlyWeatherForecast() {
            const city = 'Lusaka'; // Replace with your desired city
            const countryCode = 'ZM'; // Replace with your desired country code

            fetch(
                    `https://api.weatherbit.io/v2.0/forecast/hourly?city=${city}&country=${countryCode}&hours=24&key=${weatherBitApiKey}`
                )
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Process the fetched data

                    // Access the weather data array from the API response
                    const rawWeatherData = data.data;

                    // Filter the data to include only every 3rd hour (forecast for every 3 hours)
                    const filteredWeatherData = rawWeatherData.filter((_, index) => index % 3 === 0);

                    // Transform the API data into the desired format
                    const forecastData = filteredWeatherData.map(hourData => ({
                        time: new Date(hourData.timestamp_local).toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        }), // Format time
                        weather: hourData.weather.description, // Extract weather description
                        temperature: `${Math.round(hourData.temp)}°C` // Format temperature
                    }));

                    let todayHourlyForecastItems = document.getElementById('currentWeatherDisplay');

                    forecastData.forEach(data => {
                        todayHourlyForecastItems.innerHTML += `
                        <!-- Temperature Card -->
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <i class="bi bi-thermometer-half me-2"></i>
                                    <strong>Temperature:</strong> <span>${data.temperature}</span>°C
                                    <br>
                                    <i class="bi bi-thermometer-sun me-2"></i>
                                    <strong>Feels like:</strong> <span>${data.feels_like}</span>°C
                                </div>
                            </div>
                        </div>
                    `;
                    });



                    // Output the formatted data
                    console.log(forecastData);

                    // Call the function to display the forecast (you can implement this in the next step)
                    displayForecast(forecastData);
                })
                .catch(error => {
                    console.error('Error fetching weather data:', error);
                });
        }

        getTodayHourlyWeatherForecast();
    </script>

    <script>
        let forecastData = []; // Declare globally and initialize as an empty array

        document.addEventListener('DOMContentLoaded', () => {

            async function weatherForecast(params) {
                const {
                    city,
                    countryCode
                } = await getLocation();

                get16DayWeatherForecast(countryCode, city);

                getTodayWeatherForecast(countryCode, city);
            }

            weatherForecast();
        });

        async function get16DayWeatherForecast(countryCode, city) {


            const getDayName = (dateString) => {
                const date = new Date(dateString);
                const options = {
                    weekday: 'long'
                };
                return date.toLocaleDateString('en-US', options);
            };

            fetch(
                    `https://api.weatherbit.io/v2.0/forecast/daily?city=${city}&country=${countryCode}&days=16&key=${weatherBitApiKey}`
                )
                .then(response => response.json())
                .then(data => {
                    // Access the weather data array from the API response
                    const rawWeatherData = data.data;

                    // Transform the API data into the desired format and assign it to the global forecastData
                    forecastData = rawWeatherData.map(dayData => ({
                        day: getDayName(dayData.datetime), // Get the day of the week
                        weather: dayData.weather.description, // Extract weather description
                        temperature: `${Math.round(dayData.max_temp)}/${Math.round(dayData.min_temp)}` // Format temperature
                    }));

                    // Now that forecastData is ready, call the display function
                    displayForecast();
                })
                .catch(error => {
                    console.error('Error fetching weather data:', error);
                });
        }

        // Function to dynamically generate the forecast list
        function displayForecast() {
            const forecastList = document.getElementById('forecastList');

            // Clear any existing forecast items
            forecastList.innerHTML = '';

            // Loop through the forecast data and create list items
            forecastData.forEach(forecast => {
                const forecastItem = document.createElement('a');
                forecastItem.classList.add('list-group-item', 'list-group-item-action', 'py-4');

                // Add the forecast details in a row
                forecastItem.innerHTML = `
                <div class="row">
                    <div class="col">${forecast.day}</div>
                    <div class="col">${forecast.weather}</div>
                    <div class="col text-end">${forecast.temperature}</div>
                </div>
            `;

                // Append the new forecast item to the list
                forecastList.appendChild(forecastItem);
            });
        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
