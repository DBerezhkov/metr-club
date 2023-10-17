<?php

namespace App\Console\Commands;

use App\Jobs\Admin\SendNotificationToUser;
use App\Models\User;
use Illuminate\Console\Command;

class SendNotificationNewLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send_notification_new_login {--limit=count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $excluded_emails = [ "rk@metr.club",  "an@metr.club", "en@metr.club", "admin@metr.club", "robot@metr.club",
           "zayavka@metr.club",  "Ipoteka@metr.club", "insurance@metr.club", "developers@metr.club", "Ek@metr.club",
            "e.kopaneva@metr.club", "liliyabakanova@metr.club", "olgas@metr.club", "elmiravisitova@metr.club", "shon@metr.club",
            "mskidanov@metr.club"];
        $query = User::where('email', 'like', "%@metr.club")
            ->whereNotIn('email', $excluded_emails)
            ->whereNotNull("agent_contract_props")
            ->whereNull('deleted_at');
        $limit = $this->option('limit') != 'count' ?  $this->option('limit') : 50;
        $users = $query->limit($limit)->get();
        $counter = 0;
        if (empty($query->get()->toArray())){
            echo "В выборке пусто! Все логины изменены";
            logger("В выборке пусто! Все логины изменены");
        } else {
            echo "Запрос вернул " . $query->count() . " пользователей" . "\n";
            logger("Запрос вернул " . $query->count() . " пользователей" . "\n");
            foreach ($users as $user){
                $counter += 1;
                if(isset($user->agent_contract_type_id) && isset($user->agent_contract_props[$user->agent_contract_type_id]["email"])){
                    $new_email = $user->agent_contract_props[$user->agent_contract_type_id]['email'];
                    if(!User::query()->where('email', $new_email)->withTrashed()->exists()){
                        $user->update([
                            'email' => $new_email
                        ]);
                        echo $counter . ". Обрабатывается " . $user->email . "\n";
                        logger($counter . ". Обрабатывается " . $user->email . "\n");
                        SendNotificationToUser::dispatch($user)->onQueue('SendNotificationToUser');
                        sleep(30);
                    } else {
                        echo $counter . ". Пользователь с e-mail " . $new_email . " уже существует" . "\n";
                        logger($counter . ". Пользователь с e-mail " . $new_email . " уже существует" . "\n");
                    }
                } else {
                    echo $counter .  ". Письмо не отправлено, логин не изменён, так как поля agent_contract_type_id и/или agent_contract_props.email не заполнены для юзера с email " . $user->email . "\n";
                    logger($counter .  ". Письмо не отправлено, логин не изменён, так как поля agent_contract_type_id и/или agent_contract_props.email не заполнены для юзера с email " . $user->email . "\n");
                }
            }
        }
    }
}
