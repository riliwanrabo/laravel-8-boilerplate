<?php

namespace App\Utilities;

class Helpers
{
    /**
     * @param $data
     * @param int $statusCode
     * @param null $message
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function responder($data, $statusCode = 200, $message = null, $headers = [])
    {
        $truthy = $statusCode >= 200 && $statusCode <= 209;
        $isMessageNull = is_null($message) ? true : false;
        if ($isMessageNull && $truthy) {
            $message = 'Action was successful';
        } elseif ($isMessageNull && !$truthy) {
            $message = 'Action was unsuccessful';
        }

        $result = [
            'success' => $truthy ? true : false,
            'data' => $truthy ? $data : [],
            'errors' => !$truthy ? $data : [],
            'message' => $message
        ];
        return response()->json($result, $statusCode, $headers);
    }

    public function transactionReference(): string
    {
        global $gen_txn_ref;
        $random_chars = '';
        $characters = array(
            "A", "B", "C", "D", "E", "F", "G", "H", "J", "K", "L", "M",
            "N", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
            "1", "2", "3", "4", "5", "6", "7", "8", "9"
        );

        $keys = array();
        while (count($keys) < 15) {
            $x = random_int(0, count($characters) - 1);
            if (!in_array($x, $keys, false)) {
                $keys[] = $x;
            }
        }
        foreach ($keys as $key) {
            $random_chars .= $characters[$key];
        }
        $gen_txn_ref = env('APP_SHORT_NAME', 'CiCO-BET') . '-' . $random_chars;
        return $gen_txn_ref;
    }

    public function randomString($length = 6): string
    {
        $str = "";
        $characters = array_merge(
            range('0', '9')
        );
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = random_int(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
}
