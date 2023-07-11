<!DOCTYPE html>
<html>
    <table border="1">
        <? for($row=1; $row<=15; $row++) { ?>
            <tr>
                <? for($col=1; $col<=5; $col++) { ?>
                    <td> <?echo "Row $row Cell $col"; ?></td> 
               <? } ?>
            </tr>
       <? } ?>

    </table>
</html>