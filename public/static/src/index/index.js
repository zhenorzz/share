function writeFiles(data, dir) {
    var dirs = data.dir;
    var i;
    var fileUl = $("#file-ul");
    var fileLi;
    fileUl.children().remove();
    for (i in dirs) {
        fileLi = $($("#file-li").clone().html());
        fileLi.addClass('dir-li');
        fileLi.find('img').attr('src', 'static/images/folder.png');
        fileLi.find('.gallery-title').text(dirs[i]);
        fileUl.append(fileLi);
    }
    var files = data.file;
    var suffix;
    for (i in files) {
        fileLi = $($("#file-li").clone().html());
        suffix = files[i].substr(files[i].lastIndexOf("."));
        switch (suffix) {
            case '.txt':
                fileLi.find('img').attr('src', 'static/images/txt.png');
                break;
            case '.html':
                fileLi.find('img').attr('src', 'static/images/html.png');
                break;
            case '.md':
                fileLi.find('img').attr('src', 'static/images/markdown.png');
                break;
            default:
                fileLi.find('img').attr('src', 'static/images/unknown.png');
        }
        // fileLi.find('a').attr('href', '/index/File/preview?file=' + dir + files[i]).attr('target', '_blank');
        fileLi.addClass('file-li');
        fileLi.find('.gallery-title').text(files[i]);
        fileUl.append(fileLi);
        $('#catalog').children().removeClass('am-disabled');
        $('#catalog').children(":last").addClass('am-disabled');
    }
}

$(function() {
    $.get("/index/File/read", {path: ''}, function (data) {
        writeFiles(data, '');
    });

    $('#file-ul').on("click", ".dir-li", function () {
        var catalog = $('#catalog');
        var child = catalog.children('button:last');
        var file = $.trim($(this).text());
        var dir = child.data('value') + file + '/';
        $.get("/index/File/read", {path: dir}, function (data) {
            var button = '<button type="button" class="am-btn am-btn-default" data-value="' + dir + '">' + file + '</button>';
            catalog.append(button);
            writeFiles(data, dir);
        });
    });

    $('#file-ul').on("click", ".file-li", function () {
        $('#fileOperation').removeClass('am-hide');
        $('.gallery-title').css('color','#666');
        $(this).find('.gallery-title').css('color','#0e90d2');
    });

    $('#catalog').on("click", "button", function () {
        var index = $(this).index();
        var dir = $.trim($(this).data('value'));
        $.get("/index/File/read", {path: dir}, function (data) {
            $('#catalog').children("button:gt(" + index + ")").remove();
            writeFiles(data, dir);
        });
    });

    $('#fileUpload').change(function () {
        var formData = new FormData($('#uploadForm')[0]);
        var dir = $('#catalog').children('button:last').data('value');
        var url = "/index/File/upload?path=" + dir;
        $.ajax({
            url: url,
            type: 'POST',
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (data) {
                $.get("/index/File/read", {path: dir}, function (data) {
                    writeFiles(data, '');
                });
            }
        });
    });

    /**
     * 以target为起点向上查找父（祖）元素，若父（祖）元素中包含#fileOperation,.file-li中一个就不执行if中语句，即长度不为0
     *.closest()沿 DOM 树向上遍历(以数组形式入参)，直到找到已应用选择器的一个匹配为止，返回包含零个或一个元素的 jQuery 对象。
     **/
    $(document).bind("click",function(e){
        var target  = $(e.target);    //e.target获取触发事件的元素
        if(target.closest("#fileOperation,.file-li").length === 0){
            //进入if则表明点击的不是#phone,#first元素中的一个
            $('.gallery-title').css('color','#666');
            $('#fileOperation').addClass('am-hide');
        }
        e.stopPropagation();
    })
});