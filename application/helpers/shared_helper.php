<?php

/**
 * Created by PhpStorm.
 * User: immanuel.hanitya
 * Date: 2/18/2017
 * Time: 9:32 PM
 */
function autocode($indentifier) {
    $msg = $indentifier . date('mYdGis');
    return $msg;
}

function jsonLoader($json) {
    $load = get_instance();

    $load->output
            ->set_content_type('application/json')
            ->set_output(strip_tags(json_encode($json)));

    return $load;
}

function restResult($query) {
    $body = get_instance();
    $sql = $body->db->query($query)->result();
    $body->output
            ->set_content_type('application/json')
            ->set_output(strip_tags(json_encode($sql)));
    return $body;
}

function restQueryPlain($query) {
    $body = get_instance();
    $sql = $body->db->query($query)->result();
    return $sql;
}

function restCreateObject($objectName, $query) {
    $body = get_instance();
    $sql = $body->db->query($query)->result();
    $body->output
            ->set_content_type('application/json')
            ->set_output(strip_tags(json_encode([$objectName => $sql])));
    return $body;
}

function restCreateObject2($objectName, $query, $objectName2, $query2) {
    $body = get_instance();
    $sql = $body->db->query($query)->result();
    $sql2 = $body->db->query($query2)->result();
    $body->output
            ->set_content_type('application/json')
            ->set_output(strip_tags(json_encode([$objectName => $sql, $objectName2 => $sql2])));
    return $body;
}

function restCreateObjectMySQL($objectName, $query) {
    $body = get_instance();
    $sql = $body->db2->query($query)->result();
    $body->output
            ->set_content_type('application/json')
            ->set_output(strip_tags(json_encode([$objectName => $sql])));
    return $body;
}

function restCreateObjectString($objectName, $query) {
    $body = get_instance();
//$sql = $body->db->query($query)->result();
    $body->output
            ->set_content_type('application/json')
            ->set_output(strip_tags(json_encode([$objectName => $query])));
    return $body;
}

function restPostQuery($query) {
    $body = get_instance();
    if ($body->input->server('REQUEST_METHOD') == 'POST') {
        $body->db->query($query);
    }
}

function checkNumber($code, $success, $failed) {
    
}

function reString($query) {
    $body = get_instance();
    $body->output
            ->set_content_type('application/json')
            ->set_output(json_encode($query));
    return $body;
}

function restCheckStatus($query) {
    $body = get_instance();
    if ($body->db->query($query)->num_rows() >= 1) {
        echo '{"status":"ok"}';
    } else {
        echo '{"status":"failed"}';
    }
}

function restInput($input) {
    $body = json_decode(file_get_contents('php://input'), true);
    return $body[$input];
}

function enci($input) {
    $body = get_instance();

    return $body->encryption->encrypt($input);
}

function deci($input) {
    $body = get_instance();

    return $body->encryption->decrypt($input);
}

function theRealServerPath() {
    $link = 'http://' . $_SERVER['SERVER_NAME'] . '/mobileqa/public/apps/';
//$link = 'http://10.91.1.236/mobile/public/apps/';
    return $link;
}

function setMail($to, $view, $data) {
    $body = get_instance();

    $body->load->library('email');

    $config['protocol'] = 'smtp';
    $config['smtp_host'] = '10.90.0.151';
    $config['smtp_port'] = '25';
    $config['mailtype'] = 'html';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = true;

    $body->email->initialize($config);

    $body->email->from('mobile.sgf@japfa.com', 'SGF Mobile Sales');
    $body->email->to($to);

    $body->email->subject('Do not Reply: Perubahan kode keamanan So Good Food Mobile Sales');
    $messageBody = $body->load->view($view, $data, true);
    $body->email->message($messageBody);
    $body->email->send();
}

/**
 * Created by : robin.kurniawan
 */
function restOutputCustom($data) {
    $body = get_instance();
    $body->output
            ->set_content_type('application/json')
            ->set_output(json_encode(
                            $data
    ));
}

function restOutput($status, $message, $data) {
    $body = get_instance();
    $body->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'status' => $status,
                'message' => $message,
                'data' => $data
    )));
}

function arrResponse($status, $message, $data) {
    return array(
        'status' => $status,
        'message' => $message,
        'data' => $data
    );
}

function validInput($arrData) {
    $isNull = false;
    $i = 0;
    while ($i < count($arrData)) {
        if (is_null($arrData[$i])) {
            $isNull = true;
        }
        $i++;
    }
    return $isNull;
}
