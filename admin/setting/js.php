<?php
//js file


?>


<script src="setting/js/jquery-3.2.1.min.js"></script>

<script src="setting/js/jquery-ui.min.js"></script>

<script src="setting/js/bootstrap.min.js"></script>

<script src="setting/js/tinymce/tinymce.min.js"></script>

<script src="setting/js/dropzone.js"></script>


<script>


    tinymce.init({
        selector: '.editor',
//        theme: 'modern',
//        width: 600,
//        height: 300,
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'save table contextmenu directionality emoticons template paste textcolor jbimages'
        ],
//        content_css: 'css/content.css',
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages | print preview media fullpage | forecolor backcolor emoticons',
        relative_urls: false

    })


    function del() {
        var msg = "Are you sure you want to delete the record?";
        if (confirm(msg) == true) {
            return true;
        } else {
            return false;
        }
    }

    function update() {
        var msg = "Are you sure you want to update your password?";
        if (confirm(msg) == true) {
            if (npassword.value != npassword2.value) {
                alert("Passwords do not match!")
                npassword.value = "";
                npassword2.value = "";
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    function check_pass() {
        var msg = "Are you sure you want to update your password?"
        if (npassword.value != npassword2.value) {
            alert("Passwords do not match!")
            npassword.value = "";
            npassword2.value = "";
            return false;
        } else if (confirm(msg) == true) {
            return true;
        } else {
            return false;
        }
    }


    function setImagePreview() {
        var docObj = document.getElementById("file");
        var imgObjPreview = document.getElementById("preview");
        if (docObj.files && docObj.files[0]) {
            //firefox
            imgObjPreview.style.display = 'block';
            imgObjPreview.style.width = '100%';
            imgObjPreview.style.height = '100%';
            //imgObjPreview.src = docObj.files[0].getAsDataURL();
            //firefox 7
            imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);
        }
        else {
            //IE
            docObj.select();
            var imgSrc = document.selection.createRange().text;
            var localImagId = document.getElementById("localImag");
            //initial size
            localImagId.style.width = "300px";
            localImagId.style.height = "120px";
            //
            try {
                localImagId.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
                localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
            }
            catch (e) {
                alert("It is not a valid picture format! Please try again.");
                return false;
            }
            imgObjPreview.style.display = 'none';
            document.selection.empty();
        }
        return true;
    }

    $(function () {
        $('#myTab a:first').tab('show');//initial tab

        $('#myTab a').click(function (e) {
            e.preventDefault();//prevent a redirect
            $(this).tab('show');//show the relevant content
        })
    })


</script>