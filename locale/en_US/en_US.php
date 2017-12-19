<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
/**
 * Alumni module for Xoops
 *
 * @copyright       XOOPS Project https://xoops.org/
 * @license         GPL 2.0 or later
 * @package         alumni
 * @since           2.6.x
 * @author          John Mordo (jlm69)
 */

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

/**
 * Class AlumniLocaleEn_US
 */
class AlumniLocaleEn_US /*extends XoopsLocaleEn_US*/
{
    // Module
    const MODULE_NAME = 'Alumni';
    const MODULE_DESC = 'Module for creating Alumni pages';

    // Admin menu
    const SYSTEM_LISTING = 'Listing';
    const SYSTEM_PERMISSIONS = 'Permissions';
    const SYSTEM_ABOUT = 'About';

    // Blocks
    const BLOCKS_LISTINGS = 'Listings';
    const BLOCKS_LISTINGS_DSC = 'Display listings';
    const BLOCKS_ID = 'ID listing';
    const BLOCKS_ID_DSC = 'Display listing by ID';
    const BLOCKS_TITLE = 'Alumni Listings';
    const BLOCKS_ALL_LISTINGS = 'View all Alumni Listings.';
    const BLOCKS_ITEM = 'Title';
    const BLOCKS_DATE = 'Date';
    const BLOCKS_DISPLAY = 'Display';
    const BLOCKS_CHARS = 'characters';
    const BLOCKS_LENGTH = 'Length of the title';
    const BLOCKS_ORDER = 'Order';
    const BLOCKS_HITS = 'Hits';

    // Notifications
    const NOTIFICATION_GLOBAL = 'Whole Module ';
    const NOTIFICATION_CATEGORY = 'Category ';
    const NOTIFICATION_CATEGORY_DSC = 'Notification options that apply to the current category ';
    const NOTIFICATION_GLOBAL_DSC = 'Notification options that apply to all listings.';
    const NOTIFICATION_ITEM = 'Listing';
    const NOTIFICATION_ITEM_DSC = 'Notification options that apply to the current listing.';
    const NOTIFICATION_GLOBAL_NEWLISTING = 'New listing published';
    const NOTIFICATION_CATEGORY_NEWLISTING_CAP = 'Notify me when any new listing is published in the current category.';
    const NOTIFICATION_CATEGORY_NEWLISTING_DSC = 'Receive notification when any new listing is published in the current category.';
    const NOTIFICATION_GLOBAL_NEWLISTING_CAP = 'Notify me when any new listing is published.';
    const NOTIFICATION_GLOBAL_NEWLISTING_DSC = 'Receive notification when any new listing is published.';
    const NOTIFICATION_GLOBAL_NEWLISTING_SBJ = '[{X_SITENAME}] {X_MODULE} auto-notify : New listing published';

    // Admin index.php
    const LISTINGS = 'Listings';
    const TOTAL_LISTINGS = 'There are <span class=\'red bold\'>%s</span> listings in our database';
    const TOTAL_VALID = 'There are <span class=\'green bold\'>%s</span> approved listings';
    const TOTAL_NOT_VALID = 'There are <span class=\'red bold\'>%s</span> listings waiting to be approved';

    // Main
    const ADD_LISTING = 'Add a new listing';
    const ADD_LISTING_2 = 'Add a Listing';
    const ADD_CAT = 'Add a new Category';
    const EDIT_CAT = 'Edit this Category';
    const MODERATE_LISTING = 'Moderate Listings';
    const EDIT_LISTING = 'Edit a listing';
    const LIST_LISTING = 'List of listings';
    const APPROVE = 'Approve';
    const APPROVE_2 = 'Approve :';
    const NAME = 'Name : ';
    const NAME_2 = 'First Name : ';
    const MNAME_2 = 'Middle/Maiden Name : ';
    const LNAME_2 = 'Last Name : ';
    const SCHOOL = 'School';
    const SCHOOL_2 = 'School : ';
    const CLASS_OF = 'Class of';
    const CLASS_OF_2 = 'Class of : ';
    const MODERATED = 'waiting for approval';
    const STUDIES = 'Studies';
    const STUDIES_2 = 'Studies : ';
    const ACTIVITIES = 'Activities';
    const ACTIVITIES_2 = 'Student Activities : ';
    const EXTRAINFO = 'Extra Info';
    const EXTRAINFO_2 = 'Extra Info : ';
    const OCC = 'Occupation';
    const OCC_2 = 'Occupation : ';
    const CLOSEF = 'Close this window';
    const EMAIL = 'Email';
    const EMAIL_2 = 'Email : ';
    const TOWN_2 = 'Current Location : ';
    const SUBMITTER = 'Submitter : ';
    const EDIT = 'Edit';
    const ALUMNI_LISTINGS = 'Alumni Listings';
    const CLASSOF = 'Class of ';
    const FINTRO = 'Alumni Listings for the Local Area<br>To Add a Listing click on Your School<br>Tell your Friends';
    const SEARCH_LISTINGS = 'Search Listings : ';
    const ALL_WORDS = 'All Words';
    const ANY_WORDS = 'Any Words';
    const EXACT_MATCH = 'Exact Match';
    const MATCH = 'Match';
    const BYCATEGORY = 'By Category/School';
    const BYYEAR = 'By Year';
    const INCATEGORY = 'In this Category/School';
    const ADMIN_PANEL = 'Administration Panel';
    const THERE_ARE = 'There are';
    const WAITING = 'Alumni Listing(s) waiting to be approved';
    const THIS_AND = 'and';
    const IN = 'in';
    const CATEGORIES = 'categories';
    const THE = 'The';
    const YEAR = 'Year';
    const YEAR_2 = 'Year : ';
    const MODADMIN = 'Change this Listing (administrator)';
    const LASTADD = 'Latest Alumni Listings';
    const PHOTO_AVAILABLE = 'Photo available';
    const SEEIT = 'View pending Alumni Listings';
    const HITS = 'Hits';
    const PHOTO = 'Photo';
    const THIS_PRINT = 'Print';
    const FRIENDSEND = 'Send this Listing to a friend';
    const SUBMITTED_BY = 'Submitted by ';
    const MODIFY = 'Modify';
    const MUSTLOGIN = 'You must <a href="../profile/user.php">login</a> to reply to&nbsp;';
    const CONTACT_2 = 'Contact : ';
    const BYMAIL_2 = 'Email : ';
    const LISTING_ADDED = 'Alumni Listing added';
    const LISTING_FROM = 'This Listing from the Alumni Section on the Website ';
    const SENDTO = '<b>Send this Alumni Listing to a friend</b>';
    const LISTING_SEND = 'Sending this listing :';
    const NAMEFR = 'Friend\'s Name :';
    const MAILFR = 'Friend\'s Email :';
    const ALUM_SEND = 'The Alumni Listing selected has been sent';
    const CONTACTALUMNI = 'Contact regarding your Alumni Listing';
    const CONTACTADMIN = 'A reply to an Alumni Listing';
    const ADMIN_COPY = 'This is a copy of the message sent through your system.';
    const REPLY_TO = 'You have a reply to your Alumni Listing ';
    const FROMSITE = 'from the Alumni Section of {X_SITENAME}';
    const CAN_REPLY = 'You can reply to';
    const SUBJECT = 'An Alumni Listing from';
    const HELLO = 'Hello ';
    const NO_REPLY = '!!!  Do not reply to this e-mail, you will not get a reply.  !!!';
    const WEBMASTER = 'Webmaster';
    const YOU_CAN_VIEW_BELOW = 'You can view the full listing at the link below';
    const MESSAGE = 'thinks this Alumni Listing might interest you and has sent you this message.';
    const INTERESTED = 'Other Alumni Listings can be seen at the Alumni Section at';
    const MESSAGE_SENT = 'Your message has been sent...';
    const YOUR_IP = 'Your IP is ';
    const IP_LOGGED = ' and has been logged! Action will be taken on any abuse on this system.';
    const CONTACTAUTOR = 'Reply to this Alumni Listing';
    const YOURMESSAGE = 'Your message:';
    const AT = '  at';
    const DELPICT = 'Delete this Photo';
    const GRAD_PHOTO = 'Graduation Photo : ';
    const NOW_PHOTO = 'Recent Photo : ';
    const PHOTO2 = 'Current Photo : ';
    const FORMIMAGE_PATH = 'Select in the current category Image';
    const FORMUPLOAD = 'Upload Image';
    const FORMSUREDEL = 'Are you sure to delete it?';
    const FORMDELOK = 'Deleted successfully';
    const FORMOK = 'Added successfully';
    const ADD_MOD = 'Add an Alumni Listing<br>Your Listing will be queued for approval';
    const EDIT_MOD = 'Edit Alumni Listing<br>Your Listing will be queued for approval';
    const MODERATE = 'Your Alumni Listing will be queued for approval';
    const NO_LISTING_TO_APPROVE = 'There are no listings waiting to be approved';
    const E_NO_LISTING = 'There are no listings';
    const E_NO_CAT = 'There are no Categories';
    const ALUMNI_TIPS = '<ul><li>Add, update or delete listings</li></ul>';
    const ALUMNI_TEXT_DESC = 'Main content of the page';
    const ALUMNI_META_KEYWORDS = 'Metas keyword';
    const ALUMNI_META_KEYWORDS_DSC = 'Metas keyword separated by a comma';
    const ALUMNI_META_DESCRIPTION = 'Metas description';
    const ALUMNI_OPTIONS_DSC = 'Choose which information will be displayed';
    const ALUMNI_SELECT_GROUPS = 'Select groups that can view this content';
    const ALUMNI_COPY = '[copy]';
    const E_WEIGHT = 'You need a positive integer';
    const Q_ON_MAIN_PAGE = 'Content displayed on the home page';
    const L_ALUMNI_DOPDF = 'PDF icon';
    const L_ALUMNI_DOPRINT = 'Print icon';
    const L_ALUMNI_DOSOCIAL = 'Social networks';
    const L_ALUMNI_DOAUTHOR = 'Author';
    const L_ALUMNI_DOMAIL = 'Mail icon';
    const L_ALUMNI_DODATE = 'Date';
    const L_ALUMNI_DOHITS = 'Hits';
    const L_ALUMNI_DORATING = 'Rating and vote count';
    const L_ALUMNI_DOCOMS = 'Comments';
    const L_ALUMNI_DONCOMS = 'Comments count';
    const L_ALUMNI_DOTITLE = 'Title';
    const L_ALUMNI_DONOTIFICATIONS = 'Notifications';
    const L_ALUMNI_CATEGORIES = 'Category/School';

    // Admin permissions
    const PERMISSIONS_RATE = 'Rate permissions';
    const PERMISSIONS_VIEW = 'View permissions';
    const PERMISSIONS_SUBMIT = 'Submit permissions';
    const PERMISSIONS_PREMIUM = 'Premium permissions';

    const YOUR_VOTE = 'Your vote';
    const OF = 'of ';

    const E_NOT_EXIST = 'This page does not exist in our database';

    // Print
    const PRINT_COMES = 'This listing comes from';

    // Admin

    const DIRPERMS = 'Check Directory Permission ! => ';
    const CHECKER = 'Directory Checker';
    const CATEGORY_PID = 'Select Parent';
    const CATEGORY_TITLE = 'Category/School Name';
    const IFSCHOOL = '****** If this is the School fill in below ******';
    const ORDER = 'School Order :';
    const IMGCAT = 'Category Icon :';
    const SCPHOTO = 'School Photo :';
    const SCADDRESS = 'School Address :';
    const SCADDRESS2 = 'School Address2 :';
    const SCCITY = 'School City :';
    const SCSTATE = 'School State :';
    const SCZIP = 'School Zip Code :';
    const SCPHONE = 'School Phone :';
    const SCFAX = 'School Fax :';
    const SCMOTTO = 'School Motto :';
    const SCURL = 'School Website :http://';
    const LIST_CATS = 'List Categories';
    const LISTINGLIST = 'List Alumni Listings';
    const LISTING_VALIDATED = 'This listing is now validated';
    const WEB = 'School Website';
    const SELECTED_PHOTO = 'Selected Photo : ';
    const SUBCAT_AVAIL = 'Subcategories available :';
    const MUST_ADD_CAT = '<b>You must add a category first.</b>';
    const NO_LISTINGS = 'No listings in this category';

    // Configuration
    const CONF_BNAME = 'Alumni Block';
    const CONF_BNAME_DESC = 'Shows Alumni Block';
    const ADMENU1 = 'Home';
    const ADMENU2 = 'Categories : Schools';
    const ADMENU3 = 'Permissions';
    const ADMENU4 = 'Preferences';
    const ADMENU5 = 'Listings';
    const ADMENU6 = 'Random';
    const ADMENU7 = 'About';
    const CONF_PERPAGE = 'Listings per page :';
    const CONF_USECAT = 'Use Categories :';
    const CONF_SHOW_NEW = 'Show new Alumni Listings :';
    const CONF_ONHOME = 'on the Front Page of Module';
    const CONF_NUMNEW = 'Number of new Listings :';
    const CONF_NEWTIME = 'New Listings from :';
    const CONF_INDAYS = 'in days';
    const CONF_INBYTES = 'in bytes';
    const CONF_INPIXEL = 'in pixels';
    const CONF_EDITOR = 'Editor to use:';
    const CONF_LIST_EDITORS = 'Select the editor to use.';
    const CONF_MODERATE = 'Moderate Alumni Listings :';
    const CONF_MAXFILESIZE = 'Maximum Photo Size :';
    const CONF_MAXWIDE = 'Maximum Photo Width :';
    const CONF_MAXHIGH = 'Maximum Photo Height :';
    const CONF_TYPEBLOCK = 'Type of Block :';
    const CONF_ALUMRAND = 'Random Alumni Listing';
    const CONF_LASTTEN = 'Last 10 Alumni Listings';
    const CONF_DISPLSUBCAT = 'Display subcategories :';
    const CONF_NUMSUBCAT = 'Number of subcategories to show :';
    const CONF_ORDERALPHA = 'Sort alphabetically';
    const CONF_ORDERPERSONAL = 'Personalised Order';
    const CONF_USE_CAPTCHA = 'Use Captcha';
    const CONF_ORDER_DATE = 'Order by Date';
    const CONF_ORDER_NAME = 'Order by Name';
    const CONF_ORDER_POP = 'Order by Hits';
    const CONF_INDEX_CODE = 'Extra Index Page Code';
    const CONF_INDEX_CODE_DESC = 'Put your adsense or other code here';
    const CONF_USE_INDEX_CODE = 'Use Extra Index Page Code';
    const CONF_USE_INDEX_CODE_DESC = 'Put additional code between listings<br>on the index page<br>and the categories page.<br><br>Banners, Adsense code, etc...';
    const CONF_INDEX_CODE_PLACE = 'Code will show in this place in the list ';
    const CONF_INDEX_CODE_PLACE_DESC = 'Ex. If you choose 4 there will be 3 listings before this code.<br> Code will be displayed in the 4th slot.';
    const CONF_USE_BANNER = 'Use Xoops Banner Code';
    const CONF_USE_BANNER_DESC = 'Will allow you to insert xoopsbanners in between listings.<br>If you choose Yes<br>Do Not insert any code below';
    const CONF_OFFER_SEARCH = 'Offer search within listings';
    const CONF_OFFER_SEARCH_DESC = 'Select yes to provide a search box';
    const CONF_LORDER = 'Alumni Listing Order :';
    const CONF_CORDER = 'Category Order :';
    const CONF_BLOCK_L_DESC = 'Descending';
    const CONF_BLOCK_DISPLAY_NUMBER = 'Number to display';
}
