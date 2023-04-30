<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Aacotroneo\Saml2\Events\Saml2LoginEvent;
use Auth;

use App\Models\Usuario;

class Saml2LoginListener
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
    public function handle(Saml2LoginEvent $event)
    {
        $saml2User = $event->getSaml2User();
        $samlAttributes = $saml2User->getAttributes();
        $userData = array(
            'username' => $samlAttributes['Username'][0],
            'fullname' => $samlAttributes['FullName'][0],
            'email' => $samlAttributes['Email'][0],
            'assertion' => $saml2User->getRawSamlAssertion(),
            'sessionIndex' => $saml2User->getSessionIndex(),
            'nameId' => $saml2User->getNameId()
        );

        $user = Usuario::where('usuario', $userData['username'])->first();

        if ($user == null) {
            $user = new Usuario;
            $user->usuario = $userData['username'];
            $user->nombre_completo = $userData['fullname'];
            $user->email = $userData['email'];
            $user->usuario_creador = 'admin';
            $user->fecha_creacion = \DB::raw('NOW()');
            $user->save();
        }

        session()->put('saml2user', $user);
        session()->put('sessionIndex', $userData['sessionIndex']);
        session()->put('nameId', $userData['nameId']);

        Auth::login($user);
    }
}
