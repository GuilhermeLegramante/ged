<hr>
<div class="hide col-gray">
    <div class="row mb-2">
        <div class="col-md-12 text-center">
            <p><strong>{{ session()->get('clientName') }}</strong></p>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-12 text-center">
            <p>Usuário logado: {{ session()->get('username') }}
                @if (Session::has('operationDate'))
                    Data de Operação:
                    {{ date('d/m/Y', strtotime(Session::get('operationDate'))) }}
                @endif
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <p class="fs-90">Desenvolvido por HardSoft Informática &copy; - Todos os direitos reservados</p>
        </div>
    </div>
</div>
