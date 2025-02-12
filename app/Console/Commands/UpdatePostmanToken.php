<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
class UpdatePostmanToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-postman-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновляет Postman JSON с новым токеном';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admin = User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->first();

        $user = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->first();

        if (!$admin || !$user) {
            $this->error('Администратор или клиент не найден!');
            return;
        }

        $adminToken = $admin->createToken('AdminToken')->plainTextToken;
        $userToken = $user->createToken('UserToken')->plainTextToken;

        $this->updatePostmanJson($adminToken, $userToken);
    }

    private function updatePostmanJson($adminToken, $userToken): void
    {
        $baseUrl = env('APP_URL');
        $basePort = env('APP_PORT');
        $postmanFile = base_path('/postman/Tokens.postman_environment.json');

        if (!file_exists($postmanFile)) {
            $this->error('Файл Postman не найден.');
            return;
        }

        $postmanData = json_decode(file_get_contents($postmanFile), true);
        if (!$postmanData || !isset($postmanData['values']) || !is_array($postmanData['values'])) {
            $this->error('Ошибка чтения Postman окружения.');
            return;
        }

        foreach ($postmanData['values'] as &$variable) {
            if ($variable['key'] === 'admin_token') {
                $variable['value'] = $adminToken;
            }
            if ($variable['key'] === 'user_token') {
                $variable['value'] = $userToken;
            }
            if ($variable['key'] === 'app_url'){
                $variable['value'] = $baseUrl;
            }
            if ($variable['key'] === 'app_port'){
                $variable['value'] = $basePort;
            }

        }
        file_put_contents($postmanFile, json_encode($postmanData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->info("Postman JSON обновлён.");
    }
}
