<{if $block.fadeImage}>
    <{  php}>
    /** add JQuery if not already loaded **/
    global $xoTheme;
    $xoTheme->addScript("browse.php?Frameworks/jquery/jquery.js");
    $this->assign('xoops_module_header', $xoTheme->renderMetas(null, true));
    <{  /php}>
    <{  literal}>
    <script type="text/javascript">
        <!--
        $(document).ready(function () {
            $(".thumbs img").fadeTo(0, 0.25); // This sets the opacity of the thumbs to fade down to 75% when the page loads
            $(".thumbs img").hover(function () {
                $(this).fadeTo("slow", 1.0); // This should set the opacity to 100% on hover
            }, function () {
                $(this).fadeTo("slow", 0.25); // This should set the opacity back to 60% on mouseout
            });
        });
        //-->
    </script>
    <{  /literal}>
<{/if}>

<div id="xo-partners-block" class="thumbs txtcenter">
    <div class="floatleft inline" style="margin: 1em;">
        <{ foreach item=partner from=$block.partners}>
        <{ if '' != $partner.image}>
        <a href="<{$xoops_url}>/modules/<{$block.xpDir}>/vpartner.php?id=<{$partner.id}>" rel="external">
            <img src="<{$partner.image}>" alt="<{$partner.url}>"<{if !empty($partner.title)}> title="<{$partner.title}>"<{/if}>></a><br>
        <{ /if}>
        <{ if !empty($partner.title)}>
        <a href="<{$xoops_url}>/modules/<{$block.xpDir}>/vpartner.php?id=<{$partner.id}>" rel="external">
            <span id="xo-partnerstitlelink"><{$partner.title}></span></a>
        <{ /if}>
        <{ if true == $block.insertBr}><br><{/if}>
        <{ /foreach}>
    </div>
</div>
<div class='clear'></div>
