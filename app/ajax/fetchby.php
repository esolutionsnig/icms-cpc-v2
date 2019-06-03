<?php
    include_once("../core/db.php");
    $callby = $_POST['callby'];
    $id = $_POST['speakerId'];
for ($i=0; $i<sizeof($id); $i++) {
    $sql = "UPDATE testimonials SET fetchby = '$callby[$i]' WHERE id = '$id[$i]' ";
    $run_query = mysqli_query($con, $sql);
}
?>
<script type="text/javascript">
    window.location = "../../testimonials";
</script>