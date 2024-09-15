const express = require('express');
const axios = require('axios');
const { WeatherService } = require('./services/weather-service');

const app = express();

app.set('view engine', 'hbs');
app.use(express.static(__dirname + '/public'));

const PORT = process.env.PORT || 3000;

app.get('/', (req, res) => {
    res.render('index');
});

app.get('/weather/:city', async (req, res) => {
    try {
        const city = req.params.city;

        const service = new WeatherService();
        const coords = service.cityNameToCoords(city);

        const data = await service.getWeatherInfo(coords.lat,coords.lon);

        res.render('weather', { data, city});
        } catch (error) {
        console.error(error);
        res.status(500).send('Error retrieving weather data');
        }
});

app.get('/weather', async (req, res) => {
    try {
        const city = "At your location"

        const { latitude, longitude } = await getUserLocation(req.ip);

        const service = new WeatherService();

        const data = await service.getWeatherInfo(latitude,longitude);

        res.render('weather', { data, city});
    } catch (error) {
        console.error(error);
        res.status(500).send('Error retrieving weather data');
    }
});

function getUserLocation(ip) {
    //for demonstrative purpose of this laboratory work, I added this line for
    //it to work properly on localhost in production req would have normal ip
    const url =  process.env.NODE_ENV==="development"? `https://ipapi.co/json/`:`https://ipapi.co/json/${ip}`;
    return axios.get(url).then(response=>{
            var fetch_data = response.data

            return {latitude:fetch_data.latitude, longitude:fetch_data.longitude};
        }).catch(error=>{
            console.log("Error:", error);

            throw error;
        });
}

app.listen(PORT, () => {
    console.log(`Server is listening on port ${PORT}`);
});
