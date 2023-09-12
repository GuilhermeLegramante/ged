<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class Gates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $rota = $request->path();
        $software = env('APP_PRODUTOR_NAME');

        $idSoftware = DB::table('adm_software')->where('descricao', 'like', $software)->get()->first()->id;

        $buscaRota = DB::table('adm_rota')
            ->where('idsoftware', $idSoftware)
            ->where('rota', $rota)
            ->get()->first();

        // Se a rota está cadastrada, verifica se o usuário tem permissão
        if ($buscaRota != null) {
            $permissao = DB::table('adm_rotausuario')
                ->where('idusuario', $_SESSION['idusuario'])
                ->where('idrota', $buscaRota->id)
                ->get()->first();

            if ($permissao != null) {
                return $next($request);
            } else {
                return redirect()->route('dashboard')->with('error', 'Você não possui permissão de acesso. Por favor, entre em contato com o administrador.');
            }

        }

        return $next($request);
    }
}
