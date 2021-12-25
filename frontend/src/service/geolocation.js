const geoLocation = new Promise((resolve) =>{
    navigator.geolocation.getCurrentPosition(function (position){
        let geoLocation = {};
        geoLocation.lat = position.coords.latitude;
        geoLocation.lon = position.coords.longitude;
        resolve(geoLocation);
    });
})

export default geoLocation;
