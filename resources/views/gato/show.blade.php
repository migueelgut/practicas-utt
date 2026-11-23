<x-layouts.app title="Partida #{{ $partida->id }}">
    <div class="max-w-sm mx-auto bg-white border border-gray-300 rounded p-6 text-center">
        <div class="flex justify-between items-center mb-4 text-xs text-gray-500">
            <a href="{{ route('gato.index') }}" class="underline">&larr; Volver</a>
            <span>Partida #{{ $partida->id }}</span>
        </div>

        <h1 class="text-lg font-bold text-gray-900 mb-3">Tablero</h1>

        <div class="grid grid-cols-2 gap-2 border border-gray-300 bg-gray-50 rounded p-2 mb-4 text-xs">
            <div>
                <strong>Jugador X:</strong>
                <p id="nombre-x">{{ $partida->jugadorX->name }}</p>
            </div>
            <div>
                <strong>Jugador O:</strong>
                <p id="nombre-o">{{ $partida->jugadorO?->name ?? 'Esperando rival...' }}</p>
            </div>
        </div>

        <div id="banner-estado" class="mb-4 py-1.5 px-3 border border-gray-300 bg-gray-100 rounded text-xs font-semibold">
            Esperando al Jugador O...
        </div>

        <div id="alerta-error" class="hidden mb-4 py-1.5 px-3 border border-red-300 bg-red-50 text-red-700 rounded text-xs"></div>

        <div style="display: grid; grid-template-columns: repeat(3, 80px); gap: 8px; justify-content: center; margin: 16px auto;">
            @for($i = 0; $i < 9; $i++)
                <button type="button"
                    data-index="{{ $i }}"
                    onclick="hacerMovimiento({{ $i }})"
                    style="width: 80px; height: 80px;"
                    class="casilla border border-gray-400 bg-white hover:bg-gray-100 text-3xl font-bold flex items-center justify-center cursor-pointer">
                </button>
            @endfor
        </div>

        <form action="{{ route('gato.abandonar', $partida) }}" method="POST" class="mt-4">
            @csrf @method('PATCH')
            <button type="submit" class="px-3 py-1.5 border border-gray-300 rounded text-xs text-red-700 hover:bg-gray-100 cursor-pointer">
                Abandonar Partida
            </button>
        </form>
    </div>

    <script>
        const estadoUrl = "{{ route('gato.estado', $partida) }}";
        const moverUrl = "{{ route('gato.mover', $partida) }}";
        const csrfToken = "{{ csrf_token() }}";

        function actualizarTablero() {
            fetch(estadoUrl)
                .then(r => r.json())
                .then(data => {
                    document.getElementById('nombre-x').textContent = data.jugador_x;
                    document.getElementById('nombre-o').textContent = data.jugador_o;

                    const botones = document.querySelectorAll('.casilla');
                    data.tablero.forEach((val, idx) => {
                        botones[idx].textContent = val === '-' ? '' : val;
                    });

                    const banner = document.getElementById('banner-estado');
                    const mensajes = {
                        'esperando': 'Esperando al Jugador O...',
                        'en_curso': `En curso — Turno: ${data.turno}`,
                        'ganador_x': 'Fin del juego: Ganó Jugador X',
                        'ganador_o': 'Fin del juego: Ganó Jugador O',
                        'empate': 'Fin del juego: Empate',
                        'cancelada': 'Partida cancelada'
                    };
                    banner.textContent = mensajes[data.estado] || data.estado;
                });
        }

        function hacerMovimiento(casilla) {
            const alerta = document.getElementById('alerta-error');
            alerta.classList.add('hidden');

            fetch(moverUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ casilla })
            })
            .then(async res => {
                const data = await res.json();
                if (!res.ok) {
                    alerta.textContent = data.error || 'Movimiento inválido';
                    alerta.classList.remove('hidden');
                }
                actualizarTablero();
            });
        }

        actualizarTablero();
        setInterval(actualizarTablero, 1500);
    </script>
</x-layouts.app>