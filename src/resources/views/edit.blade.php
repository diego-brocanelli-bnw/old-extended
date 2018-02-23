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

    @if ($errors->any())

        <div class="alert alert-warning">
            
            @foreach ($errors->all() as $error)
                <i class="fa fa-angle-right"></i> {{ $error }} <br>
            @endforeach
            
        </div>

    @endif

    <hr>

    <form method="post" action="{{ route('old-extended.update') }}">

        {{ csrf_field() }}

        {{ method_field('PUT') }} 
        {{-- https://laravel.com/docs/5.5/controllers#resource-controllers --}}

        @php

            $model = (object) [
                'old_common' => 'Extended',
                'old_option' => '2',
                'old_check'  => 'no',
                'old_radio'  => '2',
                ];

        @endphp

        <div class="row">

            <div class="col form-group">

                <label>Old</label>
                <input name="old_common" type="text" value="{{ old('old_common', $model->old_common) }}"
                       class="form-control" placeholder="Digite valor">
                <small class="form-text text-muted">Helper old() do Laravel</small>
            </div>

            <div class="col form-group">

                <label>Old Option</label>
                <select name="old_option" class="form-control">
                        @foreach([1=>'Opção Um', 2=>'Opção Dois', 3=>'Opção Três',] as $option_value => $label)
                        <option value="{{ $option_value }}" {{ old_option('old_option', $option_value, $model->old_option) }}>{{ $label }} Origem {{ old_debug_origin() }}</option>
                        @endforeach
                </select>
                <small class="form-text text-muted">Helper old_option() para selects</small>

            </div>

            <div class="col form-group">

                <label>Old Check</label>
                <br>
                <input type="checkbox" name="old_check" 
                       value="yes" {{ old_check('old_check', 'yes', $model->old_check) }}>
                Origem {{ old_debug_origin() }}
                <small class="form-text text-muted">Helper old_check() para checkboxes - Origem {{ old_debug_origin() }}</small>

            </div>

            <div class="col form-group">

                <label>Old Radio</label>

                <br>

                <input type="radio" name="old_radio" 
                       value="1" {{ old_radio('old_radio', 1, $model->old_radio) }}>
                Origem {{ old_debug_origin() }}

                <br>

                <input type="radio" name="old_radio" 
                       value="2" {{ old_radio('old_radio', 2, $model->old_radio) }}>
                Origem {{ old_debug_origin() }}

                <br>

                <input type="radio" name="old_radio" 
                       value="3" {{ old_radio('old_radio', 3, $model->old_radio) }}> 
                Origem {{ old_debug_origin() }}

                <small class="form-text text-muted">Helper old_radio() para radioboxes</small>

            </div>
            
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