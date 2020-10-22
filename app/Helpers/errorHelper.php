<?php

/**
 * Get the error message
 * @param int $code
 * @param string $data
 * @return json
 */
function get_error($code = 400, $data_message = null) {
  switch ($code) {
    case 401:
      $message = 'Access Denied';
      break;
    case 404:
      $message = 'Resource not found';
      break;
    default:
        $message = 'Bad Request';
        break;
  }

  $data = array(
          'code'      => $code,
          'message'   => $message,
          'data'      => $data_message
      );

  // return an error
  //return response()->json($data);
  return $data;
}
