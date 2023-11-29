<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotaFiscalCreateRequest;
use App\Http\Requests\NotaFiscalListByUserRequest;
use App\Http\Requests\NotaFiscalUpdateRequest;
use App\Http\Requests\NotaFiscalViewRequest;
use App\Http\Resources\NotaFiscalResource;
use App\Models\NotaFiscal;
use App\Models\User;
use App\Notifications\NotificaionNotafiscal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class NotaFiscalController extends Controller
{
    public function create(NotaFiscalCreateRequest $request)
    {
        $notafiscal = NotaFiscal::where("numero",$request->numero)->first();
        $user = User::find(User::logged()->id);
        if($notafiscal) {
            return response()->json(["message" => "Número da nota fiscal ja cadastrado"],409);
        }

        DB::beginTransaction();
        try {
            $notafiscal = new NotaFiscal();
            $notafiscal->numero = $request->numero;
            $notafiscal->valor = $request->valor;
            $notafiscal->data_emissao = $request->data_emissao;
            $notafiscal->cnpj_remetente = $request->cnpj_remetente;
            $notafiscal->nome_remetente = $request->nome_remetente;
            $notafiscal->cnpj_transportador = $request->cnpj_transportador;
            $notafiscal->nome_transportador = $request->nome_transportador;
            $notafiscal->id_usuario = $user->id;
            $notafiscal->save();
            DB::commit();

            try {
                $user->notify(new NotificaionNotafiscal($user));
            }catch (\Exception $e)
            {
                return response()->json([
                    "message" => "Erro no envio do email",
                    "error" => $e->getMessage()
                ],500);
            }

            return NotaFiscalResource::make($notafiscal);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    public function listByUser()
    {
        $notasfiscais = NotaFiscal::where("id_usuario",User::logged()->id)
            ->with("usuario")
            ->get();
        return NotaFiscalResource::collection($notasfiscais);

    }

    public function view(NotaFiscalViewRequest $request)
    {
        $notafiscal = NotaFiscal::where('id',$request->nota)
            ->with("usuario")
            ->first();
        Gate::authorize("view",$notafiscal);
        return NotaFiscalResource::make($notafiscal);
    }

    public function update(NotaFiscalUpdateRequest $request)
    {
        $notafiscal = NotaFiscal::find($request->id);
        Gate::authorize("view",$notafiscal);

        $notafiscais = NotaFiscal::where('numero',$request->numero)
            ->where('id','!=',$notafiscal->id)
            ->first();

        if($notafiscais) {
            return response()->json(["message" => "Número da nota fiscal ja cadastrado"],409);
        }

        DB::beginTransaction();
        try {
            $notafiscal->numero = $request->numero;
            $notafiscal->valor = $request->valor;
            $notafiscal->data_emissao = $request->data_emissao;
            $notafiscal->cnpj_remetente = $request->cnpj_remetente;
            $notafiscal->nome_remetente = $request->nome_remetente;
            $notafiscal->cnpj_transportador = $request->cnpj_transportador;
            $notafiscal->nome_transportador = $request->nome_transportador;
            $notafiscal->save();
            DB::commit();

            return NotaFiscalResource::make($notafiscal);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    public function delete(NotaFiscalViewRequest $request)
    {
        $notafiscal = NotaFiscal::find($request->nota);
        Gate::authorize("view",$notafiscal);

        if($notafiscal) {
            $notafiscal->delete();
            return response()->json(["message" => "Nota fiscal deletada"]);
        }
        return response()->json(["message" => "Ocorreu um problema, tente novamente"],500);
    }
}
