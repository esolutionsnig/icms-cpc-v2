<?php
if (isset($_POST['clientId'])) {
    require('../core/db.php');
    $clientId = filter_var($_POST['clientId'], FILTER_SANITIZE_STRING);
    $sql = "SELECT * FROM bank_branch WHERE bank_id = '$clientId' ORDER BY branch_id ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        echo '<div class="input-field col s12">';
            echo '<select id="clientBranchName">';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
        }
            echo '</select>
            <label>Client Branch Name</label>';
        echo '</div>';
    } else {
        echo '<div class="input-field col s12">
        <select id="clientBranchName">
            <option>------- Select Client Branch --------</option>
        </select>
        <label>Client Branch Name</label>
    </div>';
    }
}
