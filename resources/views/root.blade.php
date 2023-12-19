<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="redirect-url" content="{{ route('dashboard') }}">
    {{-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script> --}}

    {{--        <title>{{ config('app.name', 'Laravel') }}</title> --}}
    @stack('scripts')
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Scripts -->
    {{-- @vite(['resources/js/app.js']) --}}

    @vite('resources/js/app.js')
    @spladeHead
</head>

<body class="font-sans antialiased">
    @splade
</body>

<!-- @stack('myScripts') -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script  type="text/javascript">
    
$(document).ready(function() {


    $('#paket_id').on('change', function() {
        paket_id = $(this).val();

        $.ajax({
            type: "GET",
            url: '../api/getharga/'+paket_id,
            cache: true,
            success: function(data) {
                $('#harga_paket').val(data[paket_id]);
                console.log(data[paket_id]);
            }
        });

        // console.log(paket_id);
        if(paket_id == 3)
        {
            
            $('#server_id').parent().hide();

        }else{

            $('#server_id').parent().show();
        }

    });
    
    
    $('#server_id').on('change', function() {
        paket_id = $('#paket_id').val();

        $.ajax({
            type: "GET",
            url: '../api/getharga/'+paket_id,
            cache: true,
            success: function(data) {
                $('#harga_paket').val(data[paket_id]);
                console.log(data[paket_id]);
            }
        });


    });
});


    
function printContent() { 

    var printContents = document.getElementById("report").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        } 
</script>
</html>
