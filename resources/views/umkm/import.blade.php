<!DOCTYPE html>
<html>
<head>
    <title>Import Data UMKM</title>
</head>
<body>
    <h2>Import Excel UMKM</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form action="{{ url('/umkm/import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="file">Pilih file Excel:</label>
        <input type="file" name="file" required>
        <br><br>
        <button type="submit">Import</button>
    </form>
</body>
</html>
