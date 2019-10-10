<form class="" action="" method="post" data-toggle="validator">
    <table class="table table-bordered table-striped form-table">
        <input type="hidden" name="id" value="<<?=$mark?>=$row['id']?>">

        <tbody>
            <?php foreach ($cols as $col):?><tr>
                <th><?=$col['colCn']?></th>
                <td>
                    <input type="text" class="form-control" name="<?=$col['col']?>" value="<<?=$mark?>=$row['<?=$col['col']?>']?>" />
                </td>
            </tr>
            <?php endforeach;?>

            <tr>
                <td></td>
                <td colspan="3">
                    <button type="submit" class="btn btn-primary">确认提交</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>

<script type="text/javascript">
    $(function() {})
</script>