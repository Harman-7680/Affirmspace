<!DOCTYPE html>
<html>
<head>
    <title>Your Location Detector</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #d8e4f4ff;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            width: 90%;
            max-width: 550px;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            text-align: center;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .coords, .details {
            background: #eef5ff;
            border-radius: 10px;
            padding: 12px;
            margin: 10px 0;
            text-align: left;
        }

        .label {
            font-weight: bold;
        }

        #map {
            height: 300px;
            width: 100%;
            margin-top: 15px;
            border-radius: 15px;
        }

        .loading {
            color: gray;
            font-style: italic;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="title">Your Current Location</div>

    <div class="coords">
        <p><span class="label">Latitude:</span> <span id="lat" class="loading">Detecting...</span></p>
        <p><span class="label">Longitude:</span> <span id="lng" class="loading">Detecting...</span></p>
    </div>

    <div class="details">
        <p><span class="label">City:</span> <span id="city" class="loading">Detecting...</span></p>
        <p><span class="label">State:</span> <span id="state" class="loading">Detecting...</span></p>
        <p><span class="label">Postal Code:</span> <span id="pincode" class="loading">Detecting...</span></p>
        <p><span class="label">Country:</span> <span id="country" class="loading">Detecting...</span></p>
        <p><span class="label">Full Address:</span> <span id="full" class="loading">Detecting...</span></p>
    </div>

    <div id="map"></div>
</div>


<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(async (position) => {

        const lat = position.coords.latitude;
        const lng = position.coords.longitude;

        document.getElementById("lat").innerText = lat;
        document.getElementById("lng").innerText = lng;

        // Free Reverse Geocoding API (NO KEY REQUIRED)
        const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;

        try {
            const response = await fetch(url, {
                headers: {
                    'User-Agent': 'AffirmSpace/1.0'
                }
            });

            const data = await response.json();
            const address = data.address;

            document.getElementById("city").innerText = address.city || address.town || address.village || "Not Found";
            document.getElementById("state").innerText = address.state || "Not Found";
            document.getElementById("country").innerText = address.country || "Not Found";
            document.getElementById("pincode").innerText = address.postcode || "Not Found";
            document.getElementById("full").innerText = data.display_name || "Not Found";

        } catch (err) {
            console.log("Error fetching city:", err);
        }

        // Map Setup
        const map = L.map('map').setView([lat, lng], 13);

        // No API key needed map tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup("You are here!")
            .openPopup();

    },
    (error) => {
        alert("Error: " + error.message);
    });
} else {
    alert("Geolocation not supported.");
}
</script>

</body>
</html>
