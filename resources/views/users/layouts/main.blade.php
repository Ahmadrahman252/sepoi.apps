<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LensaUMKM - Web GIS</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .header {
            background-color: rgba(255, 255, 255, 0.8);
            color: #003366;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(8px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .logo {
            font-size: 1.4rem;
            font-weight: bold;
            color: #003366;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-menu a {
            color: #003366;
            text-decoration: none;
            padding-bottom: 4px;
            border-bottom: 2px solid transparent;
        }

        .nav-menu a.active {
            font-weight: bold;
            border-bottom: 2px solid #003366;
        }

        .nav-menu select {
            padding: 4px;
            border-radius: 4px;
        }

        #map {
            position: absolute;
            top: 60px; 
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 0;
        }

        .login-btn {
            background-color: #003366;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-btn:hover {
            background-color: #00509e;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">LensaUMKM</div>
        <nav class="nav-menu">
            <a href="{{ route('users.index') }}" class="{{ Request::routeIs('users.index') ? 'active' : '' }}">Home</a>
            <a href="{{ route('users.kategori') }}" class="{{ Request::routeIs('users.kategori') ? 'active' : '' }}">Kategori</a>

            @if (Request::routeIs('users.kategori'))
                <select id="kategoriSelect" class="form-select" style="width: 200px;">
                    <option value="">Pilih Risiko</option>
                    <option value="sdm">SDM</option>
                    <option value="pemodalan">Pemodalan</option>
                    <option value="produksi">Produksi</option>
                    <option value="pemasaran">Pemasaran</option>
                    <option value="hukum">Hukum</option>
                </select>
            @endif

           <!-- <button class="login-btn">Login</button> -->
        </nav>
    </div>

    @yield('content')

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    
    <!-- Script untuk menangani dropdown kategori di header -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kategoriSelect = document.getElementById('kategoriSelect');
            if (kategoriSelect) {
                kategoriSelect.addEventListener('change', function() {
                    const selectedCategory = this.value;
                    console.log('Header dropdown changed to:', selectedCategory);
                    
                    if (typeof window.updateMapByCategory === 'function') {
                        window.updateMapByCategory(selectedCategory);
                    }
                });
            }
        });
    </script>
</body>
</html>