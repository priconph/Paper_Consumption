<footer class="main-footer bg-dark">
    <div class="float-right d-none d-sm-block">
        <b id="footerTimer"></b>
    </div>
    <strong><a class="text-white" href="https://www.pricon.com.ph/index.php/en/" target="_blank">Pricon
            Microelectronics, Inc.</a></strong>
</footer>

<script type="text/javascript">
    setInterval(() => {
        var now = new Date();
        $("#footerTimer").text(now.toLocaleString("en-US", {
            timeZone: 'Asia/Manila'
        }));
    }, 1000);
</script>
