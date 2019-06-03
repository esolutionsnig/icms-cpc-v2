<!-- ================================================
    Scripts
    ================================================ -->
    <!-- jQuery Library -->
    <script type="text/javascript" src="assets/vendors/jquery-3.2.1.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <!--materialize js-->
    <script type="text/javascript" src="assets/js/materialize.min.js"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="assets/js/plugins.js"></script>
    <!--moment.js -->
    <script type="text/javascript" src="assets/js/moment.js"></script>
    <!-- Tags Input -->
    <script src="assets/vendors/tagsinput/jquery.tagsinput.js"></script>
    <!--custom-script.js -->
    <script type="text/javascript" src="assets/js/custom-script.js"></script>
    <!-- data-tables -->
    <script type="text/javascript" src="assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js"></script>
    <!--data-tables.js -->

    <?php if ($session->isBanker() || $session->isBankerCmu() || $session->isCMO()) { echo '' ; } else { if ( $yourCurrentShift == '' || $signedInLocation == '' ) {  ?>
    <script>
        $('#selectShift').modal('open')

        addCloseHandler($('.modal'), function (close) {
            form_changed ? confirm('Confirm?') && close() : close();
        });

        function addCloseHandler($modal, handler) {
            var modal = $modal[0].M_Modal;
            modal._close = modal.close;
            modal.close = function () { handler(function () { modal._close(); }); };
        }

    </script>
    <?php } } ?>

    <script>
        $('.searchableSelect').select2({width: "100%"})
        
        // Prevent Space
        function AvoidSpace(event) {
            var k = event ? event.which : window.event.keyCode
            if (k == 32) return false
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#caTable').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'EXPORT TO EXCEL',
                        className: 'exportExcel',
                        filename: 'Cash Allocation Table',
                        exportOptions: {
                            modifier: {
                            page: 'all'
                            }
                        }
                    }, 
                    {
                        extend: 'copy',
                        text: '<u>C</u>OPY THIS TABLE',
                        className: 'exportExcel',
                        key: {
                            key: 'c',
                            altKey: true
                        }
                    }
                ],
                // "scrollY": 300,
                "scrollX": true
            })
            $('#data-table-simple').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'EXPORT TO EXCEL',
                        className: 'exportExcel',
                        filename: 'Cash Allocation Table',
                        exportOptions: {
                            modifier: {
                            page: 'all'
                            }
                        }
                    }, 
                    {
                        extend: 'copy',
                        text: '<u>C</u>OPY THIS TABLE',
                        className: 'exportExcel',
                        key: {
                            key: 'c',
                            altKey: true
                        }
                    }
                ],
                // "scrollY": 300,
                "scrollX": true
            })
            $('#data-table-noscroll').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'EXPORT TO EXCEL',
                        className: 'exportExcel',
                        filename: 'Cash Allocation Table',
                        exportOptions: {
                            modifier: {
                            page: 'all'
                            }
                        }
                    }, 
                    {
                        extend: 'copy',
                        text: '<u>C</u>OPY THIS TABLE',
                        className: 'exportExcel',
                        key: {
                            key: 'c',
                            altKey: true
                        }
                    }
                ]
            })
        })
    </script>
