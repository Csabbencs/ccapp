<p>
<a href="index.php?p=get&entity=employee">Alkalmazottak listája</a>
<a href="index.php?p=get&entity=companycar">Céges autók listája</a>
</p>
<p>
<a href="index.php?p=create&entity=employee">Új alkalmazott felvétele</a>
<a href="index.php?p=create&entity=department">Új részleg felvétele</a>
<a href="index.php?p=create&entity=companycar">Új céges autó felvétele</a>
</p>

<h1>Részlegek listája</h1>

<table>
<tr>
	<!--<th>Részleg azonosító</th>-->
	<th><a href="index.php?p=get&entity=department&sort=name">Részleg neve</a></th>
	<th><a href="index.php?p=get&entity=department&sort=noofmembers">Alkalmazottak száma</a></th>
	<th>Módosítás</th>
	<th>Törlés</th>
</tr>
{foreach $data as $text}
<tr>
<!--<td> {$text['ID']} </td>-->
<td> {$text['Name']} </td>
<td> {$text['NoOfMembers']} </td>
<td> <a href="index.php?p=edit&entity=department&id={$text['ID']}">módosítás</a> </td>
<td> <a href="index.php?p=delete&entity=department&id={$text['ID']}">törlés</a> </td>
</tr>
{/foreach}
</table>



