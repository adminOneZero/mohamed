namespace App\Http\Controller\Notify;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Notify {
  function alert($message,$user_id,$for_admin = false) {
        $group = "user";
        if ($for_admin) {
            $group = "admin";

        }
        // dd($group);
        $result = DB::table('Notifications')->insert([
            'message' => $message,
            'user_id' => $user_id,
            'group' => $group,
            'time' => carbon::now()->toDateTimeString(),
            'status' => 1,
            ]);
        return $result;
        
    }
}