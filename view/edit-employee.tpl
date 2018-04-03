<h1>Alkalmazott adatainak {$title}</h1>

{$form->Open()}
<ul>
<li> {$form->TextField('name','Név', {$data->Name})} </li>
<li> {$form->TextField('phone','Telefonszám', {$data->Phone})} </li>
<li> {$form->TextField('email','E-mail', {$data->Email})} </li>
<li> {$form->TextField('note','Megjegyzés', {$data->Note})} </li>

<li>
<p>Részlegek:</p>
<select name=departments[] multiple>
{html_options values=$option_values selected=$option_selected output=$option_output}
</select>
</li>
<li>
<p>Céges autók:</p>
<select name=companycars[] multiple>
{html_options values=$cc_option_values selected=$cc_option_selected output=$cc_option_output}
</select>
</li>