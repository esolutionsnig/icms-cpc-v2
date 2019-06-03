jQuery(document).ready(function($) {

    // Search Clients
    $(".searchClients").click(function(event) {
        event.preventDefault()
        var clientSearchName = $("#clientSearchName").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (clientSearchName == '' || username == '' || usertoken == '') {
            Materialize.toast('Search Variable Is required', 2000, 'rounded');
        } else {
            $(".searchClients").html('<div class="progress"><div class="indeterminate"></div></div> Searching');
            $(".searchClients").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/queries-reports-views.php",
                method: "POST",
                data: { searchClients: 1, clientSearchName: clientSearchName, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".searchClients").html('<i class="material-icons left">search</i> Search')
                    $(".searchClients").removeAttr('disabled')
                    if (data == "error404") {
                        Materialize.toast('Search Failed: System could not complete your search', 1000, 'rounded')
                    } else {
                        $("#searchResult").html(data)
                        window.setTimeout(function() {
                            $("#searchClients").modal('close')
                        }, 1000)
                    }
                }
            })
        }
    })

    // Search Clients
    $(".searchClientBranches").click(function(event) {
        event.preventDefault()
        var clientBranchSearchName = $("#clientBranchSearchName").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (clientBranchSearchName == '' || username == '' || usertoken == '') {
            Materialize.toast('Search Variable Is required', 2000, 'rounded');
        } else {
            $(".searchClientBranches").html('<div class="progress"><div class="indeterminate"></div></div> Searching');
            $(".searchClientBranches").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/queries-reports-views.php",
                method: "POST",
                data: { searchClientBranches: 1, clientBranchSearchName: clientBranchSearchName, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".searchClientBranches").html('<i class="material-icons left">search</i> Search')
                    $(".searchClientBranches").removeAttr('disabled')
                    if (data == "error404") {
                        Materialize.toast('Search Failed: System could not complete your search', 1000, 'rounded')
                    } else {
                        $("#searchResult").html(data)
                        window.setTimeout(function() {
                            $("#searchClientBranches").modal('close')
                        }, 1000)
                    }
                }
            })
        }
    })

    // Search Evacuation Requests
    $(".searchClientEvacReqs").click(function(event) {
        event.preventDefault()
        var searchER = $("#searchER").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (searchER == '' || username == '' || usertoken == '') {
            Materialize.toast('Search Variable Is required', 2000, 'rounded');
        } else {
            $(".searchClientEvacReqs").html('<div class="progress"><div class="indeterminate"></div></div> Searching');
            $(".searchClientEvacReqs").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/queries-reports-views.php",
                method: "POST",
                data: { searchClientEvacReqs: 1, searchER: searchER, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".searchClientEvacReqs").html('<i class="material-icons left">search</i> Search')
                    $(".searchClientEvacReqs").removeAttr('disabled')
                    if (data == "error404") {
                        Materialize.toast('Search Failed: System could not complete your search', 1000, 'rounded')
                    } else {
                        $("#searchResult").html(data)
                        window.setTimeout(function() {
                            $("#searchClientEvacReqs").modal('close')
                        }, 1000)
                    }
                }
            })
        }
    })

    // Search Users
    $(".searchUsers").click(function(event) {
        event.preventDefault()
        var searchPeople = $("#searchPeople").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (searchPeople == '' || username == '' || usertoken == '') {
            Materialize.toast('Search Variable Is required', 2000, 'rounded');
        } else {
            $(".searchUsers").html('<div class="progress"><div class="indeterminate"></div></div> Searching');
            $(".searchUsers").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/queries-reports-views.php",
                method: "POST",
                data: { searchUsers: 1, searchPeople: searchPeople, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".searchUsers").html('<i class="material-icons left">search</i> Search')
                    $(".searchUsers").removeAttr('disabled')
                    if (data == "error404") {
                        Materialize.toast('Search Failed: System could not complete your search', 1000, 'rounded')
                    } else {
                        $("#searchResult").html(data)
                        window.setTimeout(function() {
                            $("#searchUsers").modal('close')
                        }, 1000)
                    }
                }
            })
        }
    })

    // Search Bundle Confirmations
    $(".searchBC").click(function(event) {
        event.preventDefault()
        var searchBCS = $("#searchBCS").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (searchBCS == '' || username == '' || usertoken == '') {
            Materialize.toast('Search Variable Is required', 2000, 'rounded');
        } else {
            $(".searchBC").html('<div class="progress"><div class="indeterminate"></div></div> Searching');
            $(".searchBC").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/queries-reports-views.php",
                method: "POST",
                data: { searchBC: 1, searchBCS: searchBCS, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".searchBC").html('<i class="material-icons left">search</i> Search')
                    $(".searchBC").removeAttr('disabled')
                    if (data == "error404") {
                        Materialize.toast('Search Failed: System could not complete your search', 1000, 'rounded')
                    } else {
                        $("#searchResult").html(data)
                        window.setTimeout(function() {
                            $("#searchBC").modal('close')
                        }, 1000)
                    }
                }
            })
        }
    })

    // Search Cash Allocations
    $(".searchCA").click(function(event) {
        event.preventDefault()
        var searchCAS = $("#searchCAS").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (searchCAS == '' || username == '' || usertoken == '') {
            Materialize.toast('Search Variable Is required', 2000, 'rounded');
        } else {
            $(".searchCA").html('<div class="progress"><div class="indeterminate"></div></div> Searching');
            $(".searchCA").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/queries-reports-views.php",
                method: "POST",
                data: { searchCA: 1, searchCAS: searchCAS, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".searchCA").html('<i class="material-icons left">search</i> Search')
                    $(".searchCA").removeAttr('disabled')
                    if (data == "error404") {
                        Materialize.toast('Search Failed: System could not complete your search', 1000, 'rounded')
                    } else {
                        $("#searchResult").html(data)
                        window.setTimeout(function() {
                            $("#searchCA").modal('close')
                        }, 1000)
                    }
                }
            })
        }
    })

    // Search Sealed Containers
    $(".searchSCS").click(function(event) {
        event.preventDefault()
        var searchSCSS = $("#searchSCSS").val()
        var username = $("#username").val()
        var usertoken = $("#usertoken").val()
        if (searchSCSS == '' || username == '' || usertoken == '') {
            Materialize.toast('Search Variable Is required', 2000, 'rounded');
        } else {
            $(".searchSCS").html('<div class="progress"><div class="indeterminate"></div></div> Searching');
            $(".searchSCS").attr('disabled', 'disabled');
            $.ajax({
                url: "app/pf/queries-reports-views.php",
                method: "POST",
                data: { searchSCS: 1, searchSCSS: searchSCSS, username: username, usertoken: usertoken},
                success: function(data) {
                    $(".searchSCS").html('<i class="material-icons left">search</i> Search')
                    $(".searchSCS").removeAttr('disabled')
                    if (data == "error404") {
                        Materialize.toast('Search Failed: System could not complete your search', 1000, 'rounded')
                    } else {
                        $("#searchResult").html(data)
                        window.setTimeout(function() {
                            $("#searchSCS").modal('close')
                        }, 1000)
                    }
                }
            })
        }
    })

})