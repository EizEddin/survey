<?php

/**
 * @file
 * Customize the e-mails sent by Webform after successful submission.
 *
 * This file may be renamed "webform-mail-[nid].tpl.php" to target a
 * specific webform e-mail on your site. Or you can leave it
 * "webform-mail.tpl.php" to affect all webform e-mails on your site.
 *
 * Available variables:
 * - $node: The node object for this webform.
 * - $submission: The webform submission.
 * - $email: The entire e-mail configuration settings.
 * - $user: The current user submitting the form.
 * - $ip_address: The IP address of the user submitting the form.
 *
 * The $email['email'] variable can be used to send different e-mails to different users
 * when using the "default" e-mail template.
 */
?>
<?php print_r($node->webform['components']);?>
<?php print_r($submission);?>

<?php print "======================" ?>
<?php
   
    $col_left = 175;
    $col_right = 475;
    $col_tot = $col_left + $col_right;
   
    global $base_url;

    if($submission){
        print ($email['html'] ? '<table align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; width:'.$col_tot.'px;">' : '');
        print ($email['html'] ? '<tbody style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">' : '');
       
        //Title
        print ($email['html'] ? '<tr style="font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold;">' : '');
        print ($email['html'] ? '<td colspan=2 style="font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold; vertical-align:top;">' : '');
        print t('My Website Online Enquiry</br>&nbsp;');
        print ($email['html'] ? '</td>' : '');
        print ($email['html'] ? '</tr>' : '');
   
        //Date       
        print ($email['html'] ? '<tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">' : '');
        print ($email['html'] ? '<td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; vertical-align:top; width:'.$col_left.'px;">' : '');
        print t('Enquiry Date').':';
        print ($email['html'] ? '</td>' : '');
       
        print ($email['html'] ? '<td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; vertical-align:top; width:'.$col_right.'px;">' : '');
        print t('!date', array('!date' => date('Y/m/d, H:i', $submission->submitted)));
        print ($email['html'] ? '</td>' : '');
        print ($email['html'] ? '</tr>' : '');
       
        foreach($node->webform['components'] as $eid => $entry){
            if($entry['type']=='fieldset'){
                print ($email['html'] ? '<tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">' : '');
                print ($email['html'] ? '<td colspan=2 style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; vertical-align:top;">&nbsp;<br/>' : '');
                print $entry['name'];
                print ($email['html'] ? '</td>' : '');
               
                print ($email['html'] ? '</tr>' : '');
            }else{
                if($submission->data[$eid]['value'][0]){
                    print ($email['html'] ? '<tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">' : '');
                   
                    print ($email['html'] ? '<td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; vertical-align:top; width:'.$col_left.'px;">' : '');
                   
                    print $entry['name'].':';
                    print ($email['html'] ? '</td>' : '');
                   
                    print ($email['html'] ? '<td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; vertical-align:top; width:'.$col_right.'px;">' : '');
                    foreach($submission->data[$eid]['value'] as $vid => $value){
                        print nl2br($value);
                    }
                    print ($email['html'] ? '</td>' : '');
                   
                    print ($email['html'] ? '</tr>' : '');
                }
            }
        }

        $options = array(
            'attributes' => array(
                'style' => 'font-family:Arial, Helvetica, sans-serif; font-size:12px;',
            ),
        );
       
        print ($email['html'] ? '<tr style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">' : '');
        print ($email['html'] ? '<td colspan=2 align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; vertical-align:top;">&nbsp;<br/>' : '');
        print l('View enquiry online',url('node/'. $node->nid .'/submission/'. $submission->sid, array('absolute' => TRUE)), $options);
        print ($email['html'] ? '</td>' : '');
        print ($email['html'] ? '</tr>' : '');
       
        print ($email['html'] ? '<tr style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">' : '');
        print ($email['html'] ? '<td colspan=2 align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; vertical-align:top;">&nbsp;<br/>' : '');
        print l('Go to My Drupal Website',$base_url.base_path(), $options);
        print ($email['html'] ? '</td>' : '');
        print ($email['html'] ? '</tr>' : '');
       
        print ($email['html'] ? '</tbody>' : '');
        print ($email['html'] ? '</table>' : '');
    }
?>
<?php print "======================" ?>

<?php print ($email['html'] ? '<p>' : '') . t('Submitted on %date'). ($email['html'] ? '</p>' : ''); ?>

<?php if ($user->uid): ?>
<?php print ($email['html'] ? '<p>' : '') . t('Submitted by user: %username') . ($email['html'] ? '</p>' : ''); ?>
<?php else: ?>
<?php print ($email['html'] ? '<p>' : '') . t('Submitted by anonymous user: [%ip_address]') . ($email['html'] ? '</p>' : ''); ?>
<?php endif; ?>

<?php print ($email['html'] ? '<p>' : '') . t('Submitted values are') . ':' . ($email['html'] ? '</p>' : ''); ?>

%email_values

<?php print ($email['html'] ? '<p>' : '') . t('The results of this submission may be viewed at:') . ($email['html'] ? '</p>' : '') ?>

<?php print ($email['html'] ? '<p>' : ''); ?>%submission_url<?php print ($email['html'] ? '</p>' : ''); ?>
