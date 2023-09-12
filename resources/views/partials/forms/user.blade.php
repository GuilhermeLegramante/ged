<div class="row">
    @include('partials.inputs.text', [
    'columnSize' => 12,
    'label' => 'Nome*',
    'model' => 'name',
    ])
</div>
<div class="row">
    @include('partials.inputs.text', [
    'columnSize' => 12,
    'label' => 'Login*',
    'model' => 'login',
    ])
</div>
<div class="row">
    @include('partials.inputs.text', [
    'columnSize' => 12,
    'label' => 'E-mail',
    'model' => 'email',
    ])
</div>
<div class="row">
    @include('partials.inputs.text', [
    'columnSize' => 12,
    'label' => 'Senha*',
    'model' => 'password',
    'isPassword' => true,
    ])
</div>
<div class="row">
    @include('partials.inputs.text', [
    'columnSize' => 12,
    'label' => 'Confirmação da Senha*',
    'model' => 'password_confirmation',
    'isPassword' => true,
    ])
</div>
<div class="row">
    @include('partials.inputs.select', [
    'columnSize' => 3,
    'label' => 'Administrador*',
    'model' => 'isAdmin',
    'options' => [['value' => 1, 'description' => 'SIM'], ['value' => 0, 'description' => 'NÃO']],
    ])
</div>
<p><small>*campos obrigatórios</small></p>
