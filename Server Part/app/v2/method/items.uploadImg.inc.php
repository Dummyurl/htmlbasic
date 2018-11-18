<?php

/*!
 * ifsoft.co.uk engine v1.0
 *
 * http://ifsoft.com.ua, http://ifsoft.co.uk
 * raccoonsquare@gmail.com
 *
 * Copyright 2012-2019 Demyanchuk Dmitry (https://vk.com/dmitry.demyanchuk)
 */

$result = array("error" => true);

if (!empty($_POST)) {

    $accountId = isset($_POST['accountId']) ? $_POST['accountId'] : '';
    $accessToken = isset($_POST['accessToken']) ? $_POST['accessToken'] : '';

    $auth = new auth($dbo);

    if (!$auth->authorize($accountId, $accessToken)) {

        api::printError(ERROR_ACCESS_TOKEN, "Error authorization.");
    }

    if (!empty($_FILES['uploaded_file']['tmp_name'])) {

        $imgLib = new imglib($dbo);
        $response = $imgLib->createPostImg($_FILES['uploaded_file']['tmp_name'], $_FILES['uploaded_file']['name']);

        if ($response['error'] === false) {

            $result = array("error" => false,
                            "imgUrl" => $response['imgUrl'],
                            "imgUrl2" => $response['imgUrl'],
                            "imgUrl3" => $response['imgUrl']);
        }

        unset($imglib);
    }

    echo json_encode($result);
    exit;
}
