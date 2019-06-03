<link href="assets/vendors/prism/prism.css" type="text/css" rel="stylesheet">
<link href="assets/vendors/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet">
<?php
// Get all deposit types

  // Add DB Connection
    require('../core/db.php');
    $sno = 1;
    $sql = "SELECT * FROM deposit_category ORDER BY dc_id DESC";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
        echo '<thead>
                <tr>
                <th class="width-5">S/No</th>
                <th class="width-75">Deposit Category</th>
                <th class="width-20">ACTIONS</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                <th>S/No</th>
                <th>Deposit category</th>
                <th>ACTIONS</th>
                </tr>
            </tfoot>
            <tbody>';
    // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                <td>' . $sno++ . '</td>
                <td>' . $row['dc_name'] . '</td>
                <td>
                    <button data-target="updateDepositCategory" class="btn waves-effect waves-light blue lighten-1 white-text updateRecord modal-trigger" data-id="' . $row['dc_id'] . '" data-name="' . $row['dc_name'] . '" data-slug="' . $row['dc_slug'] . '">
                        Edit <i class="material-icons left">edit</i>
                    </button>
                    <button data-target="deleteDepositCategory" class="btn waves-effect waves-light primary-btn modal-trigger deleteRecord" data-id="' . $row['dc_id'] . '" data-name="' . $row['dc_name'] . '">
                        Delete <i class="material-icons left">delete</i>
                    </button>
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>';
    } else {
        echo 'No deposit category found. <button data-target="addDepositCategory" class="btn waves-effect waves-red white blue-grey-text modal-trigger ml-3"><i class="material-icons left">add</i> Click Here To Add New Deposit Category</button>';
    }
    $con->close();

?>
<!-- data-tables -->
<script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
<!--data-tables.js -->
<script type="text/javascript" src="assets/js/scripts/data-tables.js"></script>
<script type="text/javascript" src="assets/js/pages/deposit-categories.js"></script>