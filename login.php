<?php
/*
	Template name: Login
*/

get_header(); 

global $post;

/*
  $Id: epresssign_gpm_login.php,v 1.80 2003/06/05 23:28:24 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
$test=1;

  $session_started=false;
  $language='english';
  $language_id=1;
  $error=false;

  require('includes/application_top.php');

// print 'Status:'.session_status().'<br>';
// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
  if ($session_started == false) {
    tep_redirect(tep_href_link(FILENAME_COOKIE_USAGE));
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_LIST);
  //echo "Before getting the variables...";
  $error = false;

  if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    //$email_address = tep_db_prepare_input($_POST['email_address']);
    $gpm_user_id = tep_db_prepare_input($_POST['webaccountid']);
    $password = tep_db_prepare_input($_POST['passwordfield']);
    
    $language='english';
    $language_id=1;
    

    if ($test) {
        $check_customer_query3 = tep_db_query('SELECT `id`, `companyname`, `language`, `inactive` FROM ' . TABLE_PRESSSIGNGPMUSERS . ' WHERE `email` = "' . tep_db_input($gpm_user_id) . '"');      
    } else {
        $check_customer_query3 = tep_db_query('SELECT `id`, `companyname`, `language`, `inactive` FROM ' . TABLE_PRESSSIGNGPMUSERS . ' WHERE `email` = "' . tep_db_input($gpm_user_id) . '" and `password` = MD5("' . tep_db_input($password) . '")');
    }
    if (tep_db_num_rows($check_customer_query3)) {
        $check_gpm_company = tep_db_fetch_array($check_customer_query3);
        if ($check_gpm_company['inactive']) {
            $returnedaccid='';
            $messageStack->add('login', TEXT_LOGIN_ERROR_GPM_INACTIVE);
        } else {
            $returnedaccid = $check_gpm_company['id'];
            $company = $check_gpm_company['companyname'];

            $lang = $check_gpm_company['language'];
            $query='SELECT `languages_id`, `directory` FROM '.TABLE_LANGUAGES.' WHERE `code`="'.tep_db_input($lang).'"';

            $result=tep_db_query($query);
            if (tep_db_num_rows($result)) {
                $lng=tep_db_fetch_array($result);
                $language=$lng['directory'];    
                $language_id=$lng['languages_id'];  
            }
            
            
            $query='SELECT `client_webid` FROM '.TABLE_EPRESSSIGNCLIENT.' WHERE `email`="'.tep_db_input($gpm_user_id).'"';

            $result=tep_db_query($query);
            if (tep_db_num_rows($result)) {
                $client=tep_db_fetch_array($result);
                $client_id=$client['client_webid'];
            }
        }
    } else {
        $returnedaccid='';
        $messageStack->add('login', TEXT_LOGIN_ERROR_GPM);
    }
    
    if ($returnedaccid=='') {
      $error = true;
        $query='INSERT INTO `activity_log` SET `username`="'.tep_db_input($gpm_user_id).'", `action`="failed login", `date`=NOW(), `ipaddress`="'.$_SERVER['REMOTE_ADDR'].'"';
        tep_db_query($query);
    } else {
        if (SESSION_RECREATE == 'True') {
          tep_session_recreate();
        }
        
        $query='INSERT INTO `activity_log` SET `username`="'.tep_db_input($gpm_user_id).'", `action`="successful login", `date`=NOW(), `ipaddress`="'.$_SERVER['REMOTE_ADDR'].'"';
        tep_db_query($query);

        $user_webaccount_id=$client_id;
        $typeofuser = 'client';
        $user_company = $company;
        
        tep_session_register('user_webaccount_id');
        tep_session_register('typeofuser');
        tep_session_register('user_company');


        $gpm_user_id = $returnedaccid;


        tep_session_register('gpm_user_id');

        tep_session_register('language');
        tep_session_register('languages_id');

        tep_redirect(tep_href_link(FILENAME_EPRESSSIGNLIST));
        
      }
    }


//  if ($error == true) {
//      $messageStack->add('login', TEXT_LOGIN_ERROR_GPM);
//  }
  

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_EPRESSSIGNLIST, '', 'SSL'));
?>

    <div class="showcase inner">
		<?php 
            if(has_post_thumbnail()):
            $attachment_id = get_post_thumbnail_id($post->ID);
            $banner_image = vt_resize( $attachment_id,'' , 1057, 150, true ); // Set to false if you don't want to crop the image
        ?>
	   	   <img src="<?php echo $banner_image['url']; ?>" alt="<?php the_sub_field('home_banner_caption_heading'); ?>" />
        <?php endif; ?>

        <div class="box">
            <h1><?php echo get_the_title($post->ID); ?></h1>
        </div><!-- box -->
    </div><!-- showcase -->

    <div class="container">
    	<div class="box">
            <div class="content">
                <table border="0" width="100%" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="col_left">
                <!-- left_navigation //-->
                <?php //require(DIR_WS_INCLUDES . 'column_left.php'); ?>
                <!-- left_navigation_eof //-->
                   </td>
                <!-- body_text //-->
                    <td width="100%" class="col_center"><?php echo tep_draw_form('login', tep_href_link(FILENAME_EPRESSSIGNGPMLOGIN, 'action=process', 'SSL')); ?><table border="0" width="100%" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>

                <? tep_draw_heading_top();?>
                        
                <? new contentBoxHeading_ProdNew($info_box_contents);?>

                <? tep_draw_heading_top_1();?>

                <?php
                  if ($messageStack->size('login') > 0) {
                ?>
                      
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr><td><?php echo $messageStack->output('login'); ?></td></tr>
                            <tr><td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td></tr>
                        </table>
                <?php
                  }

                  if ($cart->count_contents() > 0) {
                ?>
                      <table cellpadding="0" cellspacing="0" border="0">
                        <tr><td class="smallText padd_1"><?php echo TEXT_VISITORS_CART; ?></td></tr>
                        <tr><td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td></tr>
                      </table>
                <?php
                  }
                ?>




                        
                      <div align="right"><?php echo getLogoForDealer($_SESSION['dealer_id']); ?></div>
                        <table border="0" cellspacing="3" cellpadding="2">
                          <tr>
                          <td colspan="2">
                          <b><?php echo ENTRY_PRESSSIGN_GPM_LOGIN_TITLE; ?></b><br>
                          <?php echo ENTRY_PRESSSIGN_GPM_LOGIN_TEXT; ?>
                          <br>
                          </td>
                          </tr>
                          <tr>
                          <td colspan="2">
                          <?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?>
                          <?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?>
                          <?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?>
                          <?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?>
                          </td>
                          </tr>
                          
                          <tr>
                            <td class="main" width="50%" valign="top"><b><?php echo HEADING_NEW_CUSTOMER; ?></b></td>
                            <td class="main" width="50%" valign="top"><b><?php echo HEADING_RETURNING_CUSTOMER; ?></b></td>
                          </tr>
                          <tr>
                            <td width="50%" height="100%" valign="top">
                            
                <?php echo tep_draw_infoBox_top();?>
                                
                                <table border="0" width="100%" height="100%" cellspacing="4" cellpadding="2" style=" height:220px;">
                                  <tr><td class="main" valign="top"><?php echo TEXT_NEW_CUSTOMER . '<br><br>' . TEXT_NEW_CUSTOMER_INTRODUCTION; ?></td></tr>
                                  <tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?><br style="line-height:1px;"></td> </tr>
                                  <tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?><br style="line-height:1px;"></td> </tr>
                                  <tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?><br style="line-height:5px;"></td></tr>
                                  <tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?><br style="line-height:5px;"></td></tr><tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td></tr>
                                  <tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?><br style="line-height:5px;"></td></tr>
                                  <tr><td colspan="2">
                                    <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                      <tr>
                                        <td><?php echo tep_draw_separator('pixel_trans.gif', '5', '1'); ?></td>
                                        <td align="right">
                                            <?php echo '<a href="' . tep_href_link(FILENAME_CREATE_ACCOUNT_EPRESSSIGNGPMCLIENT, '', 'SSL') . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?>
                                            <br style="line-height:1px;">
                                            <br style="line-height:5px;">
                                        </td>
                                        <td><?php echo tep_draw_separator('pixel_trans.gif', '5', '1'); ?></td>
                                      </tr>
                                    </table>
                                    </td></tr>
                                </table>
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                    
                <?php echo tep_draw_infoBox_bottom();?> 
                        
                            </td>
                            <td width="50%" height="100%" valign="top">
                            <?php echo tep_draw_infoBox_top();?>            
                                
                                <table border="0" width="100%" height="100%" cellspacing="4" cellpadding="2" style=" height:220px;">
                                  <tr><td class="main" colspan="2"><?php echo TEXT_RETURNING_CUSTOMER; ?></td></tr>
                                  <tr><td class="main"><b><?php echo ENTRY_EMAIL_ADDRESS;//ENTRY_EMAIL_ADDRESS; ?></b><br style="line-height:1px;"><br style="line-height:5px;"><?php echo tep_draw_input_field('webaccountid'); ?></td></tr>
                                  <tr><td class="main"><b><?php echo ENTRY_PASSWORD; ?></b><br style="line-height:1px;"><br style="line-height:5px;"><?php echo tep_draw_password_field('passwordfield'); ?></td></tr>
                                  <tr><td class="smallText" colspan="2"><?php echo '<a href="' . tep_href_link(FILENAME_PASSWORD_FORGOTTEN_EPRESSSIGN_GPM, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; ?></td></tr>
                                  <tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td></tr>
                                  <tr><td colspan="2">
                                    <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                      <tr>
                                        <td><?php echo tep_draw_separator('pixel_trans.gif', '5', '1'); ?></td>
                                        <td align="right" class="bg_input"><?php echo tep_image_submit('button_sign_in1.gif', IMAGE_BUTTON_LOGIN); ?><br style="line-height:1px;"><br style="line-height:5px;"></td>
                                        <td><?php echo tep_draw_separator('pixel_trans.gif', '5', '1'); ?></td>
                                      </tr>
                                    </table>
                                    </td></tr>
                                </table>
                                
                <?php echo tep_draw_infoBox_bottom();?>                


                            </td>
                          </tr>
                        </table>
                        
                <? tep_draw_heading_bottom_1();?>
                            
                <? tep_draw_heading_bottom(); ?>
                    
                        </td>
                      </tr>
                    </table></form></td>
                <!-- body_text_eof //-->
                    <td class="col_right">
                <!-- right_navigation //-->
                <?php //require(DIR_WS_INCLUDES . 'column_right.php'); ?>
                <!-- right_navigation_eof //-->
                    </td>
                  </tr>
                </table>

                <div class="clear"></div>
            </div><!-- content -->
        </div><!-- box -->

<?php get_footer(); ?>