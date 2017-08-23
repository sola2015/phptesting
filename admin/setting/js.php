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


    function setImagePreview()
    {
        var docObj=document.getElementById("file");
        var imgObjPreview=document.getElementById("preview");
        if(docObj.files &&    docObj.files[0])
        {
            //火狐下，直接设img属性
            imgObjPreview.style.display = 'block';
            imgObjPreview.style.width = '200px';
            imgObjPreview.style.height = '200px';
            //imgObjPreview.src = docObj.files[0].getAsDataURL();
            //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式
            imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);
        }
        else
        {
            //IE下，使用滤镜
            docObj.select();
            var imgSrc = document.selection.createRange().text;
            var localImagId = document.getElementById("localImag");
            //必须设置初始大小
            localImagId.style.width = "300px";
            localImagId.style.height = "120px";
            //图片异常的捕捉，防止用户修改后缀来伪造图片
            try
            {
                localImagId.style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
                localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
            }
            catch(e)
            {
                alert("您上传的图片格式不正确，请重新选择!");
                return false;
            }
            imgObjPreview.style.display = 'none';
            document.selection.empty();
        }
        return true;
    }


</script>