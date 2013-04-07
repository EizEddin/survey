<?php

    $col_left = 500;
    $col_right = 200;
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
                        
                        if($entry['type']=='select'){
//                            $options = unserialize($entry->extra);
                            $options = explode("\n",$entry['extra']['items']);
//                            print_r($options);
                            $optionsArr[] = array();
                            foreach ($options as $option) {
//                                print_r($option);                                
                                $bla = explode("|", $option);
//                                $submission->data[$eid]['value'][$bla[0]] = $bla[1];
//                                print_r($bla);
                                if (isset($bla[0]) && isset($bla[1])) {
                                    $optionsArr[$bla[0]] =  $bla[1];
                                }
                            } 
//                            print_r($optionsArr);
                            print nl2br($optionsArr[$value]);
                        } else {                        
                            //print_r($submission->data[$eid]);
                            print nl2br($value);
                        }
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
