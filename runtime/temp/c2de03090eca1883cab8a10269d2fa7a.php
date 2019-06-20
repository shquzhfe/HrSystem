<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\xampp\htdocs\HRsystem\public/../application/admin\view\structure\lists.html";i:1528103627;}*/ ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>组织列表</title>
    <link rel="shortcut icon" href="favicon.ico"> <link href="/HRsystem/public/static/admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/HRsystem/public/static/admin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/HRsystem/public/static/admin/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
    <link href="/HRsystem/public/static/admin/css/animate.css" rel="stylesheet">
    <link href="/HRsystem/public/static/admin/css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <!-- Panel Other -->
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row row-lg">
                    <div class="col-sm-12">
                        <!-- Example Events -->
                        <form action="<?php echo url('Structure/delall'); ?>" method="post">
                            <div class="example-wrap">
                                <h4 class="example-title">组织管理 <a class="btn btn-outline btn-rounded btn-sm btn-info"  href="<?php echo url('lists'); ?>">刷新</a></h4>
                                <div class="example">
                                    <div class="btn-group hidden-xs" id="exampleTableEventsToolbar" role="group">
                                        <a class="btn btn-primary" href="<?php echo url('Structure/add'); ?>" style="color:#fff;"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i> 添加组织</a>
                                        <button style="margin-left: 10px;" type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> 批量删除</button>
                                    </div>
                                    <table class="table table-bordered" >
                                        <thead>
                                            <tr pid="0">
                                                <th ><input type='checkbox' id='chkAll' onclick="checkAll(this.checked)" ></th>
                                                <!--<th data-field="id" data-visible="false">ID</th>-->
                                                <th>伸缩</th>
                                                <th>组织名称</th>
                                                <th>排序</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($structure) || $structure instanceof \think\Collection || $structure instanceof \think\Paginator): $i = 0; $__LIST__ = $structure;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?>
                                            <tr id="<?php echo $value['id']; ?>" pid="<?php echo $value['pid']; ?>" >
                                                <td width="5%"><input type="checkbox" name="itm[]" value="<?php echo $value['id']; ?>"></td>

                                                <td width="5%"><a  class="showHide btn btn-xs btn-outline btn-warning" style="font-size: 14px; font-weight: bold" >+</a></td>
                                                <td >
                                                    <?php echo str_repeat(' ∷ ',$value['level']*1);  ?><a title="点击可查看组织文档并添加该组织文档" href="<?php echo url('Content/lists',['structure_id'=>$value['id']]); ?>"><?php echo $value['typename']; ?></a>
                                                    <a style="float: right;" class="btn btn-outline btn-rounded btn-sm btn-success" href="<?php echo url('add',array('id'=>$value['id'])); ?>">添加子组织</a>
                                                </td>
                                                <td width="13%">
                                                    <input class="form-control" type="number" valid="<?php echo $value['id']; ?>"  name="sort" value="<?php echo $value['sort']; ?>" onchange="change(this);">
                                                </td>
                                                <td>
                                                    <a class="btn btn-outline btn-rounded btn-primary" href="<?php echo url('edit',array('id'=>$value['id'])); ?>">编辑</a>
                                                    <a class="btn btn-outline btn-rounded btn-danger" style="margin-left: 3%" structureid="<?php echo $value['id']; ?>" onclick="dele(this);">删除</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </form>
                        <!-- End Example Events -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Panel Other -->
    </div>

    <!-- 全局js -->
   <!-- <script type="text/javascript" src="http://demo.jb51.net/jslib/jquery/jquery1.3.2.js"></script>-->
    <script src="/HRsystem/public/static/admin/js/jquery.min.js?v=2.1.4"></script>

    <script src="/HRsystem/public/static/admin/js/bootstrap.min.js?v=3.3.6"></script>
    <!-- 自定义js -->
    <script src="/HRsystem/public/static/admin/js/content.js?v=1.0.0"></script>
    <!-- Bootstrap table -->
    <script src="/HRsystem/public/static/admin/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="/HRsystem/public/static/admin/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script>
    <script src="/HRsystem/public/static/admin/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>

    <!-- Peity -->
    <script src="/HRsystem/public/static/admin/js/demo/bootstrap-table-demo.js"></script>

    <!-- layer -->
    <script src="/static/plus/layer/layer.js"></script>

    <script type="text/javascript">
        //伸缩
        $('tr[pid!=0]').hide();
        $(".showHide").click(function(){
            var id=$(this).parents('tr').attr('id');
            if($(this).text()=='+'){
                $(this).text('-');
                $("tr[pid="+id+"]").show();
            }else{
                $(this).text('+');
               /* $("tr[pid="+id+"]").hide();*/
                $.ajax({
                    type:"post",
                    dataType:"json",
                    data:{id:id},
                    url:"<?php echo url('Structure/isShowHidden'); ?>",
                    success:function(data){
                        var sonids=[];
                        var idsobj=$('tr[pid!=0]');
                        //数组遍历
                        idsobj.each(function(){
                            sonids.push($(this).attr('id'));
                        });
                        //json的遍历
                        $.each(data,function(k,v){
                            if($.inArray(v,sonids)){
                                $('tr[id='+v+']').hide();
                                $('tr[id='+v+']').find('a:first').text('+');
                            }
                        });
                    }
                });
            }
        });
        //全选
        function checkAll(val) {
            $("input[name='itm[]']").each(function() {
                this.checked = val;
            });
        }
        //显示与隐藏
        function status(obj){
            var valid=$(obj).attr("valid");
            $.ajax({
                type:"post",
                dataType:"json",
                data:{valid:valid},
                url:"<?php echo url('Structure/status'); ?>",
                success:function(data){
                    if(data==0){
                        $(obj).attr("class","btn btn-default");
                        $(obj).text("隐藏");
                    }else if(data==1){
                        $(obj).attr("class","btn btn-primary");
                        $(obj).text("显示");
                    }else{
                        layer.msg(' 非法访问！', {icon: 2});
                    }
                }
            });

        }
        //修改排序
        function change(obj){
            var valid=$(obj).attr("valid");
            var datass=$(obj).prop("value");
            $.ajax({
                type:"post",
                dataType:"json",
                data:{valid:valid,datass:datass},
                url:"<?php echo url('Structure/sort'); ?>",
                success:function(data){
                    if(data==1){
                        layer.msg(' 更新排序成功！', {
                            icon: 6,
                            time: 2000, //2s后自动关闭
                        },function(){
                            window.location.reload();
                        });
                    }else if(data==0){
                        layer.msg(' 更新排序失败，刷新再试！', {icon: 2});
                    }else{
                        layer.msg(' 非法访问！', {icon: 2});
                    }
                }
            });
        }

        //删除
        function dele(object){
            var structureid=$(object).attr("structureid");
            layer.confirm('您确定要删除该条记录吗？', {
                title: false,
                closeBtn: false,
                icon: 3,
                btn: ['确定','取消']
            }, function(){
                $.ajax({
                    type:"post",
                    dataType:"json",
                    data:{structureid:structureid},
                    url:"<?php echo url('Structure/del'); ?>",
                    success:function(data){
                        if(data){
                            layer.msg('删除记录成功', {
                                icon: 6,
                                time: 2000, //2s后自动关闭
                            },function(){
                                window.location.reload();
                            });
                        }else{
                            layer.msg('删除记录失败，刷新再试', {icon: 2});
                        }
                    }
                });
            });
        }
    </script>
</body>

</html>
