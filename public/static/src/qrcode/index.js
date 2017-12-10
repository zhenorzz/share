$(function () {
    $('#createQrcode').click(function () {
        var formData = new FormData($('#qrcodeForm')[0]);
        $.ajax({
            url: "/index/Qrcode/create",
            type: 'POST',
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (data) {
                console.log(data);
                $('#qrcode').attr('src', data);
            }
        });
    });
    $('#qrcodeLogo').change(function() {
        var imgFile = this.files[0];
        var fr = new FileReader();
        fr.onload = function() {
            $('#logoPreview').attr('src', fr.result);
        };
        fr.readAsDataURL(imgFile);
    });
});
