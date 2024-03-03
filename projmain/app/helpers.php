<?php
    if (! function_exists('sortSubCollection')) {
        function sortArrayByKey($sortArray, $key)
        {
            $sortFunc = function($a, $b) use ($key){
                if ($a[$key] == $b[$key]) {
                    return 0;
                }
                return ($a[$key] < $b[$key]) ? -1 : 1;
            };
            usort($sortArray, $sortFunc);

            return $sortArray;
        }
    }

    function getResponse($message, $code)
    {
        http_response_code($code);
        response()->json([$message])->send();
        exit;
    }

    function getSuccess($data = [])
    {
        http_response_code(200);
        $result = ['success' => true];
        if(count($data) !== 0) $result['data'] = $data;
        return response()->json([$result])->send();
    }