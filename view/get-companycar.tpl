<p>
<a href="index.php?p=get&entity=employee">Alkalmazottak listája</a>
<a href="index.php?p=get&entity=department">Részlegek listája</a>
</p>
<p>
<a href="index.php?p=create&entity=employee">Új alkalmazott felvétele</a>
<a href="index.php?p=create&entity=department">Új részleg felvétele</a>
<a href="index.php?p=create&entity=companycar">Új céges autó felvétele</a>
</p>

<h1>Céges autók listája</h1>

<table>
<tr>
	<!-- <th>Céges autó azonosító</th> -->
	<th><a href="index.php?p=get&entity=companycar&sort=brand">Márka</a></th>
	<th><a href="index.php?p=get&entity=companycar&sort=type">Típus</a></th>
	<th><a href="index.php?p=get&entity=companycar&sort=lpnumber">Rendszám</a></th>
	<th>Módosítás</th>
	<th>Törlés</th>
</tr>
{foreach $data as $text}
<tr>
<!-- <td> {$text['ID']} </td> -->
<td> {$text['Brand']} </td>
<td> {$text['Type']} </td>
<td> {$text['LPNumber']} </td>
<td> <a href="index.php?p=edit&entity=companycar&id={$text['ID']}">módosítás</a> </td>
<td> <a href="index.php?p=delete&entity=companycar&id={$text['ID']}">törlés</a> </td>
</tr>
{/foreach}
</table>



