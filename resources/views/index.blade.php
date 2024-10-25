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

    <style>
        .dropbtn {
            background-color: #04AA6D;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        #myInput:focus {
            outline: 3px solid #ddd;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f6f6f6;
            min-width: 230px;
            overflow: auto;
            border: 1px solid #ddd;
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown a:hover {
            background-color: #ddd;
        }

        .show {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container px-0 mb-5">
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm rounded-0 border">
            <div class="container-fluid">
                <a href="#" class="navbar-brand" href="#">Green Nature | Weather Foreast</a>
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
                        @csrf
                    </form>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <div class="container px-0 mb-5">
        <div class="row mb-2">
            <div class="col-md-8">
                <div class="mb-3">
                    <h6>Your location: <span class="cityName"></span>, <span class="countryCode"></span></h6>
                </div>
                <form id="weatherForm" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-sm-6 col-md-4">
                            <input type="text" class="form-control shadow mb-2" id="city" name="city"
                                placeholder="Lusaka" placeholder="Enter city" required>
                        </div>
                        <div class="col-sm-6 col-md-4 mb-2">
                            <input type="text" class="form-control shadow" id="country" name="country_code"
                                placeholder="ZM" placeholder="Enter country code" required>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-search me-2 fw-bold"></i>
                                Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="mb-3 d-flex gap-2">
            <button type="button" class="btn btn-secondary" onclick="weatherForecast()">
                <i class="bi bi-geo me-1"></i> Current location
            </button>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle shadow" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-bookmarks"></i> Saved
                </button>
                <ul class="dropdown-menu shadow" id="myDropdown">
                    <li class="px-2"><input type="text" class="form-control" placeholder="Search.." id="myInput"
                            onkeyup="filterFunction()"></li>
                    @php
                        $locations = cache()->get('locations', []); // Use [] as a default if no locations are found
                    @endphp
                    @if (!empty($locations))
                        @foreach ($locations as $location)
                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="getWeatherForecast('{!! $location['country_code'] !!}', '{!! $location['city'] !!}')">
                                    {{ $location['city'] }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li class="dropdown-item">No locations found</li> <!-- Display message if no locations exist -->
                    @endif
                </ul>
            </div>
        </div>
        <div class="row d-flex justify-content-between">
            <div class="col-md-8">
                <div class="row mb-3" id="">
                    <div class="col placeholder-glow">
                        <div class="mb-5">
                            <h1><span class="cityName"></span></h1>
                            <span class="weatherDescription">Some text here</span> •
                            <span class="weatherTime mb-5"></span>
                        </div>
                        <h1 class="weatherTemp" class="placeholder col-3"></h1>
                    </div>
                    <div class="col text-start">
                        <i class="bi bi-sun text-warning" style="font-size: 150px"></i>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card shadow mb-5 border-0">
                            <div class="card-body">
                                <div class="mb-0 mt-3 d-flex justify-content-between px-3">
                                    <h6 class="card-title text-black-50">TODAY'S FORECAST</h6>
                                </div>
                                <div class="d-flex align-items-stretch py-2 gap-2" id="currentWeatherDisplay"
                                    style="width: 100%;overflow-x:scroll">
                                    <div class="col-md-2 ">
                                        <div class="card text-center border-0 px-0 placeholder-glow">
                                            <div class="card-body px-0">
                                                <span class="placeholder col-4"></span>
                                                <br>
                                                <i class="bi bi-cloud-hail fs-2 placeholder col-6"></i>
                                                <br>
                                                <span class="placeholder col-2"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="card text-center border-0 px-0 placeholder-glow">
                                            <div class="card-body px-0">
                                                <span class="placeholder col-4"></span>
                                                <br>
                                                <i class="bi bi-cloud-hail fs-2 placeholder col-6"></i>
                                                <br>
                                                <span class="placeholder col-2"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="card text-center border-0 px-0 placeholder-glow">
                                            <div class="card-body px-0">
                                                <span class="placeholder col-4"></span>
                                                <br>
                                                <i class="bi bi-cloud-hail fs-2 placeholder col-6"></i>
                                                <br>
                                                <span class="placeholder col-2"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="card text-center border-0 px-0 placeholder-glow">
                                            <div class="card-body px-0">
                                                <span class="placeholder col-4"></span>
                                                <br>
                                                <i class="bi bi-cloud-hail fs-2 placeholder col-6"></i>
                                                <br>
                                                <span class="placeholder col-2"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="card text-center border-0 px-0 placeholder-glow">
                                            <div class="card-body px-0">
                                                <span class="placeholder col-4"></span>
                                                <br>
                                                <i class="bi bi-cloud-hail fs-2 placeholder col-6"></i>
                                                <br>
                                                <span class="placeholder col-2"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="mb-0 mt-3 d-flex justify-content-between px-3">
                                    <h6 class="card-title text-black-50">WEATHER CONDITIONS</h6>
                                </div>
                                <div id="airConditionWeatherDisplay" class="placeholder-glow">
                                    <div class="row mt-0">
                                        <!-- Weather Description Card -->
                                        <div class="col-md-6 ">
                                            <div class="card border-0">
                                                <div class="card-body ">
                                                    <i class="bi bi-cloud-sun me-2 fs-2 placeholder col-2"></i>
                                                    <strong class="placeholder col-5">Description:</strong>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Wind Speed Card -->
                                        <div class="col-md-6">
                                            <div class="card border-0">
                                                <div class="card-body ">
                                                    <i class="bi bi-cloud-sun me-2 fs-2 placeholder col-2"></i>
                                                    <strong class="placeholder col-5">Description:</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <!-- Humidity Card -->
                                        <div class="col-md-6">
                                            <div class="card border-0">
                                                <div class="card-body ">
                                                    <i class="bi bi-cloud-sun me-2 fs-2 placeholder col-2"></i>
                                                    <strong class="placeholder col-5">Description:</strong>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Air Quality Index Card -->
                                        <div class="col-md-6">
                                            <div class="card border-0">
                                                <div class="card-body ">
                                                    <i class="bi bi-cloud-sun me-2 fs-2 placeholder col-2"></i>
                                                    <strong class="placeholder col-5">Description:</strong>
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
                <div class="card shadow" style="height: 100%">
                    <div class="card-header bg-transparent border-0">
                        <div class="mb-0 mt-3 d-flex justify-content-between px-3">
                            <h6 class="card-title text-black-50">16 - DAY FORECAST</h6>
                        </div>
                    </div>
                    <div class="card-body" style="height: 73.5vh; overflow-y:scroll">
                        <div class="accordion" id="forecastAccordion"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        /* Hide the default Bootstrap accordion chevron */
        .accordion-button::after {
            display: none;
        }
    </style>
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
            event.preventDefault(); // Prevent form submission

            let cityName = document.getElementById('city').value;
            let countryCode = document.getElementById('country').value;

            // Get form data using FormData
            let formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "{{ route('weather-forecast') }}",
                data: formData,
                processData: false, // Don't process the data, let FormData handle it
                contentType: false, // Don't set contentType, let FormData handle it
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    // Call your weather functions here after a successful response
                    get16DayWeatherForecast(countryCode, cityName);
                    getTodayWeatherForecast(countryCode, cityName);
                    getTodayHourlyWeatherForecast(countryCode, cityName);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Request failed: ", textStatus, errorThrown);
                }
            });
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

                        document.querySelectorAll('.countryCode').forEach(element => {
                            element.innerText = `${weatherData.country_code}`;
                        });

                        // Update all elements with the class 'cityName'
                        document.querySelectorAll('.cityName').forEach(element => {
                            element.innerText = `${weatherData.city_name}`;
                        });

                        let airConditionWeatherData = `
                            <div class="row mt-0">
                                <!-- Weather Description Card -->
                                <div class="col-md-6">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            <i class="bi bi-cloud-sun me-2 fs-2"></i>
                                            <strong>Description:</strong> <span id="description">` + weatherData
                            .weather.description + `</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Wind Speed Card -->
                                <div class="col-md-6">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            <i class="bi bi-wind me-2 fs-2"></i>
                                            <strong>Wind Speed:</strong> <span id="windSpd">` + weatherData.wind_spd + `</span> m/s
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <!-- Humidity Card -->
                                <div class="col-md-6">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            <i class="bi bi-droplet-half me-2 fs-2"></i>
                                            <strong>Humidity:</strong> <span id="humidity">` + weatherData.rh + `</span>%
                                        </div>
                                    </div>
                                </div>

                                <!-- Air Quality Index Card -->
                                <div class="col-md-6">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            <i class="bi bi-speedometer2 me-2 fs-2"></i>
                                            <strong>Air Quality Index:</strong> <span id="aqi">` + weatherData.aqi + `</span>
                                        </div>
                                    </div>
                                </div>
                            </div>`;

                        document.getElementById('airConditionWeatherDisplay').innerHTML = airConditionWeatherData

                        document.getElementById('errorDisplay').classList.add('d-none');
                    } else {
                        document.getElementById('weatherDisplay').classList.add('d-none');
                        document.getElementById('errorDisplay').classList.remove('d-none');
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }

        function getTodayHourlyWeatherForecast(countryCode, city) {
            fetch(
                    `https://api.weatherbit.io/v2.0/forecast/hourly?city=${city}&country=${countryCode}&hours=24&key=${weatherBitApiKey}`
                )
                .then(response => response.json())
                .then(data => {

                    // Access the weather data array from the API response
                    const rawWeatherData = data.data;

                    // Filter the data to include only every 3rd hour (forecast for every 3 hours)
                    const filteredWeatherData = rawWeatherData.filter((_, index) => index % 4 === 0);

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

                    todayHourlyForecastItems.innerHTML = '';

                    forecastData.forEach(data => {
                        todayHourlyForecastItems.innerHTML += `
                        <div class="col-md-2">
                            <div class="card text-center border-0 px-0">
                                <div class="card-body px-0">
                                    <span>` + data.time + `</span>
                                    <br>
                                    <i class="bi bi-cloud-hail fs-2"></i>
                                    <br>
                                    <span >` + data.temperature + `</span>
                                </div>
                            </div>
                        </div>`;
                    });

                    get16DayWeatherForecast(countryCode, city);
                })
                .catch(error => {
                    console.error('Error fetching weather data:', error);
                });
        }
    </script>

    <script>
        let forecastData = []; // Declare globally and initialize as an empty array
        document.addEventListener('DOMContentLoaded', () => {

            weatherForecast();
        });

        async function weatherForecast(params) {
            const {
                city,
                countryCode
            } = await getLocation();

            getWeatherForecast(countryCode, city);
        }

        function getWeatherForecast(countryCode, city) {
            get16DayWeatherForecast(countryCode, city);

            getTodayWeatherForecast(countryCode, city);

            getTodayHourlyWeatherForecast(countryCode, city);
        }

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
                    // Map the forecast data for easier access
                    const forecastData = rawWeatherData.map(dayData => ({
                        day: getDayName(dayData.datetime),
                        weather: dayData.weather.description,
                        maxTemp: Math.round(dayData.max_temp),
                        minTemp: Math.round(dayData.min_temp),
                        humidity: dayData.rh, // Humidity
                        windSpeed: dayData.wind_spd.toFixed(1) // Wind speed in m/s
                    }));

                    const forecastAccordion = document.getElementById('forecastAccordion');
                    forecastAccordion.innerHTML = ''; // Clear previous data

                    forecastData.forEach((forecast, index) => {
                        const forecastItem = document.createElement('div');
                        forecastItem.classList.add('accordion-item');

                        forecastItem.innerHTML = `
                            <h2 class="accordion-header" id="heading${index}">
                                <button class="accordion-button ${index !== 0 ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="${index === 0}" aria-controls="collapse${index}">
                                    <div class="row w-100">
                                        <div class="col">${forecast.day}</div>
                                        <div class="col"><i class="bi bi-sun me-2"></i>${forecast.weather}</div>
                                        <div class="col-3 text-end">${forecast.maxTemp}°/${forecast.minTemp}°</div>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse${index}" class="accordion-collapse collapse" aria-labelledby="heading${index}" data-bs-parent="#forecastAccordion">
                                <div class="accordion-body">
                                    <p><strong>Weather:</strong> ${forecast.weather}</p>
                                    <p><strong>Temperature:</strong> ${forecast.maxTemp}° / ${forecast.minTemp}°</p>
                                    <p><strong>Humidity:</strong> ${forecast.humidity}%</p>
                                    <p><strong>Wind Speed:</strong> ${forecast.windSpeed} m/s</p>
                                </div>
                            </div>
                        `;

                        // Append the new forecast item to the accordion
                        forecastAccordion.appendChild(forecastItem);
                    });
                })
                .catch(error => {
                    console.error('Error fetching weather data:', error);
                });
        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        /* When the user clicks on the button,
                                                                                                                                                                                                                                            toggle between hiding and showing the dropdown content */
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        function filterFunction() {
            const input = document.getElementById("myInput");
            const filter = input.value.toUpperCase();
            const div = document.getElementById("myDropdown");
            const a = div.getElementsByTagName("a");
            for (let i = 0; i < a.length; i++) {
                txtValue = a[i].textContent || a[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    a[i].style.display = "";
                } else {
                    a[i].style.display = "none";
                }
            }
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
