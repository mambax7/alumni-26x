﻿
<{include file="admin:system/admin_navigation.tpl"}>
<{include file="admin:system/admin_tips.tpl"}>
<{include file="admin:system/admin_buttons.tpl"}>


<{if $listing_count == true}>

    <{if $nav_menu}>
        <{$nav_menu}>
    <{/if}>

 <div class="pager"><span class="pagedisplay"></span>
    <table id='mytable' class="tablesorter">
        <thead>
        <tr>
            <th class="txtcenter" width="5%"><{translate key="ID"}></th>
            <th class="txtleft" width="20%"><{translate key="NAME"}></th>
            <th class="txtcenter" width="15%"><{$school}></th>
            <th class="txtcenter" width="10%"><{$class_of}></th>
            <th class="txtcenter" width="15%"><{translate key="DATE"}></th>
            <th class="txtcenter" width="10%"><{translate key="USERNAME"}></th>
            <th class="txtcenter" width="5%"><{$valid}></th>
            <th class="txtcenter" width="5%"><{translate key="HITS"}></th>
            <th class="txtcenter" width="15%"><{translate key="ACTION"}></th>
        </tr>
        </thead>
        <tbody>
        <{foreach item=listings from=$listing}>
        <tr class="<{cycle values='even,odd'}> alignmiddle">

            <td class="txtleft width35" rowspan="2"> <!-- rowspan="2" makes the table look nicer -->
        <a href="#" class="toggle"><{$listings.lid}></a></td>
            <td class="txtleft width35"><{$listings.name}></td>
            <td class="txtcenter width5"><{$listings.school}></td>
            <td class="txtcenter width5"><{$listings.year}></td>
            <td class="txtcenter width5"><{$listings.date}></td>
            <td class="txtcenter width5"><{$listings.submitter}></td>
            <td class="txtcenter width5"><{$listings.valid}></td>
            <td class="txtcenter width5"><{$listings.view}></td>

            <td class="xo-actions txtcenter width10">

            
                <a href="alumni.php?op=update_status&amp;lid=<{$listings.lid}>" title="<{translate key="A_ADD"}>">
                    <img src="<{xoAdminIcons 'user_add.png'}>" alt="<{translate key="A_ADD"}>">
                </a>      
            
            
            
            
                <a href="alumni.php?op=edit_listing&amp;lid=<{$listings.lid}>&amp;cid=<{$listings.cid}>" title="<{translate key="A_EDIT"}>">
                    <img src="<{xoAdminIcons 'edit.png'}>" alt="<{translate key="A_EDIT"}>">
                </a>
                <a href="alumni.php?op=delete_listing&amp;lid=<{$listings.lid}>" title="<{translate key="A_DELETE"}>">
                    <img src="<{xoAdminIcons 'delete.png'}>" alt="<{translate key="A_DELETE"}>">
                </a>
            </td>
        </tr>
        
        <tr class="tablesorter-childRow">
      <td colspan="8">
        <div><{$studies_lang}> : <{$listings.studies}></div>
        <div><{$activities_lang}> : <{$listings.activities}></div>
        <div><{$extrainfo_lang}> : <{$listings.extrainfo}></div>
         <div><{$occ_lang}> : <{$listings.occ}></div>
        
        
            </td>
        </tr>
        
        <{/foreach}>
        </tbody>
    </table>

    
    
    
          <div class="pager">
          <nav class="left">
            # per page:
            <a href="#" class="current">10</a> |
            <a href="#">25</a> |
            <a href="#">50</a> |
            <a href="#">100</a>
          </nav>
          <nav class="right">
            <span class="prev">
              <img src="../media/jquery/addons/pager/icons/prev.png"> Prev&nbsp;
            </span>
            <span class="pagecount"></span>
            &nbsp;<span class="next">Next
              <img src="../media/jquery/addons/pager/icons/next.png">
            </span>
          </nav>
        </div>  
    
    
    
    
    
    
    <div class="clear spacer"></div>

    <{if $nav_menu}>
        <{$nav_menu}>
    <{/if}>
<{/if}>

<!-- Display form (add,edit) -->
<{if $error_message}>
    <div class="alert alert-error">
        <strong><{$error_message}></strong>
    </div>
<{/if}>


