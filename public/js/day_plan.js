
function schedule_install(uid, username, phone, network, address, wtthtype, fn, ln, subnetwork, ticket) {


    scheduleSrc = 'installs';
    actRowID = uid;
    actColID = 8;

    actUsername = username;
    actUID = uid;
    actPhone = phone;
    actInstallType = wtthtype;
    actAddress = address;
    actNetwork = network;

    // Get the details of the customer's address
    /*HoldOn.open({
        theme: 'sk-bounce',
        message: "<h4>Loading customer details...</h4>"
    });*/

    $('#modal_heading').html('Schedule Task');
    $('#modal_details').html('Customer ' + username + ' with phone number <a href="tel:' + phone + '">' + phone + '</a>');
    $('#START').val('07:00');
    $('#END').val('07:05');
    $('#UID').val(uid);
    $('#MTUID').val(0);
    $('#MID').val(0);
    $('#CSID').val(0);
    $('#TASK_NAME').val(username);
    $('#NETWORK').val(network);
    $('#SUBNETWORK').val(subnetwork);
    $('#CONTACT_NAME').val(fn + ' ' + ln);
    $('#CONTACT_NUMBER').val(phone);
    $('#ADDRESS').val(actAddress);
    $('#COMMENTS').val('Customer ' + username + ' with phone number ' + phone);
    $('#ADDRESS').val(ticket);
    $('.schedule_modal').modal('show');

    HoldOn.close();


}

function edit_merchant_account(merchantName, phoneNumber,email, address, accountStatus,id) {


    $('#modal_heading').html('Edit Merchant');
    $('#modal_detail').html('Merchant Account ' + merchantName + ' ');
    $('#merchant_name').val(merchantName);
    $('#merchant_email').val(email);
    $('#merchant_phone').val(phoneNumber);
    $('#merchant_address').val(address);
    $('#merchant_status').val( accountStatus);
    $('#merchant_id').val(id);

    $('.edit_merchant_modal').modal('show');

    HoldOn.close();


}


$(window).resize(function () {
    stack_center.firstpos2 = ($(window).width() / 2) - (Number(PNotify.prototype.options.width.replace(/\D/g, '')) / 2);
});