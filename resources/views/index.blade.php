<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-4.6.0/css/bootstrap.min.css') }}">
</head>

<body style="background-color: #536dfe">

    <div class="container w-75 bg-white my-5 py-3">
        <div id="add1">
            <div class="form-group">
                <label>City</label>
                <select id="f_city" class="form-control form-control-sm">
                    <option>-- Select City --</option>
                    @foreach ($cities as $item)
                        <option value="{{ $item->province_code }}">{{ $item->province_name_en }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>District</label>
                <select id="f_district" class="form-control form-control-sm"></select>
            </div>

            {{-- <div class="form-group">
                <label>Commune</label>
                <select id="f_commune" class="form-control form-control-sm"></select>
            </div> --}}
        </div>

        <div id="add2">
            <div class="form-group">
                <label>City</label>
                <select id="f_city" class="form-control form-control-sm">
                    <option>-- Select City --</option>
                    @foreach ($cities as $item)
                        <option value="{{ $item->province_code }}" {{ $item->province_code == 12 ? "selected" : "" }} >{{ $item->province_name_en }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>District</label>
                <select id="f_district" class="form-control form-control-sm"></select>
            </div>

            {{-- <div class="form-group">
                <label>Commune</label>
                <select id="f_commune" class="form-control form-control-sm"></select>
            </div> --}}
        </div>

        <p id="texting"></p>

    </div>

    <script src="{{ asset('vendor/jquery-3.6.0/jquery.min.js') }}"></script>
    
    <script>
        /// Function Fetch City from Server using Ajax
        function city_fetch(cityCode, superDiv, token) {
            $.ajax({
                url: "{{ route('address.fetch') }}",
                method: "get",
                data: {
                    cityCode: cityCode,
                    _token: token
                },
                success: function(response) {
                    let city = response['cities'];
                    /// Remove All Option in Select Tag
                    $("#" + superDiv + " #f_district").find("option").remove();
                    city.forEach(function(e) {
                        $("#" + superDiv + " #f_district").append("<option>" + e
                            .district_name_en + "</option>");
                    });
                },
                error: function(response) {
                    console.error("Not Working !");
                }
            });
        }

        /// Fetch Address in Page Create
        $(document).ready(function() {

            const arrAddress = ["add1", "add2"];

            arrAddress.forEach(function(e) {
                $("#" + e + " #f_city").on("change", function() {
                    let cityCode = $(this).val();
                    console.log("🚀 ~ file: index.blade.php ~ line 46 ~ $ ~ cityCode", cityCode)
                    let _token = $('input[name="_token"]').val();
                    city_fetch(cityCode, e, _token);
                });
            });


        });


        /// Fetch Address in Page Edit
        $(document).ready(function () {
            const arrAddress = ["add2"];

            arrAddress.forEach(function (e) {
                let cityCode = $("#" +e+ " #f_city").val();
                console.log(cityCode);
            })
        })

    </script>

    

</body>

</html>
