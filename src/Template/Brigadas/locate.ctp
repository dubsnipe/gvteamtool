<!-- File: src/Template/Brigadas/locate.ctp -->

<?= $this->Html->script('https://unpkg.com/leaflet@1.4.0/dist/leaflet.js', ['block' => 'script']); ?>
<?php $this->Html->css('https://unpkg.com/leaflet@1.4.0/dist/leaflet.css', ['block' => 'styles']); ?>

<?php $this->Html->scriptStart(['block' => 'bottomScript']);?>
	var map = L.map('leafletmap').fitWorld();

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(map);

	function onLocationFound(e) {
		var radius = e.accuracy / 2;

		L.marker(e.latlng).addTo(map)
			.bindPopup("You are within " + radius + " meters from this point").openPopup();

		L.circle(e.latlng, radius).addTo(map);
	}

    function zoomTo() {
        var lat = document.getElementById("lat").value;
        var lng = document.getElementById("lon").value;
        map.panTo(new L.LatLng(lat, lon));
    }  

	function onLocationError(e) {
		alert(e.message);
	}

	map.on('locationfound', onLocationFound);
	map.on('locationerror', onLocationError);

	map.locate({setView: true, maxZoom: 16});
    
<?php $this->Html->scriptEnd(); ?>

    
<div class="container">
    <h1>Locate teams</h1>
    <div id="leafletmap" style="height: 70vh;"></div>
    <form class="row">
        <div class="col s6">
            <label>Lon</label>
            <input type="number" step="0.0001" name="lon" id="lon">
        </div>
        <div class="col s6">
            <label>Lat</label>
            <input type="number" step="0.0001" name="lat" id="lat">
        </div>
        <input type="button" onclick="zoomTo()" value="zoomTo"/>
    </form>
</div>