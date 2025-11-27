<?php


namespace app\routes\routes\Login;

use Illuminate\Support\Facades\Route;
use App\Models\Login\controller\LoginController;




route:get('/', [LoginController::class, 'index']);
