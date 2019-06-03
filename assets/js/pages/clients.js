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
            Materialize.toast('Client Name Is Required', 3000, 'rounded')
        }
    })

    $("#bankCode").keyup(function() {
        bankCode = $(this).val()
        if (bankCode == '') {
            Materialize.toast('Client Short Name Is Required', 1000, 'rounded')
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
                url: "app/pf/clients.php",
                method: "POST",
                data: { addBank: 1, bankName: bankName, bankCode:bankCode, bankSlug:bankSlug, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".addBtn").html('<i class="material-icons left">save</i> Save ')
                    $(".addBtn").removeAttr('disabled')
                    if (data == "ok200") {
                        $(".bankName").val('')
                        $(".bankCode").val('')
                        Materialize.toast('New client '+bankName+' successfully created', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='clients'
                        }, 3000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
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
            Materialize.toast('Client Name Is Required', 3000, 'rounded')
        }
    })

    $("#ubank-code").keyup(function() {
        ubankCode = $(this).val()
        if (ubankCode == '') {
            Materialize.toast('Client Short Name Is Required', 1000, 'rounded')
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
                url: "app/pf/clients.php",
                method: "POST",
                data: { updateBank: 1, ubankName: ubankName, ubankCode:ubankCode, ubankSlug:ubankSlug, ubankId:ubankId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".updateBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".updateBtn").removeAttr('disabled')
                    if (data == "okay200") {
                        $("#ubank-name").val('')
                        $("#ubank-code").val('')
                        Materialize.toast('Client '+ubankName+' successfully updated', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='clients'
                        }, 3000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
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

    // Delete bank
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
                url: "app/pf/clients.php",
                method: "POST",
                data: { deleteBank: 1, dbankId:dbankId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".deleteBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".deleteBtn").removeAttr('disabled')
                    if (data == "200") {
                        Materialize.toast('Client successfully deleted', 3000, 'rounded')
                        window.setTimeout(function() {
                            window.location.href='clients'
                        }, 3000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    // Add Bank Representative
    $(".addRepBtn").click(function(event) {
        event.preventDefault();
        var bankId = $("#bankId").val()
        var bankRep = $("#bankRep").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (bankId == '' || bankRep == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly select a user', 4000, 'rounded');
        } else {
            $(".addRepBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".addRepBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/clients.php",
                method: "POST",
                data: { addBankRep: 1, bankId: bankId, bankRep: bankRep, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".addRepBtn").html('<i class="material-icons left">save</i> Save ')
                    $(".addRepBtn").removeAttr('disabled')
                    if (data == "repAdded") {
                        Materialize.toast('New Client Representative successfully created', 3000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 3000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    //Fetch data from button and pass to modal
    $(".removeBankRep").click(function(event){
        event.preventDefault();
        var rBankId = $(this).data('id');
        var rUsername = $(this).data('username');
        var bankRepName = $(this).data('bankrepname')
        $(".modal-body #rBankId").val( rBankId );
        $(".modal-body #rUsername").val( rUsername );
        $(".modal-body #bankRepName").html( bankRepName );
    })

    // Remove Rep
    $(".removeBtn").click(function(event) {
        event.preventDefault()
        var rBankId = $("#rBankId").val()
        var rUsername = $("#rUsername").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (rBankId == '' || rUsername == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".removeBtn").html('<div class="progress"><div class="indeterminate"></div></div> Deleting');
            $(".removeBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/clients.php",
                method: "POST",
                data: { removeBankRepresentative: 1, rBankId:rBankId, rUsername:rUsername, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".removeBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".removeBtn").removeAttr('disabled')
                    if (data == "repRemoved") {
                        Materialize.toast('Representative successfully removed', 3000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 3000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    // Add Bank Branch
    var bankBranch = ''
    var bankBranchSlug = ''
    var bankBranchLocation = ''
    var bankBranchRep = ''
    var bankBranchLocationCode = ''

    $("#bankBranch").keyup(function() {
        bankBranch = $(this).val()
        bankBranchSlug = bankBranch.replace(/\s+/g, '-').toLowerCase()
        if (bankBranch == '') {
            Materialize.toast('Branch Name Is Required', 2000, 'rounded')
        }
    })
    $("#bankBranchLocation").keyup(function() {
        bankBranchLocation = $(this).val()
        if (bankBranchLocation == '') {
            Materialize.toast('Branch Location Is Required', 2000, 'rounded')
        }
    })
    $("#bankBranchLocationCode").keyup(function() {
        bankBranchLocationCode = $(this).val()
        if (bankBranchLocationCode == '') {
            Materialize.toast('Branch Code Is Required', 2000, 'rounded')
        }
    })
    $("#bankBranchRep").change(function() {
        // console.log(bankBranchRep)
        // alert(0)
        bankBranchRep = $(this).val()
        if (bankBranchRep == '') {
            Materialize.toast('Branch Representative Is Required', 2000, 'rounded')
        } else {
            console.log(bankBranchRep)
        }
    })
    $("#bankBranchCmu").change(function() {
        bankBranchCmu = $(this).val()
        if (bankBranchCmu == '') {
            Materialize.toast('Branch CMU Is Required', 2000, 'rounded')
        } else {
            console.log(bankBranchCmu)
        }
    })

    $(".addBranchBtn").click(function(event) {
        event.preventDefault();
        var bankBranch = $("#bankBranch").val()
        var bankBranchLocation = $("#bankBranchLocation").val()
        var bankBranchLocationCode = $("#bankBranchLocationCode").val()
        var bankBranchCmu = $("#bankBranchCmu").val()
        var bankBranchRep = $("#bankBranchRep").val()
        var bankId = $("#bankId").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (bankBranch == '' || bankBranchLocation == '' || bankBranchLocationCode == '' || bankBranchCmu == '' || bankBranchRep == '' || bankBranchSlug == '' || bankId == '' || username == '' || usertoken == '') {
            Materialize.toast('Kindly Fill All Fields', 2000, 'rounded');
        } else {
            $(".addBranchBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".addBranchBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/clients.php",
                method: "POST",
                data: { addBankBranch: 1, bankId: bankId, bankBranch: bankBranch, bankBranchLocation: bankBranchLocation, bankBranchLocationCode: bankBranchLocationCode, bankBranchCmu: bankBranchCmu, bankBranchRep: bankBranchRep, bankBranchSlug: bankBranchSlug, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".addBranchBtn").html('<i class="material-icons left">save</i> Save ')
                    $(".addBranchBtn").removeAttr('disabled')
                    if (data == "branchAdded") {
                        Materialize.toast('New client branch ('+bankBranch+') successfully created', 3000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 3000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    // Update Bank Branch
    var ubankBranchSlug = $("#ubankBranchSlug").val()

    //Fetch data from button and pass to modal
    $(".editBranch").click(function(event){
        event.preventDefault();
        var ubranchId = $(this).data('ids');
        var ubankBranch = $(this).data('name');
        var ubankBranchRep = $(this).data('rep')
        var ubankBranchLocationCode = $(this).data('locationcode')
        var ubankBranchLocation = $(this).data('location')
        var ubankBranchSlug = $(this).data('slug')
        $(".modal-body #ubranchId").val( ubranchId );
        $(".modal-body #ubankBranch").val( ubankBranch );
        $(".modal-body #ubankBranchLocation").val( ubankBranchLocation );
        $(".modal-body #ubankBranchRep").val( ubankBranchRep );
        $(".modal-body #ubankBranchLocationCode").val( ubankBranchLocationCode );
        $(".modal-body #ubankBranchSlug").val( ubankBranchSlug );
        $(".modal-header #reBranchName").html( ubankBranch );
    })

    $("#ubankBranch").keyup(function() {
        ubankBranch = $(this).val()
        ubankBranchSlug = ubankBranch.replace(/\s+/g, '-').toLowerCase()
        if (ubankBranch == '') {
            Materialize.toast('Branch Name Is Required', 2000, 'rounded')
        }
    })
    $("#ubankBranchLocation").keyup(function() {
        ubankBranchLocation = $(this).val()
        if (ubankBranchLocation == '') {
            Materialize.toast('Branch Location Is Required', 2000, 'rounded')
        }
    })
    $("#ubankBranchLocationCode").keyup(function() {
        ubankBranchLocationCode = $(this).val()
        if (ubankBranchLocationCode == '') {
            Materialize.toast('Branch Code Is Required', 2000, 'rounded')
        }
    })
    $("#ubankBranchRep").change(function() {
        ubankBranchRep = $(this).val()
        if (ubankBranchRep == '') {
            Materialize.toast('Branch Representative Is Required', 2000, 'rounded')
        }
    })

    $(".editBranchBtn").click(function(event) {
        event.preventDefault();
        var ubankBranch = $("#ubankBranch").val()
        var ubankBranchLocation = $("#ubankBranchLocation").val()
        var ubankBranchLocationCode = $("#ubankBranchLocationCode").val()
        var ubankBranchRep = $("#ubankBranchRep").val()
        var ubranchId = $("#ubranchId").val()
        var ubankId = $("#ubankId").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        console.log(ubranchId)
        if (ubankBranch == '' || ubankBranchLocation == '' || ubankBranchLocationCode == '' || ubankBranchRep == '' || ubankBranchSlug == '' ||  username == '' || usertoken == '') {
            Materialize.toast('Kindly Fill All Fields', 2000, 'rounded');
        } else {
            $(".editBranchBtn").html('<div class="progress"><div class="indeterminate"></div></div> Saving');
            $(".editBranchBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/clients.php",
                method: "POST",
                data: { updateBankBranch: 1, ubranchId: ubranchId, ubankId: ubankId, ubankBranch: ubankBranch, ubankBranchLocation: ubankBranchLocation, ubankBranchLocationCode: ubankBranchLocationCode, ubankBranchRep: ubankBranchRep, ubankBranchSlug: ubankBranchSlug, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".editBranchBtn").html('<i class="material-icons left">save</i> Save ')
                    $(".editBranchBtn").removeAttr('disabled')
                    if (data == "branchUpdated") {
                        Materialize.toast('Branch successfully updated', 3000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 3000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

    // Delete Branch
    //Fetch data from button and pass to modal
    $(".removeBranch").click(function(event){
        event.preventDefault();
        var dbranchId = $(this).data('id');
        var dbankBranch = $(this).data('name');
        $(".modal-body #dbranchId").val( dbranchId );
        $(".modal-body #deBranchName").html( dbankBranch );
    })

    // Remove Rep
    $(".removeBranchBtn").click(function(event) {
        event.preventDefault()
        var dbranchId = $("#dbranchId").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (dbranchId == '' || username == '' || usertoken == '') {
            Materialize.toast('Invalid Request', 5000, 'rounded');
        } else {
            $(".removeBranchBtn").html('<div class="progress"><div class="indeterminate"></div></div> Deleting');
            $(".removeBranchBtn").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/clients.php",
                method: "POST",
                data: { removeBranch: 1, dbranchId:dbranchId, username: username, usertoken: usertoken },
                success: function(data) {
                    $(".removeBranchBtn").html('<i class="material-icons left">save</i> Save  ')
                    $(".removeBranchBtn").removeAttr('disabled')
                    if (data == "branchRemoved") {
                        Materialize.toast('Branch successfully removed', 3000, 'rounded')
                        window.setTimeout(function() {
                            location.reload()
                        }, 3000)
                    } else {
                        console.log(data)
                        Materialize.toast('Transaction failed: ' + data, 3000, 'rounded')
                    }
                }
            })
        }
    })

})