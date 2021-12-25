import axiso from "../../service/axiso";

const state = {
    loading: true,
    currentWeather: {},
    error: false,
    message: '',
    search:{
        units: 'C',
        q: '',
        lat: '',
        lon: '',
        lang: 'ru'
    }
}

const actions = {
    /**
     * Get user geolocation weather
     *
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    async searchWeather({commit, state}){
        return new Promise((resolve, reject) => {
            commit('SET_LOADING',true)
            axiso.post('/weather/search',state.search)
                .then((response) => {
                    if( response.data.success ){
                        commit('SET_WEATHER',response.data.data)
                        commit('SET_ERROR',false)
                        commit('SET_MESSAGE','')
                    }else{
                        commit('SET_WEATHER',{})
                        commit('SET_ERROR',true)
                        commit('SET_MESSAGE',response.data.data.message)
                    }
                    commit('SET_LOADING',false)
                    resolve(response)
                })
                .catch((error)=>{
                    commit('SET_LOADING',false)
                    reject(error)
                })
        });
    }
}

const mutations = {
    SET_LOADING: function (state, loading) {
        state.loading = loading;
    },
    SET_LAT_LON: function (state, location) {
        state.search.lat = location.lat;
        state.search.lon = location.lon;
        state.search.q = '';
    },
    SET_UNIT: function (state, unit) {
        state.search.units = unit;
    },
    SET_Q: function (state, q){
        state.search.lat = '';
        state.search.lon = '';
        state.search.q = q;
    },
    SET_WEATHER: function (state, data){
        state.currentWeather = data;
    },
    SET_ERROR: function (state, error){
        state.error = error;
    },
    SET_MESSAGE: function (state, message){
        state.message = message;
    }
}

const getters = {
    search:(state) => state.search,
}

export default { state, actions, mutations, getters }
