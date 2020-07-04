<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title id="title"></title>
    <link rel="stylesheet icon" href="img/list.ico" />
    <link rel="stylesheet" href="layui/css/layui.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jQuery.js"></script>
    <style>
    .layui-layer-btn .layui-layer-btn0 {
        border-color: #119D90 !important;
        background-color: #119D90 !important;
    }
    </style>
</head>

<body>
    <div class="layui-container">
        <!-- 头部：新建，输入操作 -->
        <div class="layui-row">
            <div class="header layui-col-md-offset3 layui-col-md6">
                <fieldset class="layui-elem-field">
                    <legend>以下</legend>
                    <div style="font-size: 16px;text-align:center;" class="layui-field-box">
                        是一个清单呀
                    </div>
                </fieldset>
                <form method="POST" action="php/insert.php">
                    <div class="layui-row">
                        <div class="layui-col-xs9 layui-col-sm9">
                            <input onmouseover="this.focus()" onfocus="this.select()"
                                style="display:inline-block;border-radius: 10px!important;" id="inputText"
                                class="inputText layui-input" type="text" name="new_project" placeholder="想做什么呢？" id="">
                        </div>
                        <button type="submit" name="btn" value="新建list"
                            class="layui-col-xs2 new-btn layui-btn">新建</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 未完成列表清单：点击完成事件，删除操作 -->
        <div class="layui-row">
            <div id="unfinish" class="list-container layui-col-md-offset3 layui-col-md6">
                <text style="color:gray;font-size:18px;">
                    未完成
                </text>
                <hr>
                <form method="POST" action="php/alter_and_delete.php">
                    <?php
include_once 'php/return_unfinish.php';
?>
                </form>
            </div>
        </div>

        <!-- 已完成列表清单：点击取消完成事件，删除操作
        已完成的事件中划线，且星星变实心 -->
        <div class="layui-row">
            <div id="finished" class="list-container layui-col-md-offset3 layui-col-md6">
                <text style="color:gray;font-size:18px;">
                    已完成
                </text>
                <hr>
                <form method="POST" action="php/alter_and_delete.php">
                    <?php
include_once 'php/return_finished.php';
?>
                </form>
            </div>
        </div>
    </div>
    <div style="color:gray;text-align: center;">服务器运行时间 10：00-次晨 0：00</div>
    <!-- <br>小K同學 <i style="padding: 0;" class="layui-icon layui-icon-heart-fill"></i> Cactus -->


    <script src="layui/layui.js"></script>
    <script>
    // 进入页面时弹出层
    layui.use('layer', function() {
        var layer = layui.layer;
        layer.msg('Hi', {
            time: 2000
        });
    });
    </script>
    <script src="js/main.js"></script>
</body>

</html>