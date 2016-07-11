<h4><{$sitename}> <{$lang_main_partner}></h4>

<table class='bnone' style='margin: 0px; width: 95%;'>
    <tr>
        <{*        <td class='width50 txtleft'><{$partner_join}></td> *}>
        <td class='width50 txtright bold'><{if ($partner_join)}><a href='join.php' title='<{$smarty.const._MD_XPARTNERS_JOIN}>'><{$smarty.const._MD_XPARTNERS_JOIN}></a><{else}>&nbsp;<{/if}></td>
        <td class='txtright'><{$pagenav}></td>
    </tr>
</table>

<table class='outer' style='margin: 1px; width: 98%;'>
    <tr>
        <th class='width5 txtleft' nowrap='nowrap'><{$lang_partner}></th>
        <th class='txtleft'><{$lang_desc}></th>
        <th class='txtleft width1;' nowrap='nowrap'><{$lang_hits}></th>
    </tr>

    <{section name=partner loop=$partners}>
        <tr>
            <td class='even txtcenter alignmiddle pad3'><{if !empty($partners[partner].url)}><a href='<{$partners[partner].url}>' target='_blank'><{$partners[partner].image}></a><{else}><{$partners[partner].image}><{/if}></td>
            <td class='odd txtleft aligntop'><{if !empty($partners[partner].url)}><a href='<{$partners[partner].url}>' target='_blank'><{$partners[partner].title}></a><{else}><strong><{$partners[partner].title}></strong><{/if}>&nbsp;&nbsp;<{$partners[partner].admin_option}>
                <br><{$partners[partner].description}></td>
            <td class='even width1 alignmiddle txtcenter'><{$partners[partner].hits}></td>
        </tr>
        <{sectionelse}>
        <tr>
            <td class='even txtcenter alignmiddle' colspan='3'><{$lang_no_partners}></td>
        </tr>
    <{/section}>

</table>

<table class='bnone' style='margin: 0px; width: 98%;'>
    <tr>
        <{*        <td class='width50 txtleft'><{$partner_join}></td> *}>
        <td class='width50 txtright bold'><{if ($partner_join)}><a href='join.php' title='<{$smarty.const._MD_XPARTNERS_JOIN}>'><{$smarty.const._MD_XPARTNERS_JOIN}></a><{else}>&nbsp;<{/if}></td>
        <td class='txtright'><{$pagenav}></td>
    </tr>
</table>
