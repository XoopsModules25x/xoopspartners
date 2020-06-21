<h4><{$sitename}> <{$lang_main_partner}></h4>

<table class='bnone width100' style='margin: 0;'>
    <tr>
        <{*        <td class='left width50'><{$partner_join}></td> *}>
        <td class='right width50 bold'><{if ($partner_join)}><a href='join.php' title='<{$smarty.const._MD_XOOPSPARTNERS_JOIN}>'><{$smarty.const._MD_XOOPSPARTNERS_JOIN}></a><{else}>&nbsp;<{/if}></td>
        <td class='right'><{$pagenav}></td>
    </tr>
</table>

<table class='outer width100' style='margin: 1px;'>
    <tr>
        <th class='left width5' nowrap='nowrap'><{$lang_partner}></th>
        <th class='left'><{$lang_desc}></th>
        <th class='left width10' nowrap='nowrap'><{$lang_hits}></th>
    </tr>

    <{section name=partner loop=$partners}>
        <tr>
            <td class='even center middle pad3'><{if !empty($partners[partner].url)}><a href='<{$partners[partner].url}>' target='_blank'><{$partners[partner].image}></a><{else}><{$partners[partner].image}><{/if}></td>
            <td class='odd left top'><{if !empty($partners[partner].url)}><a href='<{$partners[partner].url}>' target='_blank'><{$partners[partner].title}></a><{else}><strong><{$partners[partner].title}></strong><{/if}>&nbsp;&nbsp;<{$partners[partner].admin_option}>
                <br><{$partners[partner].description}></td>
            <td class='even center middle width10'><{$partners[partner].hits}></td>
        </tr>
        <{sectionelse}>
        <tr>
            <td class='even center middle' colspan='3'><{$lang_no_partners}></td>
        </tr>
    <{/section}>

</table>

<table class='bnone width100' style='margin: 0;'>
    <tr>
        <{*        <td class='left width50'><{$partner_join}></td> *}>
        <td class='right width50 bold'><{if ($partner_join)}><a href='join.php' title='<{$smarty.const._MD_XOOPSPARTNERS_JOIN}>'><{$smarty.const._MD_XOOPSPARTNERS_JOIN}></a><{else}>&nbsp;<{/if}></td>
        <td class='right'><{$pagenav}></td>
    </tr>
</table>
