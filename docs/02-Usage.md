# 2. Como Usar

## Sobre o Old Input

Na [documentação oficial do Laravel](https://laravel.com/docs/5.6/requests#old-input), encontra-se o método ***old***, disponível no objeto Request, responsável pelas informações da requisição. Para facilitar o uso deste método, existe um helper global com o mesmo nome ***old***, ideal para ser chamado dentro de templates blade.

Explicando resumidamente, o ***old*** devolve o valor de um campo após a última submissão do formulário.

Imagine que em um formulário alguém digite qualquer coisa em um input cujo nome seja ***email***. Após digitar e submeter o formulário, se o e-mail for classificado como inválido, o proceso de validação ira redirecionar o usuário de volta para o formulário e também disponibilizará os dados digitados para que o usuário não precise digitar tudo de novo.

Estes dados já digitados são acessados através do old, bastando especificar o nome do campo a ser devolvido:

```text
<input type="text" name="email" value="{{ old('email') }}">
```

O atributo ***value*** vai receber o texto que o usuário tinha digitado antes da submissão do formulário, ou um valor vazio (null), se o usuário não digitou nada.

É possível especificar um segundo parâmetro com o valor padrão, caso o usuário não digitar nada:

```text
<input type="text" name="email" value="{{ old('email', 'meuemail@gmail.com') }}">
```

> **Nota:** Especificar um valor padrão é muito útil para formulários de edição, onde este valor deverá ser proveniente do banco de dados


## Old's especiais

O pacote Old Extended foi desenvolvido para o mesmo propósito, adicionando mais funcionalidades e tornando a programação do formulário mais limpa e fácil de entender.

> **Nota:** Para explicar as funcionalidades, consideraremos a implementação de um formulário para edição, contendo uma variável chamada ***$model***, que contém todos os campos provenientes do banco de dados.

## old_option

```php
old_option($key, $option_value = null, $stored_value = null);
```

Campos do tipo select possuem opções, que ao serem escolhidas pelo usuário, são marcadas com o atributo ***selected***. 

Usando o ***old padrão*** do Laravel, ficaria assim:

```text
<div>

    <label>Categoria</label>
    
    <select name="category_id">

        @foreach($categories as $item)

            @if( old('category_id', $item->id) === $model->category_id )

                <option value="{{ $item->id }}" selected>
                {{ $item->label }}
                </option>
                
            @else

                <option value="{{ $item->id }}">
                {{ $item->label }}
                </option>

            @endif
        
        @endforeach
        
    </select>

</div>
```

Com o ***old_option***, por ficar mais conciso, basta adicionar diretamente no local onde o selected deverá aparecer:

```text
<div>

    <label>Categoria</label>
    
    <select name="category_id">

        @foreach($categories as $item)
        
            <option value="{{ $item->id }}" {{ old_option('category_id', $item->id, $model->category_id) }}>
            {{ $item->label }}
            </option>
        
        @endforeach
        
    </select>

</div>
```

## old_radio

```php
old_radio($key, $input_value = null, $stored_value = null);
```

Campos input do tipo radio são opções, que ao serem clicadas pelo usuário, são marcadas com o atributo ***checked***. 

Usando o ***old padrão*** do Laravel, ficaria assim:

```text
<div>

    <label>Status</label>

    <br>

    @if(old('status') == 'active' || $model->status == 'active')
    
        <input type="radio" name="status" value="active" checked>
        
    @else
    
        <input type="radio" name="status" value="active">
        
    @endif

    <br>

    @if(old('status') == 'inactive' || $model->status == 'inactive')
    
        <input type="radio" name="status" value="inactive" checked>
        
    @else
    
        <input type="radio" name="status" value="inactive">
        
    @endif
    
</div>
```

Com o ***old_radio***, por ficar mais conciso, basta adicionar diretamente no local onde o checked deverá aparecer:

```text
<div>

    <label>Status</label>

    <br>
    
    <input type="radio" name="status" value="active" {{ old_radio('status', 'active', $model->status) }}>
    
    <br>
    
    <input type="radio" name="status" value="inactive" {{ old_radio('status', 'inactive', $model->status) }}>
    
</div>
```


## old_check

```php
old_check($key, $input_value = null, $stored_value = null);
```

Campos input do tipo checkbox são opções, que ao serem clicadas pelo usuário, são marcadas com o atributo ***checked***. 

Usando o ***old padrão*** do Laravel, ficaria assim:

```text
<div>

    <label>Receber Notificações</label>
    
    <br>

    @if(old('notify') == 'yes' || $model->notify == 'yes')
    
        <input type="checkbox" name="notify" value="yes" checked>
        
    @else
    
        <input type="checkbox" name="notify" value="yes">
        
    @endif

</div>
```

Com o ***old_check***, por ficar mais conciso, basta adicionar diretamente no local onde o checked deverá aparecer:

```text
<div>

    <label>Receber Notificações</label>
    
    <br>

    <input type="checkbox" name="notify" value="yes" {{ old_check('notify', 'yes', $model->notify) }}>

</div>
```


## old_date

```php
old_date($key, $stored_value = null, $stored_format = 'Y-m-d', $show_format = 'd/m/Y');
```

O helper ***old_date*** funciona como o old padrão do Laravel, porém com transformação de datas. 

É muito comum, nos campos de formulário, utilizar máscaras para datas no formato brasileiro (10/01/1980), e no momento da gravação, transformá-las para o formato de banco de dados (1980-01-10). O ***old_date*** faz estre trabalho automaticamente. Para usar é preciso dois passos:

### Passo 1: 

O primeiro passo é declarar o old_date normalmente no blade:

```text
<div>

    <label>Data de Nascimento</label>
    
    <input type="text" name="birth" value="{{ old_date('birth', $model->birth) }}">

</div>
```

O código acima recebe o formato ***10/01/1980*** do formulário e transforma para ***1980-01-10*** no momento da gravação.

É possível também especificar o formato de gravação e o formato do formulário, bastando acrescentar parâmetros adicionais ao helper:

```text
<div>

    <label>Data de Nascimento</label>
    
    <input type="text" name="birth" value="{{ old_date('birth', $model->birth, 'Y-m-d', 'd/m/Y') }}">

</div>
```

### Passo 2: 

O segundo passo é personalizar a requisição recebida pelo formulário no controlador. Isso é necessário para que o old_date possa transformar as datas configuradas no blade sem fazer rotinas adicionais.

Basta trocar a invocação normal nos métodos de gravação de ***\Illuminate\Http\Request*** para ***\OldExtended\Http\Requests\ExtendedRequest***:

```php
use OldExtended\Http\Requests\ExtendedRequest;

class ExampleController extends Controller
{
    public function store(ExtendedRequest $form)
    {
        // ...
    }
    
    public function update(ExtendedRequest $form)
    {
        // ...
    }

    public function delete(ExtendedRequest $form)
    {
        // ...
    }
}
```
O objeto ExtendedRequest detecta automaticamente os campos corretos e os transforma no momento da requisição com base nos parâmetros de transformação passados no formulário com o helper ***old_date***.

## old_datetime

```php
old_datetime($key, $stored_value = null, $stored_format = 'Y-m-d H:i:s', $show_format = 'd/m/Y H:i:s');
```

O old_datetime faz a mesmíssica coisa que o old_date. A única diferença se encontra nos formatos padrões, que já aceitam as horas, minutos e segundos.

Em outras palavras:

```text
<input type="text" name="birth" value="{{ old_datetime('birth', $model->birth) }}">
```

é o mesmo que:

```text
<input type="text" name="birth" value="{{ old_date('birth', $model->birth, 'Y-m-d H:i:s', 'd/m/Y H:i:s') }}">
```

## date_transform

Transforma uma data de um formato para outro. Por exemplo, '10/01/1980' para '1980-01-10'.

```php
date_transform($date_value, $format_origin = 'd/m/Y H:i:s', $format_destiny = 'Y-m-d H:i:s');
```

## Sumário

1. [Sobre](00-Home.md)
2. [Instalação](01-Installation.md)
3. [Como Usar](02-Usage.md)
4. [Exemplos](03-Examples.md)
5. [Extras](04-Extras.md)

...