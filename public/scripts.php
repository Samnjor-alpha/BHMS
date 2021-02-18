<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="../dist/js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="../dist/js/scripts.js"></script>
<script src="../dist/js/tags.js"></script>
<script type="text/javascript">
    var idleMax = 15; // Logout after 30 minutes of IDLE
    var idleTime = 0;

    var idleInterval = setInterval("timerIncrement()", 60000);  // 1 minute interval
    $( "body" ).mousemove(function( event ) {
        idleTime = 0; // reset to zero
    });

    // count minutes
    function timerIncrement() {
        idleTime = idleTime + 1;
        if (idleTime > idleMax) {
            //alert("Session expired.");

            swal("", "Session Time out!", "error").then(function() {
                window.location.href='../Dashboard/process-data/logout.php';
            });
//window.location.reload(true);

        }
    }


</script>
