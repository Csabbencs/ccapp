<html>
<head>
<title>get</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<p>
<a class="task" href="adatnyilvantarto.txt">A feladat szövege</a>
<span class="task">&nbsp;&nbsp;&nbsp;A megoldást elkészítette: Balogh Csaba</span>
</p>
<hr />

{if $result[0] eq 'error'}
<div class="error message">
{foreach $result[1] as $Error}
{$Error} <br />
{/foreach}
</div>
{elseif $result[0] eq 'ok'}
<div class="ok message">
Az adatok mentése sikerült.
</div>
{/if}



