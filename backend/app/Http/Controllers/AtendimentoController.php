<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtendimentoController extends Controller
{
    public function painel()
    {
        $chamadoAtual = Atendimento::where('status', 'chamado')
            ->with('paciente')
            ->orderBy('data_inicio', 'desc')
            ->first();

        $proximos = Atendimento::where('status', 'aguardando')
            ->with('paciente')
            ->orderBy('data_inicio', 'asc')
            ->limit(5)
            ->get();

        $fila = Atendimento::where('status', 'aguardando')
            ->orderBy('data_inicio', 'asc')
            ->with('paciente')
            ->get();

        return view('chamadas.painel', [
            'chamadoAtual' => $chamadoAtual,
            'proximos' => $proximos,
            'fila' => $fila
        ]);
    }

    public function chamarProximo(Request $request)
    {
        $consultorio = $request->consultorio;
        $medicoId = $request->medico_id;

        $proximo = DB::transaction(function () use ($consultorio, $medicoId) {

            $proximo = Atendimento::where('status', 'aguardando')
                ->orderBy('data_inicio', 'asc')
                ->lockForUpdate()
                ->first();

            if ($proximo) {
                $proximo->update([
                    'status' => 'chamado',
                    'consultorio' => $consultorio,
                    'medico_id' => $medicoId
                ]);
            }

            return $proximo;
        });

        if (!$proximo) {
            return response()->json([
                'message' => 'Nenhum paciente aguardando'
            ], 404);
        }

        return response()->json([
            'message' => 'Paciente chamado com sucesso!',
            'paciente' => $proximo->paciente
        ]);
    }

    public function finalizar($id)
    {
        $atendimento = Atendimento::findOrFail($id);
    
        $atendimento->update([
            'status' => 'finalizado',
            'data_fim' => now()
        ]);
    
        return response()->json([
            'message' => 'Atendimento finalizado com sucesso!'
        ]);
    }


}