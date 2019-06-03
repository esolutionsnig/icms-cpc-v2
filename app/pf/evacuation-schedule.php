<?php
// Get all Evacuation Requests
// function getAllEvacuationRequests()
// {
//     $totalNaira = $totalEuro = $totalUsd = $totalGbp = $totalZar = $totalCfa = $totalCny = 0;
//     // Add DB Connection
//     require('./app/core/db.php');
//     $sno = 1;
//     $sql = "SELECT * FROM bank_requests WHERE preannounced = 'NO' ORDER BY er_id DESC";
//     $result = $con->query($sql);

//     if ($result->num_rows > 0) {
//         echo '<table id="data-table-simple" class="responsive-table display" cellspacing="0">';
//         echo '<thead>
//                 <tr>
//                     <th>S/No</th>
//                     <th>Request Title</th>
//                     <th>Client</th>
//                     <th>Branch Location</th>
//                     <th>Destination</th>
//                     <th>Prepared</th>
//                     <th class="width-25">ACTIONS</th>
//                 </tr>
//             </thead>
//             <tfoot>
//                 <tr>
//                     <th>S/No</th>
//                     <th>Request Title</th>
//                     <th>Client</th>
//                     <th>Branch Location</th>
//                     <th>Destination</th>
//                     <th>Prepared</th>
//                     <th>ACTIONS</th>
//                 </tr>
//             </tfoot>
//             <tbody>';
//         // output data of each row
//         while ($row = $result->fetch_assoc()) {
//             $bUID = $row['er_id'].'------'.$row['er_slug'].'------el';
//             $bankUID = base64_encode($bUID);
//             //get client name
//             $reqClientName      = getClientNameById($row['bank_id']);
//             $clientName         = $reqClientName['bank_name'];
//             //get consignement 
//             $reqConsLoc             = getConsignmentLocationById($row['consignment_location_id']);
//             $consignmentLocation    = $reqConsLoc['location_name'];

//             $citConfirmationToken = $row['er_id'] . 'cittoken18' . time() . 'cittoken18' . $row['bank_id'];

//             echo '<tr>
//                 <td>' . $sno++ . '</td>
//                 <td><a href="evacuation-request-r?r=' . $row['er_slug'].'cprf'.$bankUID .'" style="color: #504c75 !important;">' . $row['er_name'] . '</a></td>
//                 <td>' . $clientName . '</td>
//                 <td>' . $row['location_code'] . '</td>
//                 <td>'. $consignmentLocation .'</a></td>';
//                 echo '<td><strong>'; number_format(getNumberPreparedBagsPerRequest($row['er_id'])); echo '</strong> Bag(s)</td>
//                 <td>
//                     <a href="evacuation-request-r?r=' . $row['er_slug'].'cprf'.$bankUID .'" class="btns btns-read waves-effect waves-light" style="color: teal !important; margin: 3px !important;">
//                         View  <i class="material-icons left">link</i>
//                     </a>
//                     ';
//                     if ($row['cp_done'] == 'NO') {
//                         echo '
//                     <a href="evacuation-request-p?r=' . $row['er_slug'].'cprf'.$bankUID .'" class="btns btns-edit waves-effect waves-light" style="color: white !important; margin: 3px !important;">
//                         Prepare Cash <i class="material-icons left">local_mall</i>
//                     </a>';
//                     }
//                     if ( $row['cit'] == 'NO' && bagExists($row['er_id']) ) {
//                         echo '<button data-target="hoc" class="btns btns-add waves-effect waves-teal cho modal-trigger" data-id="' . $row['er_id'].'" data-name="' . $row['er_name'].'" data-ctokn="' . $citConfirmationToken.'"><i class="material-icons left">rv_hookup</i> Hand Over Consignment </button>';
//                     }
//                     if ($session->isSuperAdmin() || $session->isBankerCmu()) {
//                         echo '<a href="evacuation-request-e?r=' . $row['er_slug'].'cprf'.$bankUID .'" class="btns light-blue waves-effect waves-light" style="color: white !important; margin: 3px !important;">
//                         Edit Request <i class="material-icons left">local_mall</i>
//                         </a>';
//                     }
//                     echo '
//                 </td>
//             </tr>';
//         }
//         echo '</tbody>
//         </table>';
//     } else {
//         echo 'No request found. <a href="evacuation-request-c" class="btns btns-add waves-effect waves-teal" style="color: white !important"><i class="material-icons left">add</i> Make New Request</a>';
//     }
//     $con->close();
// }