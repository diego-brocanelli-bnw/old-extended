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

                'old_date'   => '1980-01-10',
                'old_datetime'   => '1980-01-10 10:10:10',
                ];

        @endphp

        @if (session()->has('_old_input'))
        
            <div class="alert alert-info">

                <h4 class="alert-heading">Dados após tratamento pela requisição!</h4>

                <p>
                    @foreach(session('_old_input') as $key => $value)
                        @if(!in_array($key, ['_token', '_method']))
                        - <b>{{ $key }}</b>: {{ $value }} <br>
                        @endif
                    @endforeach
                </p>
            </div>

        @endif

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

                <label>Old Date</label>
                <input name="old_date" class="form-control" value="{{ old_date('old_date', $model->old_date) }}">
                <small class="form-text text-muted">Helper old_date() para datas</small>

            </div>

            <div class="col form-group">

                <label>Old Datetime</label>
                <input name="old_datetime" class="form-control" 
                       value="{{ old_datetime('old_datetime', $model->old_datetime) }}">
                <small class="form-text text-muted">Helper old_datetime() para datas</small>

            </div>

        </div>

        <div class="row">

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

            <div class="col form-group">
            </div>

            <div class="col form-group">
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