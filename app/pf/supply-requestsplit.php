<?php
    $error = false;

    require_once('../core/general-functions.php');

    $addedOn                = time();
    $username	 	        = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $usertoken		        = filter_var($_POST['usertoken'], FILTER_SANITIZE_STRING);
    $srsUID	 	            = filter_var($_POST['srsUID'], FILTER_SANITIZE_STRING);
    $splitname	 	        = $_POST['splitname'];

    // Basic Validation
    if (empty($usertoken)) {
        $error = true;
        echo'Unauthorized Request';
    } else if (strlen($usertoken) < 8) {
        $error = true;
        echo'Unauthorized Request';
    }
    if (empty($username)) {
        $error = true;
        echo'Unauthorized User Request';
    } else if (strlen($username) < 4) {
        $error = true;
        echo'Unauthorized User Request';
    }
    if (empty($srsUID)) {
        $error = true;
        echo'Supply Request UID Is Required';
    }
    if (empty($splitname)) {
        $error = true;
        echo'Split Value Is Required';
    }
 
    // Declare Variables
    $sr_id = $srb_id = $client = $branch = $currency = $denomination = $cash_category = $amount = $requested_by = $requested_on = '';

    if( !$error ) {
        require('../core/db.php');
        // Set The Original SRB ID
        $sql = " SELECT *  FROM supply_requests_branch WHERE srb_id = '$srsUID' LIMIT 1 ";                                
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Fetch Existing Data
                $sr_id = $row['sr_id'];
                $srb_id = $row['srb_id'];
                $client = $row['client'];
                $currency = $row['currency'];
                $denomination = $row['denomination'];
                $cash_category = $row['cash_category'];
                $branch = $row['branch'];
                $amount = $row['amount'];
                $requested_by = $row['requested_by'];
                $requested_on = $row['requested_on'];
            }
            // Set is_split to YES
            require('../core/db.php');
            $sql = "UPDATE supply_requests_branch SET is_splitted = 'YES' WHERE srb_id = '$srsUID' ";
            if ($con->query($sql) === true) {
                echo "";
            } else {
                echo "Error: " . $sql . "<br>" . $con->error;
            }
        }
        foreach($splitname as $newAmount){
            splitThisBag($sr_id, $client, $branch, $currency, $denomination, $cash_category, $newAmount, $requested_by, $requested_on);
        }
    }

    // Split Supply Request function
    function splitThisBag($sr_id, $client, $branch, $currency, $denomination, $cash_category, $newAmount, $requested_by, $requested_on)
    {
        require('../core/db.php');
        // Insert New Splitted Bags Into New Rows
        $sql = "INSERT INTO supply_requests_branch (sr_id, client, branch, currency, denomination, cash_category, amount, requested_by, requested_on)
                VALUES ('$sr_id', '$client', '$branch', '$currency', '$denomination', '$cash_category', '$newAmount', '$requested_by', '$requested_on')";
        if ($con->query($sql) === true) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
        $con->close();
    }