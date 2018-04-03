<p>
<a href="index.php?p=get&entity=department">Részlegek listája</a>
<a href="index.php?p=get&entity=companycar">Céges autók listája</a>
</p>
<p>
<a href="index.php?p=create&entity=employee">Új alkalmazott felvétele</a>
<a href="index.php?p=create&entity=department">Új részleg felvétele</a>
<a href="index.php?p=create&entity=companycar">Új céges autó felvétele</a>
</p>

<h1>Alkalmazottak listája</h1>

<table>
<tr>
	<!-- <th>Alkalmazott azonosító</th> -->
	<th><a href="index.php?p=get&entity=employee&sort=name">Alkalmazott neve</a></th>
	<th><a href="index.php?p=get&entity=employee&sort=phone">Telefonszám</a></th>
	<th><a href="index.php?p=get&entity=employee&sort=email">Email</a></th>
	<th>Megjegyzés</th>
	<!-- <th>Részleg ID</th> -->
	<th><a href="index.php?p=get&entity=employee&sort=depid">Részleg</a></th>
	<!-- <th>Céges autó ID</th> -->	
	<th><a href="index.php?p=get&entity=employee&sort=carid">Céges autó</a></th>	
	<th>Módosítás</th>
	<th>Törlés</th>
</tr>
{$lastid=''}
{foreach $data as $text}

{if $text['Phone'] eq ''}
{$text['Phone']='&nbsp;' }
{/if}
{if $text['Note'] eq ''}
{$text['Note']='&nbsp;' }
{/if}
{if $text['CarName'] eq ''}
{$text['CarName']='&nbsp;' }
{/if}

<tr>
<!-- <td> {$text['ID']} </td> -->
{if $lastid eq $text['ID']}<td class="noborder"> &nbsp; </td> {else}<td> {$text['Name']} </td> {/if}
{if $lastid eq $text['ID']}<td class="noborder"> &nbsp; </td> {else}<td> {$text['Phone']} </td> {/if}
{if $lastid eq $text['ID']}<td class="noborder"> &nbsp; </td> {else}<td> {$text['Email']} </td> {/if}
{if $lastid eq $text['ID']}<td class="noborder"> &nbsp; </td> {else}<td> {$text['Note']} </td> {/if}
<!--	<td> {$text['DepID']} </td> -->
{if $lastid eq $text['ID']}<td class="noborder"> {$text['DepName']} </td> {else}<td> {$text['DepName']} </td> {/if}
<!--	<td> {$text['CarID']} </td> -->	
{if $lastid eq $text['ID']}<td class="noborder"> {$text['CarName']} </td> {else}<td> {$text['CarName']} </td> {/if}
{if $lastid eq $text['ID']}<td class="noborder"> &nbsp; </td> {else}	<td> <a href="index.php?p=edit&entity=employee&id={$text['ID']}">módosítás</a> </td>{/if}
{if $lastid eq $text['ID']}<td class="noborder"> &nbsp; </td> {else}	<td> <a href="index.php?p=delete&entity=employee&id={$text['ID']}">törlés</a> </td>{/if}
{$lastid=$text['ID']}	
</tr>
{/foreach}
</table>


