<link href="assets/vendors/prism/prism.css" type="text/css" rel="stylesheet">
<link href="assets/vendors/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet">
<?php
// Get all Banks

  // Add DB Connection
    require('../core/db.php');
    $sno = 1;
    $sql = "SELECT * FROM banks ORDER BY bank_id DESC";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th class="width-5">S/No</th>
                    <th class="width-50">Long Name</th>
                    <th class="width-5">Short Name</th>
                    <th class="width-5">Branches</th>
                    <th class="width-5">Reps</th>
                    <th class="width-30">ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>S/No</th>
                    <th>Long Name</th>
                    <th>Short Name</th>
                    <th>Branches</th>
                    <th>Reps</th>
                    <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $row['bank_name'] . '</td>
                <td>' . $row['bank_code'] . '</td>
                <td>12</td>
                <td>12</td>
                <td>
                    <button data-target="updateBank" class="btn waves-effect waves-light blue lighten-1 white-text updateRecord modal-trigger" data-id="' . $row['bank_id'] . '" data-name="' . $row['bank_name'] . '" data-code="' . $row['bank_code'] . '" data-slug="' . $row['bank_slug'] . '">
                        Edit <i class="material-icons left">edit</i>
                    </button>
                    <button data-target="deleteBank" class="btn waves-effect waves-light primary-btn modal-trigger deleteRecord" data-id="' . $row['bank_id'] . '" data-name="' . $row['bank_name'] . '">
                        Delete <i class="material-icons left">delete</i>
                    </button>
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No Bank found. <button data-target="addBank" class="btn waves-effect waves-red white blue-grey-text modal-trigger ml-3"><i class="material-icons left">add</i> Click Here To Add New Bank</button>';
    }
    $con->close();

?>
<!-- data-tables -->
<script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
<!--data-tables.js -->
<script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>
<script type="text/javascript" src="assets/js/pages/currencies.js"></script>