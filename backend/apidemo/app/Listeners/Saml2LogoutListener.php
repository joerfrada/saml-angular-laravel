<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Aacotroneo\Saml2\Events\Saml2LogoutEvent;
use Auth;

class Saml2LogoutListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Saml2LogoutEvent $event)
    {
        session()->forget('saml2user');
        session()->flush();
        
        Auth::logout();
    }
}
