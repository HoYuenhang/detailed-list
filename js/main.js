//title问候语
var d = new Date();
var time = d.getHours();
if (time < 24) {
    document.getElementById("title").innerHTML = "清单 | Good evening";
}
if (time < 18) {
    document.getElementById("title").innerHTML = "清单 | Good afternoon";
}
if (time < 12) {
    document.getElementById("title").innerHTML = "清单 | Good morning";
}
if (time < 5) {
    document.getElementById("title").innerHTML = "清单 | Stay up late again";
}
//title问候语结束

// 新建
$('.new-btn').click(function(e) {

})

// 君と一緒にやりたい事

// 检测输入框是否为空
$('.new-btn').click(function(e) {
    var o = document.getElementById("inputText");
    var v = o.value;
    v = v.replace(/[ ]/g, "");
    if (v == '') {
        layer.alert('输入框不能为空喔！', {
            title: '一个警告',
            resize: false,
            fix: true,
            closeBtn: 0,
            anim: 1
        });
        return false;
    }
})