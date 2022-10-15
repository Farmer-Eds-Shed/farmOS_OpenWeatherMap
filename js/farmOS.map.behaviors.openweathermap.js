(function (drupalSettings) {
  farmOS.map.behaviors.openweathermap = {
    attach: function (instance) {
      var key = drupalSettings.farm_map.behaviors.openweathermap.api_key;
      this.addOpenweathermapLayer(instance, 'Clouds', 'clouds_new', key);
      this.addOpenweathermapLayer(instance, 'Pressure', 'pressure_new', key);
      this.addOpenweathermapLayer(instance, 'Wind', 'wind_new', key);
      this.addOpenweathermapLayer(instance, 'Temperature', 'temp_new', key);
      this.addOpenweathermapLayer(instance, 'Precipitation', 'precipitation_new', key, true);
    },
    addOpenweathermapLayer: function (instance, title, tileset, key, visible = false) {


      // Add the layer.
      var opts = {
        title: title,
        url: 'https://tile.openweathermap.org/map/' + tileset + '/{z}/{x}/{y}.png?appid=' + key,
        tileSize: 512,
        group: 'Weather layers',
        base: false,
        visible: visible,
      };
      instance.addLayer('xyz', opts);
    }
  };
}(drupalSettings));
