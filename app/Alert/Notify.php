namespace App\Notify;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Notify {
  public function alert($message.$user_id) {
      DB::table('Notifications')->insert([
        'message' => $message,
        'user_id' => $user_id,
        'time' => carbon::now()->toDateTimeString(),
        'status' => 1,
        ]);
    return ['bronze' => 50, 'silver' => 100, 'gold' => 150];
  }
}