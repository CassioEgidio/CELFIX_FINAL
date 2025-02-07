<?php    
    $pageTitle = "Mapa";
    $pageCSS = ["mapa.css"];
    $pageJS = [""];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');

    include $BASE_PATH . 'src/View/header.php';

?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<main>
    <div class="back-main">
        <div id="map">

        </div>
    </div>
</main>

<script>

    var map = L.map('map').setView([-23.546235736986706, -46.50203815310063], 13);
    var layer = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
	    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
	    subdomains: 'abcd',
 	    minZoom: 10,
	    maxZoom: 20
    });
    layer.addTo(map);

    var icon = L.icon({
        iconUrl: '<?= $BASE_URL ?>imagens/distance.svg', 

        iconSize:     [35, 40], // size of the icon
        iconAnchor:   [35, 40], // point of the icon which will correspond to marker's location
        popupAnchor:  [-18, -40] // point from which the popup should open relative to the iconAnchor
    });

    L.marker([-23.546235736986706, -46.50203815310063], {icon: icon}).addTo(map).bindPopup("<b>Unidade Vila Nhocuné</b><br>R. Padre Antônio de Andrade, 133 - Vila Nhocuné, São Paulo - SP, 03559-080");
    L.marker([-23.526311210493187, -46.46974633243943], {icon: icon}).addTo(map).bindPopup("<b>Unidade A.E Carvalho 1</b><br>R. Santos Dumont, 351 - Cidade Antônio Estêvão de Carvalho, São Paulo - SP, 08223-268");
    L.marker([-23.537265857420483, -46.46896180804703], {icon: icon}).addTo(map).bindPopup("<b>Unidade A.E Carvalho 2</b><br>Rua Surucuás, 268 - Cidade Antônio Estêvão de Carvalho, São Paulo - SP, 08220-000");
    L.marker([-23.504361678301763, -46.412721144409375], {icon: icon}).addTo(map).bindPopup("<b>Unidade Jardim dos Ipes</b><br>R. Erva Cigana, 23 - Jardim dos Ipes, São Paulo - SP, 08161-370");
    L.marker([-23.531910957331714, -46.46207175632541], {icon: icon}).addTo(map).bindPopup("<b>Unidade Jardim Itapemirim</b><br>R. Alexandre Dias, 277 - Jardim Itapemirim, São Paulo - SP, 08225-250");

</script>