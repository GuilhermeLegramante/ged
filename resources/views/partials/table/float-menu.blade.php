@if ($hasForm)
<div id="menu-rapido" class="fab z-index-9999999">
    <button class="main"></button>
    <ul>
        {{-- <li>
            <label for="">Print Tela</label> <br>
            <button wire:ignore onClick="printFormulario();" id="opcao2">
                <i class="fa fa-print" aria-hidden="true"></i>
            </button>
        </li> --}}
        {{-- <li>
            <label for="">Listagem</label>
            <button id="opcao3" wire:click="list">
                <i class="fas fa-file-pdf" aria-hidden="true"></i>
            </button>
        </li> --}}
        <li>
            <label>Novo Registro</label>
            <button id="opcao3" wire:click="showForm()">
                <i class="fas fa-plus" aria-hidden="true"></i>
            </button>
        </li>
    </ul>
</div>
@endif
