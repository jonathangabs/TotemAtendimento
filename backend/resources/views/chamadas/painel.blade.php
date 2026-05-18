<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Painel de Chamada</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root {
    --highlight: #f1c40f;
    --success: #27ae60;
}

body {
    margin: 0;
    height: 100vh;
    overflow: hidden;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.main-container {
    display: flex;
    height: 100vh;
}

.content {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px;
}

.card-call {
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.3);
    border-radius: 25px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 40px;
}

.titulo {
    font-size: 3vw;
    font-weight: bold;
    margin-bottom: 30px;
}

.senha {
    font-size: 9vw;
    font-weight: bold;
    color: var(--highlight);
    animation: pulse 1.5s infinite;
}

.nome {
    font-size: 3vw;
    margin-top: 20px;
}

.consultorio {
    font-size: 3.5vw;
    margin-top: 15px;
    color: var(--success);
}

.acoes {
    margin-top: 30px;
}

.btn-historico {
    display: inline-block;
    padding: 15px 28px;
    border-radius: 12px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    color: white;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}

.btn-historico:hover {
    background: rgba(255,255,255,0.25);
}

.sidebar {
    width: 350px;
    background: rgba(0,0,0,0.2);
    padding: 30px;
}

.sidebar h3 {
    text-align: center;
    margin-bottom: 25px;
}

.next {
    background: rgba(255,255,255,0.1);
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 15px;
    text-align: center;
}

.next .senha-next {
    font-size: 2.5vw;
    font-weight: bold;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
</style>
</head>

<body>

<div class="main-container">

    <!-- CONTEÚDO PRINCIPAL -->
    <div class="content">

        <div class="card-call">

            <div class="titulo">
                PAINEL DE CHAMADA
            </div>

            @if($chamadoAtual)
                <div class="senha">
                    {{ $chamadoAtual->paciente->senha }}
                </div>

                <div class="nome">
                    {{ $chamadoAtual->paciente->nome }}
                </div>

                <div class="consultorio">
                    Consultório {{ $chamadoAtual->consultorio ?? '---' }}
                </div>
            @else
                <div class="senha">
                    ---
                </div>

                <div class="nome">
                    Nenhum paciente sendo chamado
                </div>

                <div class="consultorio">
                    Aguarde...
                </div>
            @endif

            <div class="acoes">
                <a href="{{ route('chamadas.historico') }}" class="btn-historico">
                    VISUALIZAR ÚLTIMAS CHAMADAS
                </a>
            </div>

        </div>

    </div>

    <!-- SIDEBAR -->
    <div class="sidebar">

        <h3>
            PRÓXIMAS SENHAS
        </h3>

        @forelse($proximos as $prox)
            <div class="next">
                <div class="senha-next">{{ $prox->paciente->senha }}</div>
                <div>{{ $prox->paciente->nome }}</div>
            </div>
        @empty
            <div class="next">
                <div class="senha-next">---</div>
                <div>Nenhum paciente aguardando</div>
            </div>
        @endforelse

    </div>

</div>

</body>
</html>