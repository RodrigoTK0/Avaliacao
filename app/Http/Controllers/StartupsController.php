<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StartupsController extends Controller
{
    public function index(): View
    {
        $startups = Startup::all();
        return view('index', compact('startups'));
    }

    public function create(): View
    {
        return view('create');
    }

    public function store(Request $request)
    {
    $dados = $request->validate([
        'nome'          => 'required|string|max:255',
        'email_contato' => 'required|email',
        'setor'         => 'nullable|string',
    ]);

    $dados['data_cadastro'] = now();
    $startup = Startup::create($dados);

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'startup' => [
                'nome' => $startup->nome,
                'setor' => $startup->setor ?? 'Não informado',
                'email_contato' => $startup->email_contato,
                'data_cadastro' => $startup->data_cadastro->format('d/m/Y H:i')
            ]
        ]);
    }

    return redirect()->route('index');
    }

    public function update(Request $request, $id)
    {
    $startup = Startup::findOrFail($id);
    
    $dados = $request->validate([
        'nome'          => 'required|string|max:255',
        'email_contato' => 'required|email',
        'setor'         => 'nullable|string',
    ]);

    $startup->update($dados);

    return response()->json([
        'success' => true,
        'startup' => [
            'id'    => $startup->id,
            'nome'  => $startup->nome,
            'setor' => $startup->setor ?? 'Não informado',
            'email_contato' => $startup->email_contato,
        ]
    ]);
    }

    public function destroy($id)
    {
        $startup = Startup::findOrFail($id);
        $startup->delete();

        return response()->json(['success' => true]);
    }
}