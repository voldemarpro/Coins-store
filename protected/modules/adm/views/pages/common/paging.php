<?php
$page = $pagination->currentPage + 1;
$visible = ($pagination->pageCount >= 20) ? 20 : $pagination->pageCount;
$pg_min = floor($page/$visible)*$visible + 1;
$pg_min -= (($pagination->pageCount - $pg_min) < $visible)*($visible - ($pagination->pageCount - $pg_min) - 1);
$pg_max = $pg_min + $visible - 1;
$j_min = ($pg_min == 1) ? 1 : ($pg_min - 1);
$path = $this->module->name.'/'.$this->id.'/'.$this->action->id.'/'.$pagination->pageVar.'/';

if ($j_min < $pg_min) echo '
	<li><a href="/', $path, $j_min, '/">«</a></li>';	

for ($j = $pg_min; $j <= $pg_max; $j++) 
	echo ($j != $page)
		?	'
		<li><a href="/'.$path.$j.'/">'.$j.'</a></li>'
		:	'
		<li class="active"><span>'.$j.'</span></li>';

if ($pagination->pageCount > $pg_max) echo '
	<li><a href="/', $path, $j, '/">»</a></li>';
?> 