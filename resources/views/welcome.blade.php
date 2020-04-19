<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">


</head>
<style>
    .countrise_div {
        margin: auto;
        max-width: 30%;
    }

    .spinner-border {
        position: absolute;
        right: 707px;
        top: 103px;
    }

    #cover-spin {
        position: fixed;
        width: 100%;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.7);
        z-index: 9999;
    }

    @-webkit-keyframes spin {
        from {
            -webkit-transform: rotate(0deg);
        }

        to {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    #cover-spin::after {
        content: '';
        display: block;
        position: absolute;
        left: 48%;
        top: 40%;
        width: 40px;
        height: 40px;
        border-style: solid;
        border-color: black;
        border-top-color: transparent;
        border-width: 4px;
        border-radius: 50%;
        -webkit-animation: spin .8s linear infinite;
        animation: spin .8s linear infinite;
    }

    .hide {
        display: none;
    }

    h1 {
        font-family: sans-serif;
        color: #4E443C;
        font-variant: small-caps;
        text-transform: none;
        font-weight: 100;
        margin-bottom: 15px;
        font-size: 25px;

    }

    p {
        font-weight: bold;
        font-size: 34px;
        letter-spacing: -1px;
        text-align: center;
    }

    .confirmed_case {
        color: #DE3700;
    }

    .recovered {
        color: #00AA00;
    }

    .total_deaths {
        color: #767676;
    }

    .card-header {
        text-align: center;
    }
</style>

<body>

    <div class="container mt-4">
        <h1 class="text-header">COVID-19 Tracker</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-header">Total Confirmed Cases</div>
                    <div class="card-body">
                        <p class="confirmed_case count"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-header">Total Recovered Cases</div>
                    <div class="card-body">
                        <p class="recovered count"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-header">Total Fatal Cases</div>
                    <div class="card-body">
                        <p class="total_deaths count"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 countrise_div">
            <div class="col-md-4 col-md-offset-4">
                <select name="" id="countries" onchange="getDataByCountry(this.value)">
                    <option value="" class="form-control">select country</option>
                </select>
            </div>
        </div>
        <div id="cover-spin" class="hide"></div>

    </div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var html_d = '';
    $("#cover-spin").removeClass("hide");

    $.get('response', function(resp) {
        $("#cover-spin").addClass("hide");
        var obj = JSON.parse(resp);
        console.log(resp);
        const total_confirmed_caase = obj.confirmed.value;
        const total_recovered_caase = obj.recovered.value;
        const total_deaths_caase = obj.deaths.value;

        $('.confirmed_case').html(total_confirmed_caase);
        $('.recovered').html(total_recovered_caase);
        $('.total_deaths').html(total_deaths_caase);


    });
    $.get('countries', function(resp) {
        $("#cover-spin").addClass("hide");
        html_d += '<option value="0">select country</option>';
        var obj = JSON.parse(resp);
        const countries = obj.countries;
        countries.forEach(function(country) {
            html_d += '<option value ="' + country.name + '"> ' + country.name + ' </option>';
        });
        $("#countries").html(html_d);
    });

    function getDataByCountry(country) {
        $("#cover-spin").removeClass("hide");

        $.post('countrydata', {
            country: country,
            _token: "{{ csrf_token() }}",
        }, function(resp) {
            $("#cover-spin").addClass("hide");

            var obj = JSON.parse(resp);

            const total_confirmed_caase = obj.confirmed.value;
            const total_recovered_caase = obj.recovered.value;
            const total_deaths_caase = obj.deaths.value;

            $('.confirmed_case').html(total_confirmed_caase);
            $('.recovered').html(total_recovered_caase);
            $('.total_deaths').html(total_deaths_caase);
            $('.count').each(function() {
                $(this).prop('Counter', 100).animate({
                    Counter: $(this).text()
                }, {
                    duration: 4000,
                    easing: 'swing',
                    step: function(now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });
        });
    }
</script>

</html>