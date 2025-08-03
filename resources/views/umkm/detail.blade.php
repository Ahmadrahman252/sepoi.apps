<!DOCTYPE html>
<html>
<head>
    <title>Pantai Dato Majene </title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            display: flex;
            height: 100vh;
        }
        #map {
            flex: 2;
            height: 100%;
        }
        #info {
            flex: 1;
            background: #f8f9fa;
            padding: 25px;
            box-shadow: -2px 0 8px rgba(0,0,0,0.1);
            overflow-y: auto;
        }
        .info-title {
            font-size: 22px;
            margin-bottom: 15px;
            font-weight: bold;
            color: #333;
        }
        .info-image {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .detail-item {
            margin-bottom: 12px;
        }
        .detail-item strong {
            display: inline-block;
            width: 100px;
        }
        .btn-route {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .btn-route:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <div id="info">
        <h3 class="info-title">Pantai Dato Majene</h3>
        <img src="/images/buras.jpeg" alt="Pantai Dato Majene" class="info-image">

        <div class="detail-item"><strong>Alamat:</strong> Dusun Pangale, Baurung, Banggae Timur, Kab. Majene</div>
        <div class="detail-item"><strong>Kategori:</strong> Wisata Alam / Bahari</div>
        <div class="detail-item"><strong>Telepon:</strong> 08ehehehe</div>
        <div class="detail-item"><strong>Fasilitas:</strong> Area parkir, gazebo</div>
        <div class="detail-item"><strong>Jam Buka:</strong> 08:00 - 18:00 WITA</div>
        <div class="detail-item"><strong>Rating:</strong>  4.5 (1,065 ulasan)</div>
        <a href="" target="_blank" class="btn-route">Lihat Rute</a>
    </div>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1bAzttVYqAUhBNExXRYMVG2-kGQY9BJk&callback=initMap">
    </script>
    <script>
        function initMap() {
            var lokasi = { lat: -3.549439, lng: 118.951569 };
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 18,
                center: lokasi,
                mapTypeId: 'satellite'
            });
            new google.maps.Marker({
                position: lokasi,
                map: map,
                title: 'Pantai Dato Majene'
            });
        }
    </script>
</body>
</html>