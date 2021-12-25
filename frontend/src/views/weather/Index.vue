<template>
  <b-container v-if="loading || error" class="weather_wrapper text-center">
    <b-spinner v-if="loading" type="grow" label="Loading..."></b-spinner>
    <b-alert v-if="error" variant="danger" class="text-center">{{ message }}</b-alert>
  </b-container>
  <b-container v-else class="weather_wrapper">
    <b-row class="weather_header">
      <b-col cols="12">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="city_name">{{ weather.name }}</h4>
          <div class="temperature_units d-flex align-items-center justify-content-between">
            <b-icon
                icon="circle"
                variant="white"
                font-scale="0.3"
            >
            </b-icon>
            <div class="units">
              <div
                  :class="search.units === UNIT_CELSIUS ? 'active' :'' "
                  @click="setUnit(UNIT_CELSIUS)"
              >C</div>
              <div
                  :class="search.units === UNIT_FAHRENHEIT ? 'active' :'' "
                  @click="setUnit(UNIT_FAHRENHEIT)"
              >F</div>
            </div>
          </div>
        </div>
        <div class="d-flex align-items-center location">
          <b-form-select
              v-model="selectedCity"
              :options="cities"
              @change="changeCity"
              class="mr-2 location_select">
          </b-form-select>
          <b-icon
            class="mr-1"
            icon="cursor-fill"
            font-scale="0.9"
            variant="white"
          >
          </b-icon>
          <span @click="getCurrentLatLng()">
            Мое местоположение
          </span>
        </div>
      </b-col>
      <b-col cols="12"></b-col>
    </b-row>
    <b-row class="weather_body">
      <b-col cols="12" class="d-flex justify-content-center">
        <div class="weather_icon d-flex align-items-center">
          <img :src="icon" alt="">
        </div>
        <div class="unit_number d-flex">
          <span class="weather_number">{{ weather.main.temp }}</span>
          <b-icon
              icon="circle"
              variant="white"
              font-scale="1.5"
          >
          </b-icon>
        </div>
      </b-col>
      <b-col cols="12" class="text-center">
        <span class="weather_title">{{ description }}</span>
      </b-col>
    </b-row>
    <b-row class="weather_footer">
      <b-col cols="6" md="3" class="text-center info_footer">
        <span class="weater_wind">
          Ветер
        </span>
        <p class="weater_wind_desc">
          {{ weather.wind.speed }} м / c
        </p>
      </b-col>
      <b-col cols="6" md="3" class="text-center info_footer">
        <span class="weater_pressure">
          Давление
        </span>
        <p class="weater_pressure_desc">
          {{ weather.main.pressure }} мм рт. ст.
        </p>
      </b-col>
      <b-col cols="6" md="3" class="text-center info_footer">
        <span class="weater_pressure">
          Влажность
        </span>
        <p class="weater_pressure_desc">
          {{ weather.main.humidity }} %
        </p>
      </b-col>
      <b-col cols="6" md="3" class="text-center info_footer">
        <span class="weater_pressure">
          Вероятность дождя
        </span>
        <p class="weater_pressure_desc">
          -
        </p>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import geoLocation from "../../service/geolocation";
import { mapActions, mapState } from "vuex";
export default {
  name: "Index.vue",
  data:()=>({
    sunSVG : require('../../assets/img/sun.svg'),
    UNIT_CELSIUS: 'C',
    UNIT_FAHRENHEIT: 'F',
    selectedCity: null,
    cities: [
      { value: null, text: 'Сменить город', disabled: true},
      { value: 'Лондон', text: 'Лондон' },
      { value: 'Москва', text: 'Москва' },
      { value: 'Ереван', text: 'Ереван' },
      { value: 'Нью-Йорк', text: 'Нью-Йорк' }
    ]
  }),
  computed:{
    ...mapState({
      search: (state) => state.weather.search,
      weather: (state) => state.weather.currentWeather,
      loading: (state) => state.weather.loading,
      error: (state) => state.weather.error,
      message: (state) => state.weather.message,
    }),
    icon: function (){
      if( !this.loading ){
        return `http://openweathermap.org/img/w/${ this.weather.weather[0].icon }.png`;
      }
      return "";
    },
    description: function (){
      if( !this.loading ){
        return this.weather.weather[0].description;
      }
      return "";
    },
  },
  methods:{
    ...mapActions({
      searchWeather: 'searchWeather',
    }),
    setUnit: function (unit){
      this.$store.commit('SET_UNIT',unit);
    },
    getCurrentLatLng: function () {
      geoLocation.then((location)=>{
        this.$store.commit('SET_LAT_LON',location)
      })
    },
    changeCity: function (city) {
      this.$store.commit('SET_Q',city)
      this.selectedCity = null;
    }
  },
  mounted() {
    this.getCurrentLatLng()
  },
  watch: {
    '$store.state.weather.search': {
      deep: true,
      handler(props) {
        console.log(props)
        this.searchWeather();
      }
    }
  }
}
</script>

<style scoped>
  @media only screen and (max-width: 480px) {
    .container{
      padding-left: 20px;
      padding-right: 20px;
    }
  }
  .location_select{
    width: max-content;
    background: transparent;
    border: none;
    outline: none;
    color: white;
  }
  .location_select:focus{
    box-shadow: unset;
  }
  .weather_wrapper{
    font-family: Lato,sans-serif;
    font-style: normal;
    font-weight: normal;
    box-sizing: border-box;
    padding-top: 56px;
  }
  .city_name{
    font-size: 3rem;
    line-height: 60px;
    color: #FFFFFF;
  }
  .temperature_units{
    height: 29px;
    width: 94px;
  }
  .units{
    display: flex;
    width: 77px;
    height: 100%;
    mix-blend-mode: normal;
    border: 1px solid #FFFFFF;
    box-sizing: border-box;
    border-radius: 8px;
    opacity: 0.4;
  }
  .units > div {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50%;
    cursor: pointer;
    font-size: 1rem;
    line-height: 22px;
    color: #FFFFFF;
    opacity: 0.4;
  }
  .units .active{
    background: rgba(255, 255, 255, 0.2);
    opacity: 1;
  }
  .location{
    font-size: 1rem;
    line-height: 22px;
    color: #FFFFFF;
    mix-blend-mode: normal;
    opacity: 0.6;
  }
  .location span{
    cursor: pointer;
  }
  .weather_title{
    font-size: 25px;
    line-height: 30px;
    text-align: center;
    color: #FFFFFF;
  }
  .weather_body{
    box-sizing: border-box;
    padding-top: 120px;
    padding-bottom: 120px;
  }
  .weather_icon img{
    width: 139px;
    height: 139px;
    object-fit: fill;
  }
  .weather_number{
    font-size: 5rem;
    font-family: "Lato", sans-serif;
    color: white;
  }
  .info_footer{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    color: white;
  }
  .info_footer span{
    font-family: Lato, sans-serif;
    font-size: 0.8rem;
    font-weight: 400;
    opacity: .8;
  }
  .info_footer p{
    font-family: Lato, sans-serif;
    font-size: 1.2rem;
    font-weight: 600;
  }
</style>
