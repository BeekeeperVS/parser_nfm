<?php

namespace components\parser\eParts\steps;

class GetBrands extends ePartsBaseStep
{

    /**
     * @inheritDoc
     */
    public function run(): void
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "2700",
            CURLOPT_URL => "https://catalog.nfm.com.ua:2700/api/v1/brands",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json, text/plain, */*",
                "user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36",
                "userid: LW932"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            print_r("cURL Error #:" . $err);
        } else {
            print_r($response);
        }
    }

}