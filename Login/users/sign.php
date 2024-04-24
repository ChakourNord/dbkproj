<?php

require_once('../../includes/utils.php');
require_once('../../includes/database.php');
//if ((checkToken())['id_user']<1)
//header('location: login/login.php');

global $user_data, $input;
    
    
    $file = base64ToFilesign($_POST['sign_image']);
    $file_type = 'png';
    $file_name = 'sign_' . $_POST['id_checklist'] .'_'.$_POST['timestamp']. '.' . $file_type;
    //echo ($file_name);

    $path="../../../uploads/checklists_signs/company_".checkToken()['id_company'];
    if(!is_dir($path)){
        mkdir($path,0777, true);
      }
    
    // writelog ("Ordner erstellt!");
    $file_path = $path. '/' . $file_name;
    
    if (file_put_contents($file_path, $file)) {
        //q('start transaction');
        //q('update interventi_tecnici set firma_tecnico = true where id_richiesta='.(int)$input['id']);
        //q('update interventi_tecnici_fotografie set read_only = true where id_richesta='.(int)$input['id']);
        //q('update foto_richieste set read_only = true where id_richiesta='.(int)$input['id']);
        // //aggiornaDataIntervento($input['id']); -- forse non è il caso di reimpostare la data sull'operazione di firma (?)
        //q('commit');
        //writelog ("file salvato!");
        return array(
            'result' => 'SUCCESS',
            'message' => 'Checklist chiusa con successo'
        );
    }
    
    return array(
        'result' => 'ERROR',
        'message' => 'File not saved'
    );


function base64ToFilesign($data)
{
    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);
    return base64_decode($data);
}
?>