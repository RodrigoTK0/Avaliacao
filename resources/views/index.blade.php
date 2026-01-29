@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
    <h1 class="h2 mb-0">🚀 Startups</h1>
    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCadastro">
        <i class="bi bi-plus-lg"></i> Cadastrar Startup
    </button>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0"> <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>Setor</th>
                        <th>E-mail</th>
                        <th>Data</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody id="tabela-corpo">
                    @foreach($startups as $startup)
                    <tr id="linha-{{ $startup->id }}">
                        <td class="td-nome fw-bold">{{ $startup->nome }}</td>
                        <td class="td-setor"><span class="badge bg-secondary opacity-75">{{ $startup->setor ?? 'Geral' }}</span></td>
                        <td class="td-email text-muted">{{ $startup->email_contato }}</td>
                        <td class="td-data small text-nowrap">
                            {{ $startup->data_cadastro ? $startup->data_cadastro->format('d/m/Y') : '-' }}
                        </td>
                        <td class="text-end text-nowrap">
                            <button class="btn btn-sm btn-outline-warning me-1" onclick="abrirEdicao({{ $startup->id }}, '{{ $startup->nome }}', '{{ $startup->setor }}', '{{ $startup->email_contato }}')">Editar</button>
                            <button class="btn btn-sm btn-outline-danger" onclick="excluirStartup({{ $startup->id }})">Excluir</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCadastro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formStartup">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Nova Startup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Setor</label>
                        <input type="text" name="setor" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email_contato" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Cadastar Startup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdicao" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEdicao">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-id">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Startup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Nome</label><input type="text" id="edit-nome" name="nome" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Setor</label><input type="text" id="edit-setor" name="setor" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">E-mail</label><input type="email" id="edit-email" name="email_contato" class="form-control" required></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Salvar Alterações</button></div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('formStartup').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch("{{ route('store') }}", {
            method: "POST",
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const tbody = document.getElementById('tabela-corpo');
                const novaLinha = `
                    <tr id="linha-${data.startup.id}">
                        <td class="td-nome fw-bold">${data.startup.nome}</td>
                        <td class="td-setor"><span class="badge bg-secondary opacity-75">${data.startup.setor || 'Geral'}</span></td>
                        <td class="td-email text-muted">${data.startup.email_contato}</td>
                        <td class="td-data small text-nowrap">${data.startup.data_cadastro}</td>
                        <td class="text-end text-nowrap">
                            <button class="btn btn-sm btn-outline-warning me-1" onclick="abrirEdicao(${data.startup.id}, '${data.startup.nome}', '${data.startup.setor}', '${data.startup.email_contato}')">Editar</button>
                            <button class="btn btn-sm btn-outline-danger" onclick="excluirStartup(${data.startup.id})">Excluir</button>
                        </td>
                    </tr>`;
                tbody.insertAdjacentHTML('afterbegin', novaLinha);
                bootstrap.Modal.getInstance(document.getElementById('modalCadastro')).hide();
                this.reset();
            }
        });
    });

    function excluirStartup(id) {
        if (confirm('Deseja realmente excluir esta startup?')) {
            fetch(`/startups/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const el = document.getElementById(`linha-${id}`);
                    el.style.transition = "0.3s";
                    el.style.opacity = "0";
                    setTimeout(() => el.remove(), 300); // Efeito visual de saída
                }
            });
        }
    }

    const modalEdicaoBS = new bootstrap.Modal(document.getElementById('modalEdicao'));
    function abrirEdicao(id, nome, setor, email) {
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-nome').value = nome;
        document.getElementById('edit-setor').value = setor;
        document.getElementById('edit-email').value = email;
        modalEdicaoBS.show();
    }

    document.getElementById('formEdicao').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('edit-id').value;
        const formData = new FormData(this);

        fetch(`/startups/${id}`, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                const linha = document.getElementById(`linha-${id}`);
                linha.querySelector('.td-nome').innerText = data.startup.nome;
                linha.querySelector('.td-setor').innerHTML = `<span class="badge bg-secondary opacity-75">${data.startup.setor}</span>`;
                linha.querySelector('.td-email').innerText = data.startup.email_contato;
                modalEdicaoBS.hide();
            }
        });
    });
</script>
@endsection