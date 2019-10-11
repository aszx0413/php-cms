<div class="row panel panel-default list ">

    <!-- 搜索区域 -->
    <div class="col-md-12 list-cond">
        <form class="form-inline" action="" method="get">
            <?php foreach ($cols as $col):?><?php if(strpos($col['list'],'S')!==false): ?><div class="form-group">
                <label for=""><?=$col['colCn']?></label>
                <input type="text" class="form-control" name="<?=$col['col']?>" value="<<?=$mark?>=$_GET['<?=$col['col']?>']?>" placeholder="" />
            </div>
            <?php endif; ?><?php endforeach;?>

            <div class="form-group">
                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> 搜索</button>
                <a href="/" class="btn btn-second">重置</a>
            </div>
        </form>
    </div>
    <!-- /搜索区域 -->

    <div class="col-md-12">
        <form action="" method="post">
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="info">
                        <th>#</th>
                        <?php foreach ($cols as $col):?><th><?=$col['colCn']?></th>
                        <?php endforeach;?><th class="list-add-time">添加时间</th>
                        <th class="list-status">状态</th>
                        <th class="list-op">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <<?=$mark?>php foreach($list as $v): ?>
                    <tr>
                        <td>
                            <<?=$mark?>=$v['id']?>
                        </td>
                        <?php foreach ($cols as $col):?><td>
                            <<?=$mark?>=$v['<?=$col['col']?>']?>
                        </td>
                        <?php endforeach;?>

                        <td>
                            <<?=$mark?>=$v['add_time']?>
                        </td>
                        <td>
                            <<?=$mark?>=htmlStatus($v['status'])?>
                        </td>
                        <td class="text-right">
                            <a class="btn btn-primary btn-xs" href="//edit?id=<<?=$mark?>=$v['id']?>"><span class="glyphicon glyphicon-edit"></span></a>
                            <a class="btn btn-danger btn-xs" href="//del?id=<<?=$mark?>=$v['id']?>" onclick="return confirm('确认删除吗？');"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                    </tr>
                    <<?=$mark?>php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>

</div>

<script type="text/javascript">
    $(function() {})
</script>