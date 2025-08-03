@extends('users.layouts.main')

@section('content')
<div id="map" style="height: 100vh; border: 1px solid #ccc;"></div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    let map = L.map('map').setView([-3.5, 118.95], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const umkms = @json($umkms);
    let markers = []; 

    console.log('Data UMKM:', umkms); 

    const riskFieldMapping = {
        'sdm': 'resiko_sdm',
        'pemodalan': 'risiko_pemodalan', 
        'produksi': 'risiko_produksi',
        'pemasaran': 'risiko_pemasaran',
        'hukum': 'risiko_hukum'
    };

    function getRiskColor(riskLevel) {
        console.log('Risk level:', riskLevel); 
        switch(riskLevel) {
            case 'Tinggi':
                return 'red';
            case 'Sedang':
                return 'orange';
            case 'Rendah':
                return 'green';
            default:
                return 'blue';
        }
    }

    function getMarkerIcon(color) {
        let iconUrl;
        switch(color) {
            case 'green':
                iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png';
                break;
            case 'orange':
                iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-orange.png';
                break;
            case 'red':
                iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png';
                break;
            default:
                iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png';
        }

        return L.icon({
            iconUrl: iconUrl,
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
            shadowSize: [41, 41]
        });
    }
    function createPopupContent(umkm, selectedCategory) {
        let riskInfo = '';
        
        if (selectedCategory) {
            const riskField = riskFieldMapping[selectedCategory];
            const riskLevel = umkm[riskField];
            
            if (riskLevel) {
                const categoryNames = {
                    'sdm': 'SDM',
                    'pemodalan': 'Pemodalan',
                    'produksi': 'Produksi',
                    'pemasaran': 'Pemasaran',
                    'hukum': 'Hukum'
                };
                
                riskInfo = `<br><strong>Risiko ${categoryNames[selectedCategory]}:</strong> <span style="color: ${getRiskColor(riskLevel)}; font-weight: bold;">${riskLevel}</span>`;
            }
        }

        return `
            <strong>${umkm.nama}</strong><br>
            Usaha: ${umkm.usaha || 'Tidak disebutkan'}<br>
            Desa: ${umkm.kelurahan_desa || 'Tidak disebutkan'}<br>
            Kontak: ${umkm.kontak || 'Tidak ada'}<br>
            Kelas Usaha: ${umkm.kelas_usaha || 'Tidak disebutkan'}${riskInfo}<br>
            <a href="https://www.google.com/maps?q=${parseFloat(umkm.y)},${parseFloat(umkm.x)}" target="_blank" style="color: #1a73e8;">Lihat di Google Maps</a>
        `;
    }

    function renderMarkers(selectedCategory = '') {
        console.log('Selected category:', selectedCategory); 
        
        markers.forEach(marker => {
            map.removeLayer(marker);
        });
        markers = [];

        umkms.forEach(umkm => {
            let lat = parseFloat(umkm.y);
            let lng = parseFloat(umkm.x);

            if (!isNaN(lat) && !isNaN(lng)) {
                let color = 'blue'; 

                // inini yang nentukan warnaya risiko
                if (selectedCategory && riskFieldMapping[selectedCategory]) {
                    const riskField = riskFieldMapping[selectedCategory];
                    const riskLevel = umkm[riskField];
                    
                    console.log(`UMKM: ${umkm.nama}, Field: ${riskField}, Level: ${riskLevel}`); // Debug
                    
                    if (riskLevel) {
                        color = getRiskColor(riskLevel);
                    }
                }

                let icon = getMarkerIcon(color);
                let marker = L.marker([lat, lng], { icon })
                    .bindPopup(createPopupContent(umkm, selectedCategory))
                    .addTo(map);

                markers.push(marker);
            }
        });

        console.log('Total markers created:', markers.length); 
    }

    window.updateMapByCategory = function(selectedCategory) {
        console.log('Category changed from header:', selectedCategory); 
        renderMarkers(selectedCategory);
    };
    document.addEventListener('DOMContentLoaded', function() {
        const kategoriSelect = document.getElementById('kategoriSelect');
        if (kategoriSelect) {
            kategoriSelect.addEventListener('change', function() {
                const selectedCategory = this.value;
                console.log('Dropdown changed to:', selectedCategory); 
                renderMarkers(selectedCategory);
            });
        }
    });

    renderMarkers();
</script>
@endsection