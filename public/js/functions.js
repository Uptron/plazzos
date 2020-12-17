function getSubNetworks(network) {

    var baseURL = "http://" + window.location.host + "/";
    var url = baseURL + "load-subnetworks";
    $.ajax({
        cache: false,
        type: "post",
        url: url,
        data: {'networkId': network},
        beforeSend: function () {

            $("#loader").html("<img src='" + baseURL + "img/ajax-loading.gif' />");
        },
        success: function (data) {
            $("#subnetwork").html(data);
            $("#loader").html("");
        }
    });
}