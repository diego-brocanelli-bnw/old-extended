@component('old-extended::document')

    @slot('title') Formulário @endslot

    <div class="row mb-3">

        <div class="col">

            {{-- ... --}} 

        </div>

        <div class="col text-right justify-content-end">

            <a href="javascript:void()" class="btn btn-success"
               title="Botão de Ação">
                <i class="fa fa-plus"></i>
                <span class="d-none d-lg-inline">Botão de Ação</span>
            </a>

        </div>
        
    </div>

    <hr>

    <form method="post" action="{{ route('old-extended.update') }}">

        {{ csrf_field() }}

        {{ method_field('PUT') }} 
        {{-- https://laravel.com/docs/5.5/controllers#resource-controllers --}}

        <div class="row">

            <div class="col form-group">

                <label>Nome</label>
                <input name="name" type="text" value="{{ old('name') }}"
                       class="form-control" placeholder="Digite o nome"
                       required>
                <small class="form-text text-muted">O nome legível do usuário</small>
            </div>

            <div class="col form-group">

                <label>Description</label>
                <input name="description" type="text" value="{{ old('description') }}"
                       class="form-control" 
                       required>
                <small class="form-text text-muted">Uma descrição curta para o grupo</small>
            </div>

            <input type="hidden" name="system" value="no">
            
        </div>

        <div class="row">

            <div class="col">

                 <button type="submit" class="btn btn-success"
                   title="Botão de Ação">
                    <i class="fa fa-plus"></i>
                    <span class="d-none d-lg-inline">Submeter</span>
                </button>

            </div>

        </div>

    </form>

@endcomponent