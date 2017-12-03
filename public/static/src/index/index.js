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
            default:
                fileLi.find('img').attr('src', 'static/images/unknown.png');
        }
        fileLi.find('a').attr('href', '/index/File/download?file=' + dir + files[i]).attr('target', '_blank');
        fileLi.find('.gallery-title').text(files[i]);
        fileUl.append(fileLi);
    }
}

$.get("/index/File/read", {path: ''}, function (data) {
    writeFiles(data, '');
});

$('#file-ul').on("click", ".dir-li", function () {
    var breadcrumbOl = $('#breadcrumb-ol');
    var child = breadcrumbOl.children('li:last');
    var file = $.trim($(this).text());
    var dir = child.data('value') + file + '/';
    $.get("/index/File/read", {path: dir}, function (data) {
        var li = '<li class="am-active" data-value="' + dir + '"><a href="#">' + file + '</a></li>';
        breadcrumbOl.append(li);
        writeFiles(data, dir);
    });
});

$('#breadcrumb-ol').on("click", "li", function () {
    var index = $(this).index();
    var dir = $.trim($(this).data('value'));
    $.get("/index/File/read", {path: dir}, function (data) {
        $('#breadcrumb-ol').children("li:gt(" + index + ")").remove();
        writeFiles(data, dir);
    });
});