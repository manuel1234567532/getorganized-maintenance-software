<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
<div>
  <!--   <h3 for="qr_code">QR Code</h3>-->
    <div style="display: inline-block;">
        <div style="display: inline-block; vertical-align: top;">
            <img id="imagePreview"
                src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $spareparts->qr_code))) }}"
                alt="qr_code Preview" class="br-5" style="max-width: 24mm; max-height: 24mm;">
        </div>
    <!--    <div style="display: inline-block; vertical-align: top; margin-left: 10px;">
            <h4 style="font-size: 12px;">Ersatzteilnummer:</h4>
            <p style="font-size: 12px;">{{ $spareparts->spare_part_number }}</p>
            <h4 style="font-size: 12px;">Bezeichnung:</h4>
            <p style="font-size: 12px;">{{ $spareparts->name_of_part }}</p>
            @if ($spareparts->location && $spareparts->location->name && $spareparts->location_number)
                <h4 style="font-size: 12px;">Lagerplatz:</h4>
                <p style="font-size: 12px;">{{ $spareparts->location->name }}-{{ $spareparts->location_number }}</p>
            @endif
        </div>
    </div>
</div>-->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
