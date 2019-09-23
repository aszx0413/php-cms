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

        </tbody>
    </table>
</form>