@extends('users.layouts.main')

@section('content')
<div class="container" style="padding: 20px;">
    <h2>Data UMKM</h2>
    <div id="map" style="height: 550px; border: 1px solid #ccc;"></div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    let map = L.map('map').setView([-3.5, 118.95], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const umkms = @json($umkms);

    umkms.forEach(umkm => {
        let lat = parseFloat(umkm.y);
        let lng = parseFloat(umkm.x);

        if (!isNaN(lat) && !isNaN(lng)) {
            
            let icon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                shadowSize: [41, 41]
            });

            L.marker([lat, lng], { icon }).bindPopup(`
                <strong>${umkm.nama}</strong><br>
                Usaha: ${umkm.usaha}<br>
                Desa: ${umkm.kelurahan_desa}<br>
                Kontak: ${umkm.kontak}<br>
                Kelas Usaha: ${umkm.kelas_usaha}<br>
                <a href="https://www.google.com/maps?q=${lat},${lng}" target="_blank" style="color: #1a73e8;">Lihat di Google Maps</a>
            `).addTo(map);
        }
    });
</script>
@endsection
