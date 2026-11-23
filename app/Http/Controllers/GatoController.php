<?php

namespace App\Http\Controllers;

use App\Models\Partida;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GatoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $jugadores = User::whereIn('role', ['Jugador', 'Administrador'])->get();

        $partidasDisponibles = Partida::with('jugadorX')
            ->where('estado', 'esperando')
            ->where('jugador_x_id', '!=', $user->id)
            ->latest()
            ->get();

        $misPartidas = $user->role === 'Administrador'
            ? Partida::with(['jugadorX', 'jugadorO'])->latest()->get()
            : Partida::with(['jugadorX', 'jugadorO'])
                ->where(fn($q) => $q->where('jugador_x_id', $user->id)->orWhere('jugador_o_id', $user->id))
                ->latest()
                ->get();

        return view('gato.index', compact('jugadores', 'partidasDisponibles', 'misPartidas'));
    }

    public function store()
    {
        $partida = Partida::create([
            'jugador_x_id' => auth()->id(),
            'tablero' => '---------',
            'turno' => 'X',
            'estado' => 'esperando',
        ]);

        return redirect()->route('gato.show', $partida);
    }

    public function unirse(Partida $partida)
    {
        $userId = auth()->id();

        DB::transaction(function () use ($partida, $userId) {
            $p = Partida::where('id', $partida->id)->lockForUpdate()->first();

            if ($p->estado !== 'esperando' || $p->jugador_x_id === $userId) {
                return;
            }

            $p->update([
                'jugador_o_id' => $userId,
                'estado' => 'en_curso',
            ]);
        });

        return redirect()->route('gato.show', $partida);
    }

    public function show(Partida $partida)
    {
        $partida->load(['jugadorX', 'jugadorO']);
        $user = auth()->user();

        $esParticipante = $partida->jugador_x_id === $user->id || $partida->jugador_o_id === $user->id;
        if (!$esParticipante && $user->role !== 'Administrador') {
            abort(403, 'No formas parte de esta partida.');
        }

        return view('gato.show', compact('partida'));
    }

    public function estado(Partida $partida)
    {
        $partida->load(['jugadorX:id,name', 'jugadorO:id,name']);
        return response()->json([
            'tablero' => str_split($partida->tablero),
            'turno' => $partida->turno,
            'estado' => $partida->estado,
            'jugador_x' => $partida->jugadorX->name,
            'jugador_o' => $partida->jugadorO?->name ?? 'Esperando rival...',
        ]);
    }

    public function mover(Request $request, Partida $partida)
    {
        $request->validate([
            'casilla' => 'required|integer|min:0|max:8',
        ]);

        $userId = auth()->id();
        $casilla = (int) $request->casilla;

        return DB::transaction(function () use ($partida, $userId, $casilla) {
            $p = Partida::where('id', $partida->id)->lockForUpdate()->first();

            if ($p->estado !== 'en_curso') {
                return response()->json(['error' => 'La partida no está en curso.'], 422);
            }

            $simbolo = null;
            if ($p->jugador_x_id === $userId) {
                $simbolo = 'X';
            } elseif ($p->jugador_o_id === $userId) {
                $simbolo = 'O';
            } else {
                return response()->json(['error' => 'No perteneces a esta partida.'], 403);
            }

            if ($p->turno !== $simbolo) {
                return response()->json(['error' => 'No es tu turno.'], 422);
            }

            $tablero = str_split($p->tablero);
            if ($tablero[$casilla] !== '-') {
                return response()->json(['error' => 'Esa casilla ya está ocupada.'], 422);
            }

            $tablero[$casilla] = $simbolo;
            $nuevoTablero = implode('', $tablero);

            $nuevoEstado = $this->evaluarEstado($tablero, $simbolo);
            $siguienteTurno = $simbolo === 'X' ? 'O' : 'X';

            $p->update([
                'tablero' => $nuevoTablero,
                'turno' => $siguienteTurno,
                'estado' => $nuevoEstado,
            ]);

            return response()->json(['ok' => true, 'estado' => $nuevoEstado]);
        });
    }

    public function abandonar(Partida $partida)
    {
        $user = auth()->user();

        if ($user->role === 'Administrador') {
            $partida->update(['estado' => 'cancelada']);
            return back()->with('success', 'Partida cancelada por el Administrador.');
        }

        if ($partida->jugador_x_id === $user->id && in_array($partida->estado, ['esperando', 'en_curso'])) {
            $partida->update(['estado' => $partida->jugador_o_id ? 'ganador_o' : 'cancelada']);
        } elseif ($partida->jugador_o_id === $user->id && $partida->estado === 'en_curso') {
            $partida->update(['estado' => 'ganador_x']);
        }

        return redirect()->route('gato.index')->with('success', 'Has abandonado la partida.');
    }

    private function evaluarEstado(array $t, string $simbolo): string
    {
        $lineas = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8],
            [0, 3, 6], [1, 4, 7], [2, 5, 8],
            [0, 4, 8], [2, 4, 6],
        ];

        foreach ($lineas as [$a, $b, $c]) {
            if ($t[$a] === $simbolo && $t[$b] === $simbolo && $t[$c] === $simbolo) {
                return $simbolo === 'X' ? 'ganador_x' : 'ganador_o';
            }
        }

        if (!in_array('-', $t, true)) {
            return 'empate';
        }

        return 'en_curso';
    }
}