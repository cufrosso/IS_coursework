function init(){
  map = new ymaps.Map('map_t', {
    center:[59.85222752836774,30.322910164009883],
    controls: ['fullscreenControl'],
    zoom:13
  });
//скрываем элементы карты
map.controls.remove('geolocationControl'); // удаляем геолокацию
map.controls.remove('searchControl'); // удаляем поиск
map.controls.remove('trafficControl'); // удаляем контроль трафика
//map.controls.remove('typeSelector'); // удаляем тип
//map.controls.remove('fullscreenControl'); // удаляем кнопку перехода в полноэкранный режим
map.controls.remove('zoomControl'); // удаляем контрол зуммирования
map.controls.remove('rulerControl'); // удаляем контрол правил


let points;
$.ajax({
    url: "config/mapdb.php",
    type: "POST",
    cache: false,
    async: false,
    data: {"query": ["get_post"]},
    dataType: "json",
    success: function(data){
        points = data;
    }
});
$.ajax({
    url: "config/mapdb.php",
    type: "POST",
    cache: false,
    async: false,
    data: {"query": ["get_pack"]},
    dataType: "json",
    success: function(data){
        packs = data;
    }
});
collection = new ymaps.GeoObjectCollection({}, {});
for (let i = 0; i < points.length; i++){
    point = new ymaps.Placemark([points[i][1], points[i][2]],{
      balloonContentHeader: 'Постамат №' + (i+1),
      balloonContentFooter: points[i][3],
      balloonMaxWidth: 200
    }, {
      iconLayout: 'default#image',
      iconImageHref: 'https://img.icons8.com/color/512/database.png',
      iconImageSize: [30,30],
      iconImageOffset: [-15,-11],
    });
    let placemark_body = 'постамат пустой)';
    for (let j = 0; j < packs.length; j++){
        if(packs[j][3] == i){
            placemark_body = '';
            placemark_body += 'номер посылки: ' + packs[j][1];
            placemark_body += ', товар: ' + packs[j][2];
            if (packs[j][4] == 2 || packs[j][4] == 3){
                placemark_body += ', время доставки: ' + packs[j][4] + ' дня' + '<br>';
            }
            else if (packs[j][4] == 1){
                placemark_body += ', время доставки: ' + packs[j][4] + ' день' + '<br>';
            }
            else {
                placemark_body += ', время доставки: ' + packs[j][4] + ' дней' + '<br>';
            }
        } else {
        }
    }
    point.properties.set({ balloonContentBody: placemark_body});
    collection.add(point);
}
map.geoObjects.add(collection);

}
ymaps.ready(init);
