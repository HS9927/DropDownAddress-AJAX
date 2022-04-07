<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset("vendor/bootstrap-4.6.0/css/bootstrap.min.css") }}">
</head>
<body>

    <div class="container mt-2">
        <div class="form-group">
            <label>City</label>
            <select id="f_city" class="form-control form-control-sm">
                <option>-- Select City --</option>
                @foreach($cities as $item)
                    <option value="{{ $item->province_code }}">{{ $item->province_name_en }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>District</label>
            <select id="f_district" class="form-control form-control-sm"></select>
        </div>

        <div class="form-group">
            <label>Commune</label>
            <select id="f_commune" class="form-control form-control-sm"></select>
        </div>

    </div>

<script src="{{ asset("vendor/jquery-3.6.0/jquery.min.js") }}"></script>
<script>
    $(document).ready(function () {


        $("#f_city").on("change", function () {
            let cityCode = $("#f_city").val();


            $.ajax({
                type: "POST",
                url: "{{ route("address.fetch") }}",
                date: {
                    code: cityCode,
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (response) {
                    console.error("Not Working !");
                }

            });
        });
    });
</script>
</body>
</html>
