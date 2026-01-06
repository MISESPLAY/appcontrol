<x-layout title="Organigrama"
          encabezado="Departamentos">

    <div
        id="tabla-colores"
        {{--ORGANIGR4--}}
        data-url="{{ route('organigrama.colors') }}"
        class="grid-container"
    >
        <p>Esperando datos...</p>
    </div>
    <div id="app-crm" data-base-url="https://misitio.com/storage/crm/">

        <button id="btn-cargar">Cargar Perfil CRM</button>
        <div id="perfil-container"></div>

    </div>

    @vite('resources/js/organigrama/initialize.js')

</x-layout>
