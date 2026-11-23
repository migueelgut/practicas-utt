<x-layouts.app title="Panel Principal">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Bienvenido, {{ auth()->user()->name }}</h1>
                <p class="text-slate-600 text-sm mt-1">
                    Sistema Integral de Prácticas — Ingeniería en Desarrollo y Gestión de Software (UTT)
                </p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                Rol activo: {{ auth()->user()->role }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Práctica 1.1 & 1.2</span>
            <h2 class="text-lg font-bold text-slate-800 mt-1">Control de Acceso y Usuarios</h2>
            <p class="text-sm text-slate-600 mt-2">Autenticación en 3 etapas para administrador, roles dinámicos y Soft Deletes.</p>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Práctica 1.3 & 1.4</span>
            <h2 class="text-lg font-bold text-slate-800 mt-1">Académico y Productos</h2>
            <p class="text-sm text-slate-600 mt-2">Cálculo de equivalencias, ordenamiento multinivel, filtros combinados y paginación.</p>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Práctica 1.5 & 1.6</span>
            <h2 class="text-lg font-bold text-slate-800 mt-1">Sesiones y Concurrencia</h2>
            <p class="text-sm text-slate-600 mt-2">Reservación de equipos con bloqueo pesimista y juego multijugador en tiempo real.</p>
        </div>
    </div>
</x-layouts.app>