const axios = require('axios');
require('dotenv').config()

class WeatherService{
    cityNameToCoords(name){
        const nameDict = {
            "kyiv": {lat:50.450001, lon:30.523333},
            "ternopil": {lat:49.553516, lon:25.594767},
            "dnipro": {lat: 48.450001, lon:34.983334},
            "lviv": {lat:49.842957, lon:24.031111},
            "slavuta":{lat:49.42161, lon: 26.99653}
        }
        if(Object.keys(nameDict).includes(name.toLowerCase())){
            return nameDict[name.toLowerCase()];
        }
        else return null;
    }

    getWeatherInfo(lat, lon){
        const exclude = 'minutely,hourly,daily';
        const apiKey = process.env.WEATHER_API_KEY || "";

        const apiUrl = `https://api.openweathermap.org/data/3.0/onecall?lat=${lat}&lon=${lon}&exclude=${exclude}&appid=${apiKey}&units=metric`;

        return axios.get(apiUrl)
            .then(response => {
                return response.data;
            })
            .catch(error => {
                console.error('Error fetching data:', error);

                throw error;
            });
    }
}
module.exports ={WeatherService}