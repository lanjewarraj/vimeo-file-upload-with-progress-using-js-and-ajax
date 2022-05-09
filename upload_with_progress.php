<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

    <form id="upload_form" enctype="multipart/form-data" method="post">
        <small>choose your video</small>
        <input type="file" name="file1" id="file1" accept="video/*" />
        <button type="button" onclick="uploadFile()" id="up-vid-btn">Upload Video</button>
    </form>


    <script>
        function _(el) {
            return document.getElementById(el);
        }

        function uploadFile() {
            var file = _("file1").files[0];

            //check file select
            if (typeof file === "undefined") {
                _("status").innerHTML = "ERROR: Please browse for a file before clicking the upload button";
                _("progressBar").value = 0;
                return;
            }
            //check file type
            if (file.type !== "video/mp4") {
                var typewarn = "ERROR: You have to select a MP4-File";
                _("status").innerHTML = typewarn;
                //_("progressBar").value = 0;
                return;
            }

            var formdata = new FormData();
            formdata.append("file1", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "video_process.php");
            ajax.send(formdata);

        }

        function progressHandler(event) {
            _("status").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            //_("progressBar").value = Math.round(percent);
            _("status").innerHTML = "<div class='alert alert-success'>Video Uploading... please wait <img src='loading.gif' width='40px' height='40px'></div>";
        }

        function completeHandler(event) {
            _("status").innerHTML = event.target.responseText;
            //_("progressBar").value = 0;


            var customtxt = document.createElement("small");

            customtxt.innerHTML = "Video Uploading Done. (Note: your video is still processing..please try to access your video after few minutes)";

            swal({
                content: customtxt,
                title: "video added",
                text: "video added success.",
                type: "success"
            }).then(function() {
                window.location = "index.php";
            });
        }

        function errorHandler(event) {
            _("status").innerHTML = "Upload Failed";

            swal({
                title: "Video Upload Failed",
                text: "Error occure during video upload.. please try after sometime",
                type: "error"
            }).then(function() {
                window.location = "index.php";
            });
        }

        function abortHandler(event) {
            _("status").innerHTML = "Upload Aborted";
            swal({
                title: "Video Upload Aborted",
                text: "Error occure during video upload.. please try after sometime",
                type: "error"
            }).then(function() {
                window.location = "index.php";
            });
        }
    </script>
</body>

</html>