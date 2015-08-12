<?php
//  -----------------------------------------------------------------------  //
//                           Alumni for Xoops 2.3.x                             //
//                             By John Mordo                                 //
//                                                                           //
//                                                                           //
//                                                                           //
//                                                                           //
// ------------------------------------------------------------------------- //
use Xoops\Core\Request;
include __DIR__ . '/header.php';
$xoops     = Xoops::getInstance();
$moduleDirName = basename(__DIR__);
$myts = MyTextSanitizer::getInstance();
$lid = Request::getInt('lid', 0);

    $currenttheme = $xoopsConfig['theme_set'];
    $alumni       = Alumni::getInstance();
    $helper          = $xoops->getModuleHelper('alumni');
    $module_id       = $helper->getModule()->getVar('mid');

    $groups          = $xoops->isUser() ? $xoops->user->getGroups() : '3';
    $alumni_ids      = $xoops->getHandlerGroupperm()->getItemIds('alumni_view', $groups, $module_id);
    $listingHandler = $xoops->getModuleHandler('listing', 'alumni');
    $listing_criteria       = new CriteriaCompo();
    $listing_criteria->add(new Criteria('lid', $lid, '='));
    $listing_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
    $numrows = $listingHandler->getCount($listing_criteria);

    $listing_arr = $listingHandler->getall($listing_criteria);
    unset($listing_criteria);
    foreach (array_keys($listing_arr) as $i) {
        $lid        = $listing_arr[$i]->getVar('lid');
        $cid        = $listing_arr[$i]->getVar('cid');
        $name       = $listing_arr[$i]->getVar('name');
        $mname      = $listing_arr[$i]->getVar('mname');
        $lname      = $listing_arr[$i]->getVar('lname');
        $school     = $listing_arr[$i]->getVar('school');
        $year       = $listing_arr[$i]->getVar('year');
        $studies    = $listing_arr[$i]->getVar('studies');
        $activities = $listing_arr[$i]->getVar('activities');
        $extrainfo  = $listing_arr[$i]->getVar('extrainfo');
        $occ        = $listing_arr[$i]->getVar('occ');
        $date       = $listing_arr[$i]->getVar('date');
        $email      = $listing_arr[$i]->getVar('email');
        $submitter  = $listing_arr[$i]->getVar('submitter');
        $usid       = $listing_arr[$i]->getVar('usid');
        $town       = $listing_arr[$i]->getVar('town');
        $valid      = $listing_arr[$i]->getVar('valid');
        $photo      = $listing_arr[$i]->getVar('photo');
        $photo2     = $listing_arr[$i]->getVar('photo2');
        $view       = $listing_arr[$i]->getVar('view');

        $useroffset = '';
        if ($xoopsUser) {
            $timezone = $xoopsUser->timezone();
            if (isset($timezone)) {
                $useroffset = $xoopsUser->timezone();
            } else {
                $useroffset = $xoopsConfig['default_TZ'];
            }
        }
        $date = ($useroffset * 3600) + $date;
        $date       = XoopsLocale::formatTimestamp($date, 's');
        $name       = $myts->htmlSpecialChars($name);
        $mname      = $myts->htmlSpecialChars($mname);
        $lname      = $myts->htmlSpecialChars($lname);
        $school     = $myts->htmlSpecialChars($school);
        $year       = $myts->htmlSpecialChars($year);
        $studies    = $myts->htmlSpecialChars($studies);
        $activities = $myts->displayTarea($activities, 1, 0, 1, 1, 1);
        $occ        = $myts->htmlSpecialChars($occ);
        $submitter  = $myts->htmlSpecialChars($submitter);
        $town       = $myts->htmlSpecialChars($town);

        echo '
    <html>
    <head><title>' . $xoopsConfig['sitename'] . "</title>
	<link rel=\"StyleSheet\" href=\"../../themes/" . $currenttheme . "/style/style.css\" type=\"text/css\">
	</head>
    <body bgcolor=\"#FFFFFF\" text=\"#000000\">
    <table border=0><tr><td>
    <table border=0 width=640 cellpadding=0 cellspacing=1 bgcolor=\"#000000\"><tr><td>
    <table border=0 width=100% cellpadding=8 cellspacing=1 bgcolor=\"#FFFFFF\"><tr><td>";

        echo "<table width=100% border=0 valign=top><tr><td><b>$name&nbsp;$mname&nbsp;$lname<br /><br /> $school " . AlumniLocale::CLASSOF . " $year</b>";
        echo '</td>
	      </tr>';
        if ($studies) {
            echo "<tr>
      <td><br /><b>" . AlumniLocale::STUDIES_2 . "</b><div style=\"text-align:justify;\">$studies</div><p>";
            echo '</td>
	      </tr>';
        }
        if ($activities) {
            echo "<tr><td><br /><b>" . AlumniLocale::ACTIVITIES_2 . "</b><div style=\"text-align:justify;\">$activities</div><p>";
            echo '</td>
	      </tr>';
        }
        if ($occ) {
            echo "<tr><td><br /><b>" . AlumniLocale::OCC_2 . "</b><div style=\"text-align:justify;\">$occ</div><p>";
            echo '</td>
	      </tr>';
        }
        if ($town) {
            echo "<tr><td><br /><b>" . AlumniLocale::TOWN_2 . "</b><div style=\"text-align:justify;\">$town</div>";
            echo '</td></tr>';
        }
        echo "</table><table width=\"100%\" border=0 valign=top>";
        if ($photo) {
            echo "<tr><td width=\"40%\" valign=\"top\"><br /><b>" . AlumniLocale::GRAD_PHOTO . "</b><br /><br /><img src=\"photos/grad_photo/$photo\" width='125' border=0></td>";
        }

        if ($photo2) {
            echo "<td width=\"60%\" valign=\"top\"><br /><b>" . AlumniLocale::NOW_PHOTO . "</b><br /><br />&nbsp;&nbsp;&nbsp;<img src=\"photos/now_photo/$photo2\" width='125' border=0></td></tr>";
        }
        echo '</table><table border=0>';
        echo '<tr><td><br /><b>' . AlumniLocale::LISTING_ADDED . " $date <br />";
        echo '</td>
	</tr></table>
	</td></tr></table></td></tr></table>
	<br /><br /><center>
	' . AlumniLocale::LISTING_FROM . ' <b>' . $xoopsConfig['sitename'] . '</b><br />
	<a href="' . XOOPS_URL . "/modules/{$moduleDirName}/\">" . XOOPS_URL . "/modules/{$moduleDirName}/</a>
	</td></tr></table>
	</body>
	</html>";
	}



