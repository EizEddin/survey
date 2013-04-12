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
<?php //print_r($node->webform['components']);?>
<?php //print_r($submission);?>

<div style="width: 90%; text-align: center;">
    <div style="border: 20px solid #FFF;">       
        <img src="http://www.barasoft.co.uk/survey/sites/all/modules/barasoft/mihe_survey/images/mihe-logo-2.png" />        
    </div>
    <div style="border: 10px solid #FFF; text-align: center; font-size: 24px; font-weight: bold;">
        Graduate Destination Survey
    </div>
    <div style="border-left: 3px solid #FFF; border-right: 3px solid #FFF; border-bottom: 5px solid #FFF; border-top: 5px solid #FFF; text-align: left;">
        <b>Submitted on:&nbsp;</b> <?php print (date('d/m/Y, H:i', $submission->submitted)); ?><br />
        <b>Submitted by:&nbsp;</b> <?php print ($submission->remote_addr); ?>
    </div>    
    <?php
        foreach($node->webform['components'] as $eid => $entry){
            if($entry['type']=='fieldset'){
                print '<div style="border-left: 3px solid #CCC; border-right: 3px solid #CCC; border-bottom: 3px solid #CCC; padding-top:3px; text-align: left; background-color:#CCC; font-weight: bold;">'.$entry['name'].'</div>';
            }else{
                if (isset($submission->data[$eid]['value'][0])){                
//                if($submission->data[$eid]['value'][0]){
                   print '<div style="border-left: 3px solid #EEE; border-right: 3px solid #EEE; border-bottom: 3px solid #EEE; padding-top:3px; text-align: left; background-color:#EEE; font-weight: bold;">'.$entry['name'].'</div>';
                   foreach($submission->data[$eid]['value'] as $vid => $value){
                        if($entry['type']=='select'){
                            $optionsArr[] = array();
                            $options = explode("\n",$entry['extra']['items']);
                            foreach ($options as $option) {
                                $bla = explode("|", $option);
                                 if (isset($bla[0]) && isset($bla[1])) {
                                     $optionsArr[$bla[0]] =  $bla[1];
                                 }
                            }
                            if (isset($optionsArr[$value])) {
                                print '<div style="border-left: 3px solid #FFF; border-right: 3px solid #FFF; border-bottom: 3px solid #FFF; padding-top:3px; text-align: left;">'.$value.' = '.$optionsArr[$value].'</div>';                       
                            }
                        }else{
                            if (isset($value)) {
                                print '<div style="border-left: 3px solid #FFF; border-right: 3px solid #FFF; border-bottom: 3px solid #FFF; padding-top:3px; text-align: left;">'.$value.'</div>';                       
                            }
                        }
                   }
                }
            }
        }
    ?>    
</div>