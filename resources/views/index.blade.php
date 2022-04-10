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
                        <option value="{{ $item->province_code }}"
                            {{ $item->province_code == ($add1_city ?? null) ? 'selected' : '' }}>{{ $item->province_name_en }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <input type="hidden" id="hidden_add1_district_code" value="{{ $add1_district ?? null }}">
                <label>District</label>
                <select id="f_district" class="form-control form-control-sm">
                    {{-- <option value="" disabled>--- Select District ---</option> --}}
                </select>
            </div>

            <div class="form-group">
                <input type="hidden" id="hidden_add1_commune_code" value="{{ $add1_commune ?? null }}">
                <label>Commune</label>
                <select id="f_commune" class="form-control form-control-sm">
                    {{-- <option value="" disabled>--- Select Commune ---</option> --}}
                </select>
            </div>
        </div>

        <div id="add2" style="display: none">
            <div class="form-group">
                <label>City</label>
                <select id="f_city" class="form-control form-control-sm">
                    <option>-- Select City --</option>
                    @foreach ($cities as $item)
                        <option value="{{ $item->province_code }}"
                            {{ $item->province_code == ($add2_city ?? null) ? 'selected' : '' }}>{{ $item->province_name_en }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <input type="hidden" id="hidden_add2_district_code" value="{{ $add2_district ?? null }}">
                <label>District</label>
                <select id="f_district" class="form-control form-control-sm"></select>
            </div>

            <div class="form-group">
                <input type="" id="hidden_add2_commune_code" value="{{ $add2_commune ?? null }}">
                <label>Commune</label>
                <select id="f_commune" class="form-control form-control-sm"></select>
            </div>
        </div>

        <button id="btnR">Run</button <p id="texting"></p>

    </div>

    <script src="{{ asset('vendor/jquery-3.6.0/jquery.min.js') }}"></script>

    <script>
        /// Token for Ajax
        let _token = $('input[name="_token"]').val();
        let userNotEdit = 0;

        /// Function Fetch District from Server using Ajax.
        function district_fetch(cityCode, superDiv, token) {
            $.ajax({
                url: "{{ route('district.fetch') }}",
                method: "get",
                data: {
                    cityCode: cityCode,
                    _token: token
                },
                success: function(response) {
                    let city = response['district'];
                    /// Remove All Option in Select Tag
                    $("#" + superDiv + " #f_district").find("option").remove();

                    city.forEach(function(e) {
                        $("#" + superDiv + " #f_district").append("<option value=" + e.district_code +
                            ">" + e
                            .district_name_en + "</option>");
                    });
                    
                },
                error: function(response) {
                    console.error("Not Working !");
                }
            });
        }

        /// Function to Fetch Commune from Server using Ajax
        function commune_fetch(cityCode, superDiv, token) {
            $.ajax({
                url: "{{ route('commune.fetch') }}",
                method: "get",
                data: {
                    code: cityCode,
                    _token: token
                },
                success: function(response) {
                    let city = response['commune'];
                    /// Remove All Option in Select Tag
                    $("#" + superDiv + " #f_commune").find("option").remove();

                    city.forEach(function(e) {
                        $("#" + superDiv + " #f_commune").append("<option value=" + e.commune_code +
                            ">" + e
                            .commune_name_en + "</option>");
                    });
                    console.log("Fetch Ajax");
                },
                error: function(response) {
                    console.error("Not Working !");
                }
            });
        }

        /// Function Change Select Option.
        function changeSelectedDistrict(startMouseMove, e, districtCode) {
            if (startMouseMove <= 1000) {
                const $select = document.querySelector('#' + e + ' #f_district');
                $select.value = districtCode + "";
                startMouseMove++;
            }
        }

        function changeSelectedCommune(startMouseMove, e, districtCode) {
            if (startMouseMove <= 1000) {
                const $select = document.querySelector('#' + e + ' #f_commune');
                $select.value = districtCode + "";
                startMouseMove++;
            }
        }

        /// Fetch District in Page Create
        $(document).ready(function() {
            const arrAddress = ["add1", "add2"];
            arrAddress.forEach(function(e) {
                $("#" + e + " #f_city").on("change", function() {
                    let cityCode = $(this).val();
                    district_fetch(cityCode, e, _token);
                });
            });
            userNotEdit++;
        });

        /// Fetch Commune in Page Create
        $(document).ready(function() {
            const arrAddress = ["add1", "add2"];
            arrAddress.forEach(function(e) {
                $("#" + e + " #f_district").on("change", function() {
                    let cityCode = $(this).val();
                    commune_fetch(cityCode, e, _token);
                });
            });
        });

        /// Fetch Distritct in Page Edit.
        $(document).ready(function() {
            const arrAddress = ["add1", "add2"];
            let startMouseMove = 0;
            arrAddress.forEach(function(e) {
                /// Send data to Select Tag
                let cityCode = $("#" + e + " #f_city").val();
                district_fetch(cityCode, e, _token);

                /// Select Item in Select Tag
                let districtCode = $("#hidden_" + e + "_district_code").val();
                if (districtCode != "") {
                    document.querySelector('.container').addEventListener('mousemove', function() {
                        changeSelectedDistrict(startMouseMove, e, districtCode);
                    });
                }
            });

        })

        /// Fetch Commune in Page Edit.
        $(document).ready(function() {
            const arrAddress = ["add1", "add2"];
            let startMouseMove = 0;
            arrAddress.forEach(function(e) {
                /// Send data to Select Tag
                let cityCode = $("#" + e + " #hidden_" + e + "_district_code").val();
                commune_fetch(cityCode, e, _token);

                /// Select Item in Select Tag
                let districtCode = $("#hidden_add1_commune_code").val();
                if (districtCode != "") {
                    document.querySelector('.container').addEventListener('mousemove', function() {
                        changeSelectedCommune(startMouseMove, e, districtCode);
                    });
                }
            });
            $("#hidden_add1_district_code").val("");
            $("#hidden_add1_commune_code").val("");
        })

    </script>



</body>

</html>
