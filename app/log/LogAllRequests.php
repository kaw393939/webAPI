<?php
  namespace App\Log;
  use \Illuminate\Http\Request;
  class LogAllRequests implements \Spatie\HttpLogger\LogProfile
  {

      public function shouldLogRequest(Request $request): bool
      {
          return in_array(strtolower($request->method()), ['post','get', 'put', 'patch', 'delete']);
      }
  }

