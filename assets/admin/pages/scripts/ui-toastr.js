var UIToastr = function () {

    return {
        show: function (message, status) {
            toastr.options = {
                onclick: null,
                closeButton: true,
                timeOut: 2000,
                showDuration: 500,
                hideDuration: 500,
                extendedTimeOut: 500,
                showEasing: 'swing',
                hideEasing: 'linear',
                showMethod: 'fadeIn',
                hideMethod: 'fadeOut',
                positionClass: 'toast-top-right',

            };
            if(status == ""){
                status = "error";
            }
            if(message == ""){
                message = "No Message";
            }

            toastr[status](message);
        }
    };
}();