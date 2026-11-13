<?php echo $__env->make('shared.css_links.css_links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<style>
    ::-webkit-scrollbar 
    {
            display: none !important;
    }
    hr
    {
        border: 1px solid black;
    }
    html, body 
    {
        margin: 0;
        height: 100%;
        overflow: hidden
    }
</style>
<title>Paper Consumption Computation</title>
<body>
<div class="col-12 text-center" style="margin-top: 10%">
    <hr>
    <h4 style="font-weight: bold;">
        Paper Consumption Month End Computation
    </h4><br>
    <h1>Do not close!</h1>
    <hr>
    <span id="date"></span><br>
    <span id="time"></span>
</div>
</body>

<?php echo $__env->make('shared.js_links.js_links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script type="text/javascript">

function time()
{
    var d = new Date(); //without params it defaults to "now"
    var current_time = d.toLocaleString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    $("#time").html(current_time);

    // Compare current date to next month 1st day
    var date = new Date();
    var firstDay = new Date(date.getFullYear(), date.getMonth() +1, 2);
    var first_day_next_month = firstDay.toISOString().slice(0,10);

    var month = new Date(
    new Date().getFullYear(),
    new Date().getMonth(), 
    new Date().getDate()
    );
    var current_date = month.toISOString().slice(0,10);
    // var current_date1 = month.toISOString().slice(0,10);
    $("#date").html(current_date);

    if(current_date == first_day_next_month && current_time == '04:00:00 AM')
    {
        GetTotalUsedPerMonth();
    }
    // Compare current date to next month 1st day end

    if(current_date == current_date && current_time == '04:30:00 PM')
    {
        AddPaperPurchasedAndBeginningBal();
    }
}

setInterval(time,1000);

// function pad(value) {
// if(value < 10) {
//     return '0' + value;
// } else {
//     return value;
// }  
// }
// var current_time = pad(d.getHours()) + ":" + pad(d.getMinutes()) + ":" + pad(d.getSeconds());
</script><?php /**PATH /var/www/paper_consumption/resources/views/automated_computation.blade.php ENDPATH**/ ?>