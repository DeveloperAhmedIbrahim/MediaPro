<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Cron Job</title>
</head>
<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>
<script>
    var responseCount = 0;
    setInterval(function () {
        $.ajax({
            url: "{{ url('setVideoTiming') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}'
            },
            success:function(response){
                responseCount++;
                console.log(responseCount);
            }
        });
    }, 1000);
</script>
