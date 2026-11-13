<?php echo $__env->make('shared.css_links.css_links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<style>
    ::-webkit-scrollbar {
        display: none !important;
    }

    hr {
        border: 1px solid black;
        width: 25%;
    }

    html,
    body {
        margin: 0;
        height: 100%;
        overflow: hidden
    }

</style>
<title>Paper Consumption Mailer</title>

<body>
    <div class="col-12 text-center" style="margin-top: 10%">
        <hr>
        <h4 style="font-weight: bold;">
            Paper Consumption Mailer
        </h4><br>
        <h1>Do not close!</h1>
        <hr>
        <span id="date"></span><br>
        <span id="time"></span>
    </div>
</body>

<?php echo $__env->make('shared.js_links.js_links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script type="text/javascript">
    function checkDate() {
        var date = new Date();
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        var lastDayOfMonth = lastDay.getDate();

        var dateNow = date.getDate();
        var dateNow_converted = Number(dateNow);
        var lastDayOfMonth_converted = Number(lastDayOfMonth);

        // console.log(date);

        var difference = lastDayOfMonth_converted - dateNow_converted;

        var d = new Date();
        var current_time = d.toLocaleString("en-US", {
            timeZone: 'Asia/Manila',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        $("#time").html(current_time);
        // console.log(dateNow_converted);


        if (difference == 3 || difference == 2 || difference == 1 || dateNow_converted == 1 || dateNow_converted == 2 ||
            dateNow_converted == 3 || dateNow_converted == 4 || dateNow_converted == 5) {
            if (current_time == '07:30:00 AM') {
                SendMail();
            }
        }
    }
    setInterval(checkDate, 500);
</script>
<?php /**PATH /var/www/paper_consumption/resources/views/auto_mailer.blade.php ENDPATH**/ ?>