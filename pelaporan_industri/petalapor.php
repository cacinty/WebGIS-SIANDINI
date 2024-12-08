<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="DIVSIG UGM">
    <meta name="description" content="Leaflet Basic">
    <title>Partisipatif Pemetaan Industri Nganjuk</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        html, body, #map {
            height: 100%;
            width: 100%;
            margin: 0;
        }
    </style>
</head>

<body>
    <div id="map"></div>

    <!-- Modal -->
    <div class="modal fade" id="featureModal" tabindex="-1" role="dialog" aria-labelledby="featureModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="featureModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="featureModalBody"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <!-- leaflet geoserver request link  -->
    <script src="lib/L.Geoserver.js"></script>

    <script>
        // Inisialisasi peta
        var map = L.map("map").setView([-7.606944, 111.936264], 11);

        // Tambahkan basemap
        var basemap1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'OpenStreetMap'
        }).addTo(map);

        L.control.scale({ position: 'bottomright' }).addTo(map);

        // Tambahkan marker dari database dengan PHP
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pelaporan";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "SELECT * FROM industri";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $lat = $row['latitude'];
                $long = $row['longitude'];
                $info = $row['nama_industri'];
                echo "L.marker([$lat, $long]).addTo(map).bindPopup('$info');\n";
            }
        }
        $conn->close();
        ?>

        //Kecamatan nganjuk
        var wmsLayer = L.Geoserver.wms("http://localhost:8080/geoserver/resposni/wms", {
            layers: "resposni:Kecamatan_Nganjuk",
            transparent: true,
        });
        wmsLayer.addTo(map);
    </script>
</body>

</html>
