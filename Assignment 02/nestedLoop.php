<!doctype html>
<html lang="en">
    <ul>
    <? for($x=1; $x<=4; $x++) { ?>
        <li><?=$x?>
            <ul>
            <? for($y=1; $y<=5; $y++) { ?>
                <li><?=$y?>
                </li>
            <? } ?>
            </ul>
        </li>
   <? } ?>
    </ul>