jQuery(document).ready(function($) {

    var bankName = ""
    var bankSlug = ""
    var bankCode = ""
    var ubankName = ""
    var ubankCode = ""
    var ubankSlug = ""

    $("#bankName").keyup(function() {
        bankName = $(this).val()
        bankSlug = bankName.replace(/\s+/g, '-').toLowerCase()
        if (bankName == '') {
            Materialize.toast('Bank  Name Is Required', 3000, 'rounded')
        }
    })

    $("#bankCode").keyup(function() {
        bankCode = $(this).val()
        if (bankCode == '') {
            Materialize.toast('Bank  Short Name Is Required', 3000, 'rounded')
        }
    })

    // Add Bank
    $(".addBtn").click(function(event) {
        event.preventDefault();
        var bankName = $("#bankName").val()
        var bankCode = $("#bankCode").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (bankName == '' || bankCode == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly enter all fields', 4000, 'rounded');
        } else {
            $(".addBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".addBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/banks.php",
                method: "POST",
                data: { addBank: 1, bankName: bankName, bankCode:bankCode, bankSlug:bankSlug, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".addBtn").html('<i class="material-icons left">save</i> Save ')
                    $(".addBtn").removeAttr('disabled')
                    $("#load-banks").load('app/pf/banks-load.php')
                    if (data == "ok200") {
                        $(".bankName").val('')
                        $(".bankCode").val('')
                        Materialize.toast('New Bank '+bankName+' successfully created', 4000, 'rounded')
                        window.setTimeout(function() {
                            $('#addBank').modal('close')
                        }, 4000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed, try again or contact support if error persists', 4000, 'rounded')
                    }
                }
            })
        }
    })

    //Fetch data from butoon and pass to bs-modal
    $(".updateRecord").click(function(event){
        event.preventDefault();
        var bankId = $(this).data('id');
        var banksName = $(this).data('name');
        var banksCode = $(this).data('code');
        var banksSlug = $(this).data('slug');
        $(".modal-body #ubank-id").val( bankId );
        $(".modal-body #ubank-name").val( banksName );
        $(".modal-body #ubank-code").val( banksCode );
        $(".modal-header #ubankname").html( banksName );
        $(".modal-body #ubank-slug").val( banksSlug );
    })

    $("#ubank-name").keyup(function() {
        ubankName = $(this).val()
        ubankSlug = ubankName.replace(/\s+/g, '-').toLowerCase()
        if (ubankName == '') {
            Materialize.toast('Bank  Name Is Required', 3000, 'rounded')
        }
    })

    $("#ubank-code").keyup(function() {
        ubankCode = $(this).val()
        if (ubankCode == '') {
            Materialize.toast('Bank  Short Name Is Required', 3000, 'rounded')
        }
    })

    // Update Bank
    $(".updateBtn").click(function(event) {
        event.preventDefault();
        var ubankName = $("#ubank-name").val()
        var ubankCode = $("#ubank-code").val()
        var ubankSlug = ubankName.replace(/\s+/g, '-').toLowerCase()
        var ubankId = $("#ubank-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (ubankName == '' || ubankCode == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly enter all fields', 4000, 'rounded');
        } else {
            $(".updateBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".updateBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/banks.php",
                method: "POST",
                data: { updateBank: 1, ubankName: ubankName, ubankCode:ubankCode, ubankSlug:ubankSlug, ubankId:ubankId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".updateBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".updateBtn").removeAttr('disabled')
                    $("#load-banks").load('app/pf/banks-load.php')
                    if (data == "okay200") {
                        $("#ubank-name").val('')
                        $("#ubank-code").val('')
                        Materialize.toast('Bank '+ubankName+' successfully updated', 4000, 'rounded')
                        window.setTimeout(function() {
                            $('#updateBank').modal('close')
                        }, 4000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed, try again or contact support if error persists', 4000, 'rounded')
                    }
                }
            })
        }
    })

    //Fetch data from butoon and pass to modal
    $(".deleteRecord").click(function(event){
        event.preventDefault();
        var dbankId = $(this).data('id');
        var dbankName = $(this).data('name');
        $(".modal-body #dbank-id").val( dbankId );
        $(".modal-body #dbank-name").html( dbankName );
        $(".modal-header #dbankname").html( dbankName );
    })

    // Update Currency
    $(".deleteBtn").click(function(event) {
        event.preventDefault()
        var dbankId = $("#dbank-id").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (dbankId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".deleteBtn").html('<div class="progress"><div class="indeterminate"></div></div> Deleting');
            $(".deleteBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/banks.php",
                method: "POST",
                data: { deleteBank: 1, dbankId:dbankId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".deleteBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".deleteBtn").removeAttr('disabled')
                    $("#load-banks").load('app/pf/banks-load.php')
                    if (data == "200") {
                        Materialize.toast('New Bank successfully deleted', 4000, 'rounded')
                        window.setTimeout(function() {
                            $('#deleteBank').modal('close')
                        }, 4000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed, try again or contact support if error persists', 4000, 'rounded')
                    }
                }
            })
        }
    })

})