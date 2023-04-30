<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Aacotroneo\Saml2\Saml2Auth;
use Auth;

use App\Models\Usuario;

class LoginController extends Controller
{
    public function saml() {
        $url = 'https://www.dboralab.lan';
        // $url = 'http://localhost:4200';

        $hasUser = session()->has('saml2user') ? 1 : 0;

        if (!$hasUser) {
            try {
                $saml2Auth = new Saml2Auth(Saml2Auth::loadOneLoginAuthFromIpdConfig('test'));
                return $saml2Auth->login(session()->pull('url.intended'));
            }
            catch (Exception $e) {
                return abort(503);
            }            
        }
        else {
            $user = Auth::user();            
            $usuario = base64_encode($user->usuario);
            $query = http_build_query([
                'q' => $usuario,
                'type' => 'granted'
            ]);

            return redirect($url. '/saml/?'. $query);
        }
    }

    public function login(Request $request) {
        $p_usuario = base64_decode($request->get('q'));

        $user = Usuario::where('usuario', $p_usuario)->first();

        $datos = array();
        $datos['usuario_id'] = $user->usuario_id;
        $datos['usuario'] = $user->usuario;
        $datos['nombre_completo'] = $user->nombre_completo;
        $datos['email'] = $user->email;

        $response = json_encode(array('result' => $datos), JSON_NUMERIC_CHECK);
        $response = json_decode($response);
        return response()->json(array('user' => $response, 'tipo' => 0));
    }

    public function logout()
    {
        $url = 'https://www.dboralab.lan';
        // $url = 'http://localhost:4200';

        $sessionIndex = session()->get('sessionIndex');
		$nameId = session()->get('nameId');

		try {
            $saml2Auth = new Saml2Auth(Saml2Auth::loadOneLoginAuthFromIpdConfig('test'));
            $saml2Auth->logout($url, $nameId, $sessionIndex);
        }
        catch (Exception $e) {
            return abort(500);
        }
    }
}
