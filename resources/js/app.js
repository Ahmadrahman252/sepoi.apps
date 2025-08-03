import './bootstrap';
let map;
let markers = [];

async function initMap() {
    // Inisialisasi peta
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: { lat: -3.5494, lng: 118.9516 },
        mapTypeId: 'terrain',
        styles: [
            {
                featureType: 'water',
                elementType: 'geometry',
                stylers: [{ color: '#a2daf2' }]
            },
            {
                featureType: 'landscape',
                elementType: 'geometry',
                stylers: [{ color: '#f5f5f2' }]
            },
            {
                featureType: 'road',
                elementType: 'geometry',
                stylers: [{ color: '#ffffff' }, { weight: 1.5 }]
            }
        ],
        disableDefaultUI: true,
        zoomControl: false,
        mapTypeControl: false,
        scaleControl: true,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: true
    });

    // Ambil data UMKM dari API
    try {
        console.log('Fetching UMKM data...');
        const response = await fetch('/api/umkm');
        const umkmData = await response.json();
        
        console.log('UMKM data received:', umkmData.length, 'items');
        console.log('Data:', umkmData);

        // Buat marker untuk setiap UMKM
        umkmData.forEach((umkm, index) => {
            createMarker(umkm, index);
        });

        // Auto zoom jika ada data
        if (umkmData.length > 0) {
            const bounds = new google.maps.LatLngBounds();
            umkmData.forEach(umkm => {
                bounds.extend(new google.maps.LatLng(parseFloat(umkm.latitude), parseFloat(umkm.longitude)));
            });
            map.fitBounds(bounds);
        }

    } catch (error) {
        console.error('Error fetching UMKM data:', error);
    }
}

function createMarker(umkm, index) {
    try {
        const lat = parseFloat(umkm.latitude);
        const lng = parseFloat(umkm.longitude);

        // Validasi koordinat
        if (isNaN(lat) || isNaN(lng)) {
            console.error(`Invalid coordinates for UMKM ${umkm.id}:`, lat, lng);
            return;
        }

        console.log(`Creating marker ${index + 1}: ${umkm.nama_pemilik} at ${lat}, ${lng}`);

        const marker = new google.maps.Marker({
            position: { lat: lat, lng: lng },
            map: map,
            title: umkm.nama_pemilik,
            icon: {
                url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                    <svg width="30" height="40" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 0C6.7 0 0 6.7 0 15c0 15 15 25 15 25s15-10 15-25C30 6.7 23.3 0 15 0z" fill="#e11d48"/>
                        <circle cx="15" cy="15" r="6" fill="white"/>
                        <circle cx="15" cy="13" r="3" fill="#e11d48"/>
                        <text x="15" y="35" text-anchor="middle" fill="white" font-size="8">${index + 1}</text>
                    </svg>
                `),
                scaledSize: new google.maps.Size(30, 40),
                anchor: new google.maps.Point(15, 40)
            }
        });

        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div style="font-family: Arial, sans-serif; font-size: 14px; max-width: 250px;">
                    <div style="font-weight: bold; color: #1a73e8; margin-bottom: 8px;">
                        ${umkm.nama_pemilik || 'UMKM'}
                    </div>
                    <div style="margin-bottom: 4px;">
                        <strong>Jenis:</strong> ${umkm.jenis_usaha || '-'}
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>Desa:</strong> ${umkm.desa || '-'}
                    </div>
                    <button onclick="window.location.href='/umkm/${umkm.id}/detail'" 
                            style="background: #1a73e8; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">
                        Detail
                    </button>
                </div>
            `
        });

        // Event listener untuk marker
        marker.addListener('click', () => {
            console.log(`Marker clicked: ${umkm.nama_pemilik}`);
            // Tutup semua info window yang terbuka
            markers.forEach(m => {
                if (m.infoWindow) {
                    m.infoWindow.close();
                }
            });
            // Buka info window untuk marker ini
            infoWindow.open(map, marker);
        });

        // Double click untuk langsung ke detail
        marker.addListener('dblclick', () => {
            window.location.href = `/umkm/${umkm.id}/detail`;
        });

        // Simpan marker dan info window
        markers.push({ marker, infoWindow });

    } catch (error) {
        console.error(`Error creating marker for UMKM ${umkm.id}:`, error);
    }
}

// Fungsi zoom
function zoomIn() {
    const currentZoom = map.getZoom();
    if (currentZoom < 20) {
        map.setZoom(currentZoom + 1);
    }
}

function zoomOut() {
    const currentZoom = map.getZoom();
    if (currentZoom > 1) {
        map.setZoom(currentZoom - 1);
    }
}