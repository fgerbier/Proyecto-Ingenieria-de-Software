<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('negrea_al_dan',function(){
    $this->comment('¿Que hacemos? Tlabaja, tiene que tlabajal. Mañana ocho mañana. No,no,no. Levántate. Mañana tienes que trabajar.Plata tú no plata');
})->purpose('TLABAJA');


Artisan::command('negrea_al_pipe',function(){
    $this->comment('¿Que hacemos? Tlabaja, tiene que tlabajal. Mañana ocho mañana. No,no,no. Levántate. Mañana tienes que trabajar.Plata tú no plata');
})->purpose('TLABAJA');


Artisan::command('negrea_a_sele',function(){
    $this->comment('¿Que hacemos? Tlabaja, tiene que tlabajal. Mañana ocho mañana. No,no,no. Levántate. Mañana tienes que trabajar.Plata tú no plata');
})->purpose('TLABAJA');


Artisan::command('negrea_al_lucas',function(){
    $this->comment('Deja que los otros hagan todo, tu descansa mi rei 😎👌');
})->purpose('TLABAJA');