    var $modal = $('#modal-crop');
    var image = document.getElementById('image');
    var cropper;

    $("body").on("change", ".image", function(e) {

        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;


        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 0,
            viewMode: 0,
            preview: '.preview',
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });